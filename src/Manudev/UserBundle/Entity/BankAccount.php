<?php

namespace Manudev\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Gift
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Manudev\UserBundle\Repository\BankAccountRepository")
 */
class BankAccount
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
     * @var Manudev\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Manudev\UserBundle\Entity\User", inversedBy="bankaccounts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     * @Assert\Iban
     * @ORM\Column(name="number", type="string", unique=true, length=255, nullable=false)
     */
    private $number;

    /**
     * @var string
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(name="beneficiary1", type="string", length=255, nullable=false)
     */
    private $beneficiary1;

    /**
     * @var string
     * @ORM\Column(name="beneficiary2", type="string", length=255, nullable=true)
     */
    private $beneficiary2;

    /**
     * @var string
     * @ORM\Column(name="beneficiary3", type="string", length=255, nullable=true)
     */
    private $beneficiary3;

    /**
     * @var string
     * @ORM\Column(name="beneficiary4", type="string", length=255, nullable=true)
     */
    private $beneficiary4;



    function __toString() {
        $str = "";
        $strlen = strlen($this->number);
        for( $i = 0; $i <= $strlen; $i++ ) {
            $char = substr( $this->number, $i, 1 );
            $str .= $char;
            if ($i % 4 == 3) {
                $str .= " ";
            }
        }
        return $str;
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
     * Set number
     *
     * @param string $number
     * @return BankAccount
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return BankAccount
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
     * Set beneficiary1
     *
     * @param string $beneficiary1
     * @return BankAccount
     */
    public function setBeneficiary1($beneficiary1)
    {
        $this->beneficiary1 = $beneficiary1;

        return $this;
    }

    /**
     * Get beneficiary1
     *
     * @return string 
     */
    public function getBeneficiary1()
    {
        return $this->beneficiary1;
    }

    /**
     * Set beneficiary2
     *
     * @param string $beneficiary2
     * @return BankAccount
     */
    public function setBeneficiary2($beneficiary2)
    {
        $this->beneficiary2 = $beneficiary2;

        return $this;
    }

    /**
     * Get beneficiary2
     *
     * @return string 
     */
    public function getBeneficiary2()
    {
        return $this->beneficiary2;
    }

    /**
     * Set beneficiary3
     *
     * @param string $beneficiary3
     * @return BankAccount
     */
    public function setBeneficiary3($beneficiary3)
    {
        $this->beneficiary3 = $beneficiary3;

        return $this;
    }

    /**
     * Get beneficiary3
     *
     * @return string 
     */
    public function getBeneficiary3()
    {
        return $this->beneficiary3;
    }

    /**
     * Set beneficiary4
     *
     * @param string $beneficiary4
     * @return BankAccount
     */
    public function setBeneficiary4($beneficiary4)
    {
        $this->beneficiary4 = $beneficiary4;

        return $this;
    }

    /**
     * Get beneficiary4
     *
     * @return string 
     */
    public function getBeneficiary4()
    {
        return $this->beneficiary4;
    }

    /**
     * Set user
     *
     * @param \Manudev\UserBundle\Entity\User $user
     * @return BankAccount
     */
    public function setUser(\Manudev\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Manudev\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
