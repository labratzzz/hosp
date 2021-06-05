<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

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
        '08:00' => 0 , '08:15' => 1 , '08:30' => 2 , '08:45' => 3 ,
        '09:00' => 4 , '09:15' => 5 , '09:30' => 6 , '09:45' => 7 ,
        '10:00' => 8 , '10:15' => 9 , '10:30' => 10, '10:45' => 11,
        '11:00' => 12, '11:15' => 13, '11:30' => 14, '11:45' => 15,
        '12:00' => 16, '12:15' => 17, '12:30' => 18, '12:45' => 19,
        '13:00' => 20, '13:15' => 21, '13:30' => 22, '13:45' => 23,
        '14:00' => 24, '14:15' => 25, '14:30' => 26, '14:45' => 27,
        '15:00' => 28, '15:15' => 29, '15:30' => 30, '15:45' => 31,
        '16:00' => 32, '16:15' => 33, '16:30' => 34
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

}