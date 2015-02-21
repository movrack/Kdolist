<?php
namespace KDO\Bundle\KDOBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="KDO\Bundle\KDOBundle\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;



    /** @ORM\Column(name="google_id", type="string", length=255, nullable=true) */
    protected $google_id;

    /** @ORM\Column(name="google_access_token", type="string", length=255, nullable=true) */
    protected $google_access_token;

    /** @ORM\Column(name="windows_live_id", type="string", length=255, nullable=true) */
    protected $windows_live_id;

    /** @ORM\Column(name="windows_live_access_token", type="string", length=255, nullable=true) */
    protected $windows_live_access_token;

    /** @ORM\Column(name="facebook_id", type="string", length=255, nullable=true) */
    protected $facebook_id;

    /** @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) */
    protected $facebook_access_token;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $lastname;

    /**
     * @ORM\ManyToMany(targetEntity="Lists", inversedBy="users")
     * @ORM\JoinTable(name="users_lists")
     **/
    protected $lists;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->lists = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getGoogleId()
    {
        return $this->google_id;
    }

    /**
     * @param mixed $google_id
     */
    public function setGoogleId($google_id)
    {
        $this->google_id = $google_id;
    }

    /**
     * @return mixed
     */
    public function getGoogleAccessToken()
    {
        return $this->google_access_token;
    }

    /**
     * @param mixed $google_access_token
     */
    public function setGoogleAccessToken($google_access_token)
    {
        $this->google_access_token = $google_access_token;
    }

    /**
     * @return mixed
     */
    public function getWindowsLiveId()
    {
        return $this->windows_live_id;
    }

    /**
     * @param mixed $windows_live_id
     */
    public function setWindowsLiveId($windows_live_id)
    {
        $this->windows_live_id = $windows_live_id;
    }

    /**
     * @return mixed
     */
    public function getWindowsLiveAccessToken()
    {
        return $this->windows_live_access_token;
    }

    /**
     * @param mixed $windows_live_access_token
     */
    public function setWindowsLiveAccessToken($windows_live_access_token)
    {
        $this->windows_live_access_token = $windows_live_access_token;
    }

    /**
     * @return mixed
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * @param mixed $facebook_id
     */
    public function setFacebookId($facebook_id)
    {
        $this->facebook_id = $facebook_id;
    }

    /**
     * @return mixed
     */
    public function getFacebookAccessToken()
    {
        return $this->facebook_access_token;
    }

    /**
     * @param mixed $facebook_access_token
     */
    public function setFacebookAccessToken($facebook_access_token)
    {
        $this->facebook_access_token = $facebook_access_token;
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
     * Add lists
     *
     * @param \KDO\Bundle\KDOBundle\Entity\Lists $lists
     * @return User
     */
    public function addList(\KDO\Bundle\KDOBundle\Entity\Lists $list)
    {
        if ($this->lists->contains($list)) {
            return $this;
        }

        $this->lists->add($list);

        if (!$list->getUsers()->contains($this)) {
            $list->addUser($this); // synchronously updating inverse side
        }
        return $this;
    }

    /**
     * Remove lists
     *
     * @param \KDO\Bundle\KDOBundle\Entity\Lists $lists
     */
    public function removeList(\KDO\Bundle\KDOBundle\Entity\Lists $lists)
    {

        $this->lists->removeElement($lists);
        if ($lists->getUsers()->contains($this)) {
            $lists->removeUser($this); // synchronously updating inverse side
        }

    }

    /**
     * Get lists
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLists()
    {
        return $this->lists;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }
}
