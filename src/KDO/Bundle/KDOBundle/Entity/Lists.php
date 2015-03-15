<?php

namespace KDO\Bundle\KDOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Lists
 *
 * @Gedmo\Tree(type="nested")
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
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="subTitle", type="string", length=255, nullable=true)
     */
    private $subTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;


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
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Lists", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Lists", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isPublic", type="boolean", nullable=true)
     */
    private $isPublic;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->gifts = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->owners = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public function __toString() {
        return "".$this->title;
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

    public function getSlug()
    {
        return $this->slug;
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

    /**
     * Set title
     *
     * @param string $title
     * @return Lists
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set subTitle
     *
     * @param string $subTitle
     * @return Lists
     */
    public function setSubTitle($subTitle)
    {
        $this->subTitle = $subTitle;

        return $this;
    }

    /**
     * Get subTitle
     *
     * @return string 
     */
    public function getSubTitle()
    {
        return $this->subTitle;
    }

    /**
     * Add children
     *
     * @param \KDO\Bundle\KDOBundle\Entity\Lists $children
     * @return Lists
     */
    public function addChild(\KDO\Bundle\KDOBundle\Entity\Lists $children)
    {
        if ($children->getParent() != null) {
            return $this;
        }

        if ($children->getParent() == $this) {
            return $this;
        }

        if ($this->children->contains($children)) {
            return $this;
        }

        $this->children->add($children);

        if ($children->getParent() != $this) {
            $children->setParent($this); // synchronously updating inverse side
        }

        return $this;
    }

    /**
     * Remove children
     *
     * @param \KDO\Bundle\KDOBundle\Entity\Lists $children
     */
    public function removeChild(\KDO\Bundle\KDOBundle\Entity\Lists $child)
    {
        $this->children->removeElement($child);
        if ($child->getParent() != null) {
            $child->setParent(null);
        }
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \KDO\Bundle\KDOBundle\Entity\Lists $parent
     * @return Lists
     */
    public function setParent(\KDO\Bundle\KDOBundle\Entity\Lists $parent = null)
    {
        if ($parent == null) {
            $thisParent = $this->getParent();
            $this->parent = null;
            if($thisParent != null) {
                $thisParent->removeChild($this);
            }
            return $this;
        }

        if ($parent == $this) {
            return $this;
        }

        if ($this->parent == $this) {
            return $this;
        }

        $this->parent = $parent;

        if (!$parent->getChildren()->contains($this)) {
            $parent->addChild($this); // synchronously updating inverse side
        }

        return $this;
    }

    /**
     * Get parent
     *
     * @return \KDO\Bundle\KDOBundle\Entity\Lists 
     */
    public function getParent()
    {
        return $this->parent;
    }


    /**
     * Set isPublic
     *
     * @param boolean $isPublic
     * @return Gift
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    /**
     * Get isPublic
     *
     * @return boolean
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * @return string
     */
    public function getListPath() {
        if ($this->parent == null) {
            return $this->title;
        } else {
            return $this->getParent()->getListPath() . " > " . $this->title;
        }
    }

    /**
     * @return mixed
     */
    public function getRoot() {
        return $this->root;
    }

    /**
     * @return mixed
     */
    public function getLft() {
        return $this->lft;
    }

    /**
     * @return mixed
     */
    public function getRgt() {
        return $this->rgt;
    }
}
