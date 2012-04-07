<?php

namespace YouFood\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Week
 *
 * @ORM\Entity(repositoryClass="YouFood\MainBundle\Entity\WeekRepository")
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
     * @ORM\Column(type="integer")
     */
    private $weekNumber;

    /**
     * @var Theme
     *
     * @ORM\ManyToOne(targetEntity="Theme", inversedBy="weeks")
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
    public function setTheme($theme)
    {
        if (null !== $this->theme) {
            $this->theme->getWeeks()->removeElement($this); // Update inverse side
        }

        $this->theme = $theme;

        $theme->getWeeks()->add($this); // Update inverse side
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
}
