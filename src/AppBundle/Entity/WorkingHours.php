<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * WorkingHours
 *
 * @ORM\Table(name="working_hours")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WorkingHoursRepository")
 */
class WorkingHours
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
     * @var array
     *
     * @ORM\Column(name="week_days", type="simple_array")
     */
    private $weekDays;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_time", type="time")
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_time", type="time")
     * @Assert\Expression(
     *     "this.getStartTime() < this.getEndTime()",
     *      message="The end date must be after the start date"
     * )
     */
    private $endTime;

    /**
     * @ORM\ManyToOne(targetEntity="Calendar")
     * @ORM\JoinColumn(nullable=false)
     */
    private $calendar;


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
     * Set weekDays
     *
     * @param array $weekDays
     *
     * @return WorkingHours
     */
    public function setWeekDays($weekDays)
    {
        $this->weekDays = $weekDays;

        return $this;
    }

    /**
     * Get weekDays
     *
     * @return array
     */
    public function getWeekDays()
    {
        return $this->weekDays;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     *
     * @return WorkingHours
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     *
     * @return WorkingHours
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set calendar
     *
     * @param \AppBundle\Entity\Calendar $calendar
     *
     * @return WorkingHours
     */
    public function setCalendar(\AppBundle\Entity\Calendar $calendar)
    {
        $this->calendar = $calendar;

        return $this;
    }

    /**
     * Get calendar
     *
     * @return \AppBundle\Entity\Calendar
     */
    public function getCalendar()
    {
        return $this->calendar;
    }
}
