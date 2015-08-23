<?php

namespace Manudev\KDOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * GiftReservation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Manudev\KDOBundle\Repository\GiftReservationRepository")
 */
class GiftReservation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    const STATUS_RESERVED = 'RESERVED';
    const STATUS_CONFIRMED = 'CONFIRMED';
    const STATUS_GIVED = 'GIVED';
    /**
     * @var string
     *
     * @ORM\Column(type="string", columnDefinition="ENUM('RESERVED', 'CONFIRMED', 'GIVED')")
     */
    private $status = self::STATUS_RESERVED;

    /**
     * @var string
     *
     * @ORM\Column(name="uniqCode", type="string", length=255, nullable=true)
     */
    private $uniqCode;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Gift", inversedBy="reservations")
     * @ORM\JoinColumn(name="gift_id", referencedColumnName="id")
     **/
    private $gift;

    /**
     * @var integer
     *
     * @ORM\Column(name="givedParts", type="integer", nullable=true)
     */
    private $givedParts = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;


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
     * Set gift
     *
     * @param \stdClass $gift
     * @return GiftReservation
     */
    public function setGift($gift)
    {
        $this->gift = $gift;

        return $this;
    }

    /**
     * Get gift
     *
     * @return \stdClass 
     */
    public function getGift()
    {
        return $this->gift;
    }

    /**
     * Set givedParts
     *
     * @param integer $givedParts
     * @return GiftReservation
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

    /**
     * Set email
     *
     * @param string $email
     * @return GiftReservation
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return GiftReservation
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return GiftReservation
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }


    /**
     * Set status
     *
     * @param string $status
     * @return GiftReservation
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return GiftReservation
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    public static function hashUniqCode(GiftReservation $reservation, Gift $gift, $email) {
        return sha1($reservation->getId().'-'.$gift->getId().'-'.$email);
    }

    /**
     * Set uniqCode
     *
     * @param string $uniqCode
     * @return GiftReservation
     */
    public function setUniqCode($uniqCode)
    {
        $this->uniqCode = $uniqCode;

        return $this;
    }

    /**
     * Get uniqCode
     *
     * @return string 
     */
    public function getUniqCode()
    {
        return $this->uniqCode;
    }
}
