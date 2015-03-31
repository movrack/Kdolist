<?php

namespace Manudev\KDOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use \Manudev\CoreBundle\Entity\Picture;

/**
 * Gift
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Manudev\KDOBundle\Repository\GiftRepository")
 */
class Gift
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Manudev\CoreBundle\Entity\Picture", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="picture_id", referencedColumnName="id")
     */
    private $picture;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="Lists", inversedBy="gifts")
     * @ORM\JoinColumn(name="list_id", referencedColumnName="id", nullable=false)
     */
    protected $list;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", nullable=true)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="giveMoney", type="boolean")
     */
    private $giveMoney;

    /**
     * @var boolean
     *
     * @ORM\Column(name="accepteMultipleParts", type="boolean")
     */
    private $accepteMultipleParts;

    /**
     * @var integer
     *
     * @ORM\Column(name="numberOfParts", type="integer")
     * @Assert\GreaterThan(
     *     value = 0
     * )
     */
    private $numberOfParts = 1;

    /**
     * @var integer
     *
     * @ORM\Column(name="givedParts", type="integer")
     * @Assert\GreaterThanOrEqual(
     *     value = 0
     * )
     */
    private $givedParts = 0;

    /**
     * @var integer
     *
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var GiftReservation
     *
     * @ORM\OneToMany(targetEntity="GiftReservation", mappedBy="gift")
     **/
    private $reservations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->reservations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    function __toString() {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Gift
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
     * @return Gift
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
     * Set link
     *
     * @param string $link
     * @return Gift
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Gift
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set giveMoney
     *
     * @param string $giveMoney
     * @return Gift
     */
    public function setGiveMoney($giveMoney)
    {
        $this->giveMoney = $giveMoney;

        return $this;
    }

    /**
     * Get giveMoney
     *
     * @return string 
     */
    public function getGiveMoney()
    {
        return $this->giveMoney;
    }

    /**
     * Set accepteMultipleParts
     *
     * @param boolean $accepteMultipleParts
     * @return Gift
     */
    public function setAccepteMultipleParts($accepteMultipleParts)
    {
        $this->accepteMultipleParts = $accepteMultipleParts;

        return $this;
    }

    /**
     * Get accepteMultipleParts
     *
     * @return boolean 
     */
    public function getAccepteMultipleParts()
    {
        return $this->accepteMultipleParts;
    }

    /**
     * Set numberOfParts
     *
     * @param integer $numberOfParts
     * @return Gift
     */
    public function setNumberOfParts($numberOfParts)
    {
        $this->numberOfParts = $numberOfParts;

        return $this;
    }

    /**
     * Get numberOfParts
     *
     * @return integer 
     */
    public function getNumberOfParts()
    {
        return $this->numberOfParts;
    }


    /**
     * Set list
     *
     * @param \Manudev\KDOBundle\Entity\Lists $list
     * @return Gift
     */
    public function setList(\Manudev\KDOBundle\Entity\Lists $list = null)
    {
        $this->list = $list;

        return $this;
    }

    /**
     * Get list
     *
     * @return \Manudev\KDOBundle\Entity\Lists
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * Set picture
     *
     * @param \Manudev\CoreBundle\Entity\Picture $picture
     * @return Gift
     */
    public function setPicture(\Manudev\CoreBundle\Entity\Picture $picture = null)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return \Manudev\CoreBundle\Entity\Picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    public function setPosition($position)
    {
        $this->position = $position;
    }

    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Add reservations
     *
     * @param \Manudev\KDOBundle\Entity\GiftReservation $reservations
     * @return Gift
     */
    public function addReservation(\Manudev\KDOBundle\Entity\GiftReservation $reservations)
    {
        $this->reservations[] = $reservations;

        return $this;
    }

    /**
     * Remove reservations
     *
     * @param \Manudev\KDOBundle\Entity\GiftReservation $reservations
     */
    public function removeReservation(\Manudev\KDOBundle\Entity\GiftReservation $reservations)
    {
        $this->reservations->removeElement($reservations);
    }

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection\ArrayCollection
     */
    public function getReservations()
    {
        return $this->reservations;
    }


    /**
     * Set givedParts
     *
     * @param integer $givedParts
     * @return Gift
     */
    public function setGivedParts($givedParts)
    {
        $this->givedParts = $givedParts;

        return $this;
    }

    /**
     * Get givedParts
     *
     * @return integer
     */
    public function getGivedParts()
    {
        return $this->givedParts;
    }





    public function isAvailable()
    {
        return !$this->isReserved() and !$this->isGived();
    }

    public function totalReserved() {

        $sum = 0;
        foreach ($this->reservations as $reservation) {
            if ($reservation->getStatus() == GiftReservation::STATUS_RESERVED) {
                $sum += $reservation->getGivedParts();
            }
        }
        return $sum;
    }

    public function isReserved()
    {
        $isReserved = count($this->reservations) != 0;
        if($isReserved) {
            $sum = $this->totalReserved();
            $isReserved = (($sum + $this->givedParts) >= $this->numberOfParts);
        }
        return $isReserved;
    }

    public function isGived()
    {
        return ($this->givedParts == $this->numberOfParts);
    }


    /**
     * Get givedParts
     *
     * @return integer
     */
    public function getAvailableParts()
    {
        return $this->getNumberOfParts() - $this->givedParts;
    }

    /**
     * @return float
     */
    public function totalGived()
    {
        return $this->partValue() * $this->givedParts;
    }

    /**
     * @return float
     */
    public function percentDone()
    {
        return $this->givedParts / $this->numberOfParts * 100;
    }
    /**
     * @return float
     */
    public function percentReserved()
    {
        return $this->totalReserved() / $this->numberOfParts * 100;
    }

    /**
     * @return float
     */
    public function partValue()
    {
        return ceil(($this->price / $this->numberOfParts)*100)/100;
    }

}
