<?php


namespace App\Entity;

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

    const ALLOWED_IMAGE_EXTENSIONS = [
        'png',
        'jpg',
        'jpeg',
        'gif',
        'webp'
    ];

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

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
     * @ORM\Column(type="string", length=255)
     * @Groups({"Main"})
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Groups({"Main"})
     */
    private $image;

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
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
}