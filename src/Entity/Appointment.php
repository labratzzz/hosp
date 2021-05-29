<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Represents an appointment between doctor and patient.
 *
 * Class Appointment
 * @package App\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="appointments")
 */
class Appointment
{
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