<?php


namespace App\Service;


use App\Entity\File;
use App\Entity\Post;
use App\Util\PathHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{

    const ALLOWED_FILE_EXTENSIONS = [
        'rtf',
        'odf',
        'doc',
        'docx',
        'xls',
        'xlsx',
        'pdf',
        'png',
        'jpeg',
        'jpg',
        'webp'
    ];

    const IMAGE_EXTENSIONS = [
        'png',
        'jpeg',
        'jpg',
        'webp'
    ];

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var string
     */
    private $targetDirectory;

    /**
     * @var int
     */
    private $maxSizeInBytes;

    /**
     * @var int
     */
    private $maxSizeInMegabytes;

    /**
     * @var string
     */
    private $projectDir;

    public function __construct(EntityManagerInterface $em, string $targetDirectory, int $maxSize, string $projectDir)
    {
        $this->em = $em;
        $this->targetDirectory = $targetDirectory . DIRECTORY_SEPARATOR;
        $this->maxSizeInMegabytes = $maxSize;
        $this->maxSizeInBytes = $this->maxSizeInMegabytes * 2**20;
        $this->projectDir = $projectDir;
    }

    /**
     * Returns true if file has allowed extension, otherwise returns false.
     * @param UploadedFile $file
     * @return bool
     */
    public function isExtensionValid(UploadedFile $file)
    {
        return in_array($file->guessExtension(), self::ALLOWED_FILE_EXTENSIONS);
    }

    /**
     * Returns true if file is less or equal than max allowed size, otherwise returns false.
     * @param UploadedFile $file
     * @return bool
     */
    public function isSizeValid(UploadedFile $file)
    {
        return $file->getSize() <= $this->maxSizeInBytes;
    }

    /**
     * Creates and schedules files for insertion by given arguments.
     *
     * Performs moving files to predefined $targetDirectory and attaches them to given $attachTo entity.
     * You also may define field of document to attach to.
     * @param array $files
     * @param array $filenames
     * @param array $descriptions
     * @throws \Exception
     */
    public function uploadMultiple(array $files, array $filenames, array $descriptions)
    {
        // check is given arrays has the same length
        if (!((count($files) === count($filenames)) && (count($filenames) === count($descriptions)))) {
            throw new \InvalidArgumentException('Arrays must be same length');
        }

        /** @var UploadedFile $rawFile */
        foreach ($files as $key => $rawFile) {
            $file = new File();
            $file->setName($filenames[$key]);

            $this->upload($file, $rawFile);
        }
    }

    /**
     * Sets parameters of given $file object based on given $rawFile. Also moves $rawFile to predefined $targetDirectory.
     * @param File $file
     * @param UploadedFile $rawFile
     * @throws \Exception
     */
    public function upload(File $file, UploadedFile $rawFile)
    {
        if (!$this->isSizeValid($rawFile)) {
            throw new \Exception('Размер файла не может превышать ' . $this->maxSizeInMegabytes . ' МБ');
        }

        $extension = $rawFile->getClientOriginalExtension();
        $filename = $this->generateFilename() . '.' . $extension;
        $path = $this->targetDirectory . $filename;

        $file->setSize($rawFile->getSize());
        $file->setExtension($extension);

        $rawFile->move($this->targetDirectory, $filename);
        $file->setPath($path);

        $this->em->persist($file);
    }

    /**
     * Attaches given file to post.
     *
     * @param File $file
     * @param Post $post
     */
    public function attach(File $file, Post $post)
    {
        if ($post->getAttachments()->count() <= Post::MAX_ATTACHEMNTS_NUMBER)
        $post->addAttachments($file);
    }

    public function removeFile(File $file)
    {
        $fs = new Filesystem();
        $publicFolderPath = PathHelper::getPublicDir($this->projectDir);
        $fs->remove($publicFolderPath.$file->getPath());
    }

    /**
     * Generates unique filename based on current time
     * @param string|null $prefix
     * @return string
     */
    public static function generateFilename(string $prefix = null)
    {
        return sprintf('%s-%s-%s', $prefix, (new \DateTime())->format('YmdHis'), uniqid());
    }
}