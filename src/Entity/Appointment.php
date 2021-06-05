<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents an appointment between doctor and patient.
 *
 * Class Appointment
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\AppointmentRepository")
 * @ORM\Table(name="appointments")
 * @UniqueEntity(
 *     fields={"doctor", "date", "timeSlot"},
 *     message="Выбранное время занято, выберите другое время или попробуйте записаться на другой день."
 * )
 */
class Appointment
{
    const TIME_CHOICES = [
        '09:00' => 0 , '09:15' => 1 , '09:30' => 2 , '09:45' => 3 ,
        '10:00' => 4 , '10:15' => 5 , '10:30' => 6 , '10:45' => 7 ,
        '11:00' => 8 , '11:15' => 9 , '11:30' => 10, '11:45' => 11,
        '12:00' => 12, '12:15' => 13, '12:30' => 14, '12:45' => 15,
        '13:00' => 16, '13:15' => 17, '13:30' => 18, '13:45' => 19,
        '14:00' => 20, '14:15' => 21, '14:30' => 22, '14:45' => 23,
        '15:00' => 24, '15:15' => 25, '15:30' => 26, '15:45' => 27,
    ];

     /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     * @ORM\Id()
     * @Groups({"Main"})
     */
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="appointmentsAsPatient")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Groups({"Main"})
     */
    private $patient;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="appointmentsAsDoctor")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Groups({"Main"})
     */
    private $doctor;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     * @Groups({"Main"})
     * @Assert\Date(message="Значение должно быть датой.")
     * @Assert\Expression("this.dateIsValid()", message="Некорректное значение. Выбран выходной день или неактуальная дата")
     */
    private $date;

    /**
     * Timeslot from 1 to 32
     * @var int
     * @ORM\Column(type="integer")
     * @Groups({"Main"})
     */
    private $timeSlot;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * @param User $patient
     */
    public function setPatient($patient)
    {
        $this->patient = $patient;
    }

    /**
     * @return User
     */
    public function getDoctor()
    {
        return $this->doctor;
    }

    /**
     * @param User $doctor
     */
    public function setDoctor($doctor)
    {
        $this->doctor = $doctor;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getTimeSlot()
    {
        return $this->timeSlot;
    }

    /**
     * @param int $timeSlot
     */
    public function setTimeSlot(int $timeSlot)
    {
        $this->timeSlot = $timeSlot;
    }

    /**
     * Date validation function.
     * Returns false if:
     *
     * Value is earlier than now.
     *
     * Value is later than 60 days from now.
     *
     * Value is weekend.
     *
     * @return bool
     */
    public function dateIsValid() {
        if ($this->date < new \DateTime()) return false;
        if ($this->date > (new \DateTime())->add(new \DateInterval('P60D'))) return false;
        if (in_array($this->date->format('l'), ['Saturday', 'Sunday'])) return false;

        return true;
    }

}