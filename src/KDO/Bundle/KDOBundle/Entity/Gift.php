<?php

namespace KDO\Bundle\KDOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gift
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KDO\Bundle\KDOBundle\Repository\GiftRepository")
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255)
     */
    private $picture;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal")
     */
    private $price;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isSecondHand", type="boolean")
     */
    private $isSecondHand;

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
     */
    private $numberOfParts;



    /**
     * @ORM\ManyToOne(targetEntity="Lists", inversedBy="gifts")
     * @ORM\JoinColumn(name="list_id", referencedColumnName="id")
     */
    protected $list;

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
     * Set picture
     *
     * @param string $picture
     * @return Gift
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture()
    {
        return $this->picture;
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
     * Set isSecondHand
     *
     * @param boolean $isSecondHand
     * @return Gift
     */
    public function setIsSecondHand($isSecondHand)
    {
        $this->isSecondHand = $isSecondHand;

        return $this;
    }

    /**
     * Get isSecondHand
     *
     * @return boolean 
     */
    public function getIsSecondHand()
    {
        return $this->isSecondHand;
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
     * @param \KDO\Bundle\KDOBundle\Entity\Lists $list
     * @return Gift
     */
    public function setList(\KDO\Bundle\KDOBundle\Entity\Lists $list = null)
    {
        $this->list = $list;

        return $this;
    }

    /**
     * Get list
     *
     * @return \KDO\Bundle\KDOBundle\Entity\Lists 
     */
    public function getList()
    {
        return $this->list;
    }
}
