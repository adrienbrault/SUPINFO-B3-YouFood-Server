<?php

namespace YouFood\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Week
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @ORM\Entity(repositoryClass="YouFood\MainBundle\Repository\WeekRepository")
 * @ORM\Table(name="weeks", uniqueConstraints={@ORM\UniqueConstraint(name="year_week_number_unique", columns={"year", "week_number"})})
 */
class Week
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", name="week_number")
     */
    private $weekNumber;

    /**
     * @var Theme
     *
     * @ORM\ManyToOne(targetEntity="Theme", inversedBy="weeks", cascade={"persist"})
     * @ORM\JoinColumn(name="theme_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $theme;

    /**
     * Constructor
     */
    public function __construct()
    {

    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Theme $theme
     */
    public function setTheme(Theme $theme)
    {
        // Update inverse side
        if (null != $this->theme) {
            $this->theme->getWeeks()->removeElement($this);
        }

        if (null !== $theme) {
            $theme->getWeeks()->add($this);
        }

        $this->theme = $theme;
    }

    /**
     * @return Theme
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param int $weekNumber
     */
    public function setWeekNumber($weekNumber)
    {
        $this->weekNumber = $weekNumber;
    }

    /**
     * @return int
     */
    public function getWeekNumber()
    {
        return $this->weekNumber;
    }

    /**
     * @param int $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return sprintf('%d %d', $this->getYear(), $this->getWeekNumber());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->getDayOfWeekDate(0);
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->getDayOfWeekDate(6);
    }

    /**
     * @link http://tzzz.wordpress.com/2006/08/14/8/
     *
     * @param int $day
     *
     * @return \DateTime
     */
    protected function getDayOfWeekDate($day = 0)
    {
        $day = min($day, 6);
        $day = max($day, 0);

        // Count from '0104' because January 4th is always in week 1 (according to ISO 8601).
        $timestamp = strtotime(sprintf('%d0104 +%d weeks', $this->getYear(), ($this->getWeekNumber() - 1)));

        // Get the time of the first day of the week (Monday -> Sunday)
        $mondayTimestamp = strtotime(sprintf('-%d days', date('w', $timestamp) - 2), $timestamp);

        $dayOfWeekTimestamp = strtotime(sprintf('+%d days', $day), $mondayTimestamp);

        return new \DateTime(sprintf('@%d', $dayOfWeekTimestamp));
    }
}
