<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Calendar
 *
 * @ORM\Table(name="calendars")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CalendarRepository")
 */
class Calendar
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="step_minutes", type="integer")
     * @Assert\NotBlank()
     */
    private $stepMinutes = 30;

    /**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="WorkingHours", mappedBy="calendar")
     */
    private $workingHours;

    /**
     * @ORM\OneToMany(targetEntity="Booking", mappedBy="calendar")
     */
    private $bookings;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Calendar
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Calendar
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set stepMinutes
     *
     * @param integer $stepMinutes
     *
     * @return Calendar
     */
    public function setStepMinutes($stepMinutes)
    {
        $this->stepMinutes = $stepMinutes;

        return $this;
    }

    /**
     * Get stepMinutes
     *
     * @return int
     */
    public function getStepMinutes()
    {
        return $this->stepMinutes;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Calendar
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->workingHours = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add workingHour
     *
     * @param \AppBundle\Entity\WorkingHours $workingHour
     *
     * @return Calendar
     */
    public function addWorkingHour(\AppBundle\Entity\WorkingHours $workingHour)
    {
        $this->workingHours[] = $workingHour;

        return $this;
    }

    /**
     * Remove workingHour
     *
     * @param \AppBundle\Entity\WorkingHours $workingHour
     */
    public function removeWorkingHour(\AppBundle\Entity\WorkingHours $workingHour)
    {
        $this->workingHours->removeElement($workingHour);
    }

    /**
     * Get workingHours
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWorkingHours()
    {
        return $this->workingHours;
    }

    /**
     * Add booking
     *
     * @param \AppBundle\Entity\Booking $booking
     *
     * @return Calendar
     */
    public function addBooking(\AppBundle\Entity\Booking $booking)
    {
        $this->bookings[] = $booking;

        return $this;
    }

    /**
     * Remove booking
     *
     * @param \AppBundle\Entity\Booking $booking
     */
    public function removeBooking(\AppBundle\Entity\Booking $booking)
    {
        $this->bookings->removeElement($booking);
    }

    /**
     * Get bookings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBookings()
    {
        return $this->bookings;
    }
}
