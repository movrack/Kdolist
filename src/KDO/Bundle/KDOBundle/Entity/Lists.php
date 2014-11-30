<?php

namespace KDO\Bundle\KDOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Lists
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KDO\Bundle\KDOBundle\Repository\ListsRepository")
 */
class Lists
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="event", type="string", length=255)
     */
    private $event;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="lists")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;


    /**
     * @ORM\OneToMany(targetEntity="Gift", mappedBy="list")
     */
    protected $gifts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->gifts = new ArrayCollection();
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
     * @return Listss
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
     * @return Lists
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
     * Set type
     *
     * @param string $type
     * @return Lists
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set event
     *
     * @param string $event
     * @return Lists
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return string 
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set user
     *
     * @param \KDO\Bundle\KDOBundle\Entity\User $user
     * @return Lists
     */
    public function setUser(\KDO\Bundle\KDOBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \KDO\Bundle\KDOBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add gifts
     *
     * @param \KDO\Bundle\KDOBundle\Entity\Gift $gifts
     * @return Lists
     */
    public function addGift(\KDO\Bundle\KDOBundle\Entity\Gift $gifts)
    {
        $this->gifts[] = $gifts;

        return $this;
    }

    /**
     * Remove gifts
     *
     * @param \KDO\Bundle\KDOBundle\Entity\Gift $gifts
     */
    public function removeGift(\KDO\Bundle\KDOBundle\Entity\Gift $gifts)
    {
        $this->gifts->removeElement($gifts);
    }

    /**
     * Get gifts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGifts()
    {
        return $this->gifts;
    }

    public function __toString() {
        return $this->name;
    }
}
