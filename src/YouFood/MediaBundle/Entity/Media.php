<?php

namespace YouFood\MediaBundle\Entity;

use Sonata\MediaBundle\Entity\BaseMedia as BaseMedia;
use Doctrine\ORM\Mapping as ORM;

/**
 * Media
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="media__media")
 */
class Media extends BaseMedia
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     */
    protected $urlSmall;

    /**
     * @var string
     */
    protected $urlBig;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $urlBig
     */
    public function setUrlBig($urlBig)
    {
        $this->urlBig = $urlBig;
    }

    /**
     * @return string
     */
    public function getUrlBig()
    {
        return $this->urlBig;
    }

    /**
     * @param string $urlSmall
     */
    public function setUrlSmall($urlSmall)
    {
        $this->urlSmall = $urlSmall;
    }

    /**
     * @return string
     */
    public function getUrlSmall()
    {
        return $this->urlSmall;
    }
}
