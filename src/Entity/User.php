<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents user that can access site resources and might be a doctor or patient.
 *
 * Class User
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="Профиль пользователя на данную электронную почту уже зарегистрирован.")
 * @ORM\Table(name="users")
 */
class User implements AdvancedUserInterface
{
    const RESET_PASSWORD_VALUE = 'lgorcbUser64_';

    const USERTYPE_PATIENT = 0;
    const USERTYPE_DOCTOR = 1;

    const USERTYPES = [
        0 => self::USERTYPE_PATIENT,
        1 => self::USERTYPE_DOCTOR
    ];

    const USERTYPE_NAME = [
        0 => 'Пациент',
        1 => 'Врач'
    ];

    const ROLE_DEFAULT = 'ROLE_USER';

    const SEX_CHOICES = [
        'Мужчина' => 0,
        'Женщина' => 1
    ];

    public function __construct()
    {
        $this->enabled = true;
        $this->createdAt = new \DateTime();
    }

    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     * @ORM\Id()
     * @Groups({"Main"})
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"Main"})
     * @Assert\Email(groups={"Patient", "Doctor"})
     * @Assert\NotBlank(groups={"Patient", "Doctor"})
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups({"Main"})
     * @Assert\NotBlank(groups={"Patient", "Doctor"})
     */
    private $name;

    /**
     * @var string|null
     */
    private $plainPassword;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string[]
     * @ORM\Column(type="array")
     * @Groups({"Main"})
     */
    private $roles;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @Groups({"Main"})
     */
    private $enabled;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetimetz")
     * @Groups({"Main"})
     */
    private $createdAt;

    /**
     * @var Post[]
     * @ORM\OneToMany(targetEntity="Post", mappedBy="author")
     */
    private $posts;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Groups({"Main"})
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @var DoctorPost
     * @ORM\ManyToOne(targetEntity="DoctorPost", inversedBy="doctors")
     * @ORM\JoinColumn(onDelete="SET NULL")
     * @Groups({"Main"})
     * @Assert\NotBlank(groups={"Doctor"})
     */
    private $post;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Groups({"Main"})
     * @Assert\NotBlank(groups={"Patient", "Doctor"})
     */
    private $sex;

    /**
     * @var int
     * @ORM\Column(type="string", length=16, nullable=true)
     * @Groups({"Main"})
     * @Assert\NotBlank(groups={"Patient"})
     * @Assert\Regex(pattern="/^\d{16}$/",
     *     message="Полис ОМС должен состоять из 16 цифр",
     *     groups={"Patient"})
     */
    private $polis;

    /**
     * @var int
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups({"Main"})
     * @Assert\NotBlank(groups={"Patient"})
     * @Assert\Regex(pattern="/^\d{10}$/",
     *     message="Номер телефона должен состоять из 10 цифр без кода страны (+7 по умолчанию)",
     *     groups={"Patient"})
     */
    private $phone;

    /**
     * @var Appointment[]
     * @ORM\OneToMany(targetEntity="Appointment", mappedBy="doctor")
     */
    private $appointmentsAsDoctor;

    /**
     * @var Appointment[]
     * @ORM\OneToMany(targetEntity="Appointment", mappedBy="patient")
     */
    private $appointmentsAsPatient;

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function getRoles()
    {
        $roles = $this->roles;

        $roles[] = self::ROLE_DEFAULT;

        return array_unique($roles);
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

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
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return Post[]
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param Post[] $posts
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type)
    {
        $this->type = $type;
    }

    /**
     * @return DoctorPost
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param DoctorPost $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * @return int
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param int $sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    /**
     * @return int
     */
    public function getPolis()
    {
        return $this->polis;
    }

    /**
     * @param int $polis
     */
    public function setPolis($polis)
    {
        $this->polis = $polis;
    }

    /**
     * @return int
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return int
     */
    public function getFormattedPhone()
    {
        return sprintf('+7 (%s) %s %s-%s',
            substr($this->phone, 0, 3),
            substr($this->phone, 3, 3),
            substr($this->phone, 5, 2),
            substr($this->phone, 7, 2)
        );
    }

    /**
     * @param int $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return Appointment[]
     */
    public function getAppointmentsAsDoctor()
    {
        return $this->appointmentsAsDoctor;
    }

    /**
     * @param Appointment $appointmentsAsDoctor
     */
    public function setAppointmentsAsDoctor($appointmentsAsDoctor)
    {
        $this->appointmentsAsDoctor = $appointmentsAsDoctor;
    }

    /**
     * @return Appointment[]
     */
    public function getAppointmentsAsPatient()
    {
        return $this->appointmentsAsPatient;
    }

    /**
     * @param Appointment $appointmentsAsPatient
     */
    public function setAppointmentsAsPatient($appointmentsAsPatient)
    {
        $this->appointmentsAsPatient = $appointmentsAsPatient;
    }

    public function __toString()
    {
        return ($this->type === self::USERTYPE_PATIENT) ?
            sprintf('%s (%s)', $this->name, $this->email)
            : sprintf('%s', $this->name);
    }

}