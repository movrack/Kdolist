<?php

namespace KDO\Bundle\KDOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Lists
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KDO\Bundle\KDOBundle\Repository\ListsRepository")
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\ManyToOne(targetEntity="ListType", inversedBy="lists")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="event", type="string", length=255, nullable=true)
     */
    private $event;

    /**
     * @ORM\OneToMany(targetEntity="Gift", mappedBy="list")
     */
    protected $gifts;

    /**
     * @ORM\ManyToMany(targetEntity="ListOwner", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     * @ORM\JoinTable(name="list_listowner",
     *      joinColumns={@ORM\JoinColumn(name="list_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="owner_id", referencedColumnName="id", unique=true)}
     *      )
     **/
    private $owners;

    /**
     * @ORM\ManyToOne(targetEntity="Picture", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="picture_id", referencedColumnName="id")
     */
    private $picture;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="lists")
     **/
    protected $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->gifts = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->owners = new ArrayCollection();
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
     * @return Lists
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

    /**
     * Add users
     *
     * @param \KDO\Bundle\KDOBundle\Entity\User $users
     * @return Lists
     */
    public function addUser(\KDO\Bundle\KDOBundle\Entity\User $user)
    {
        if ($this->users->contains($user)) {
            return $this;
        }

        $this->users->add($user);

        if (!$user->getLists()->contains($this)) {
            $user->addList($this); // synchronously updating inverse side
        }

        return $this;
    }

    /**
     * Remove users
     *
     * @param \KDO\Bundle\KDOBundle\Entity\User $users
     */
    public function removeUser(\KDO\Bundle\KDOBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
        if ($user->getLists()->contains($this)) {
            $user->removeList($this); // synchronously updating inverse side
        }

    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }


    public function setUsers(ArrayCollection $users)
    {
        foreach ($users as $user) {
            $user->setList($this);
        }

        $this->users = $users;
        return $this;
    }

    public function setOwners(ArrayCollection $owners)
    {
        foreach ($owners as $owner) {
            $owner->setList($this);
        }

        $this->owners = $owners;
        return $this;
    }

    /**
     * Get owners
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOwners()
    {
        return $this->owners;
    }

    /**
     * Add owners
     *
     * @param \KDO\Bundle\KDOBundle\Entity\ListOwner $owners
     * @return Lists
     */
    public function addOwner(\KDO\Bundle\KDOBundle\Entity\ListOwner $owners)
    {
        $this->owners[] = $owners;

        return $this;
    }

    /**
     * Remove owners
     *
     * @param \KDO\Bundle\KDOBundle\Entity\ListOwner $owners
     */
    public function removeOwner(\KDO\Bundle\KDOBundle\Entity\ListOwner $owners)
    {
        $this->owners->removeElement($owners);
    }




    /**
     * Set picture
     *
     * @param \KDO\Bundle\KDOBundle\Entity\Picture $picture
     * @return Lists
     */
    public function setPicture(\KDO\Bundle\KDOBundle\Entity\Picture $picture = null)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return \KDO\Bundle\KDOBundle\Entity\Picture 
     */
    public function getPicture()
    {
        return $this->picture;
    }
}
