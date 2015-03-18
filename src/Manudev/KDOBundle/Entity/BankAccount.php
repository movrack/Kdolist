<?php

namespace Manudev\KDOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Gift
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Manudev\KDOBundle\Repository\BankAccountRepository")
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
     * @var string
     * @Assert\Iban
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $number;



    function __toString() {
        $str = "";
        $strlen = strlen($this->$number);
        for( $i = 0; $i <= $strlen; $i++ ) {
            $char = substr( $this->$number, $i, 1 );
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
}
