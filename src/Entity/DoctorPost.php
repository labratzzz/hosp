<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Represents doctor's post (vacation).
 *
 * Class DoctorType
 * @package App\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="doctor_posts")
 */
class DoctorPost
{
    /**
     * @var int
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
    private $name;

    /**
     * @var User[]
     * @ORM\OneToMany(targetEntity="User", mappedBy="post")
     * @Groups({"Main"})
     */
    private $doctors;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return User[]
     */
    public function getDoctors()
    {
        return $this->doctors;
    }

    /**
     * @param User[] $doctors
     */
    public function setDoctors($doctors)
    {
        $this->doctors = $doctors;
    }
}