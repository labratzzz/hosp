<?php


namespace App\Entity;

use App\Service\FileService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Represents site news post.
 *
 * Class Post
 * @package App\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="posts")
 */
class Post
{
    const MAX_ATTACHEMNTS_NUMBER = 10;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @Groups({"Main"})
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"Main"})
     */
    private $title;

    /**
     * @var File
     * @ORM\ManyToOne(targetEntity="File", inversedBy="")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $titleImage;

    /**
     * @var string
     * @ORM\Column(type="text")
     * @Groups({"Main"})
     */
    private $text;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetimetz")
     * @Groups({"Main"})
     */
    private $createdAt;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="posts")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $author;

    /**
     * @var File[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="File", mappedBy="post")
     */
    private $attachments;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return File
     */
    public function getTitleImage()
    {
        return $this->titleImage;
    }

    /**
     * @param File $titleImage
     */
    public function setTitleImage($titleImage)
    {
        if (!in_array($titleImage->getExtension(), FileService::IMAGE_EXTENSIONS)) {
            throw new \InvalidArgumentException('Only image can be set at title image');
        }
        $this->titleImage = $titleImage;
    }

    /**
     * @return File[]
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param File[] $attachments
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;
    }

    /**
     * @param File[] $attachments
     */
    public function addAttachments(File $attachment)
    {
        $this->attachments->add($attachment);
    }
}