<?php

namespace Manudev\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

define('FILES_DESTINATION', "uploads/pictures");
/**
 * Picture
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Manudev\CoreBundle\Repository\PictureRepository")
 * @ORM\HasLifecycleCallbacks
 * @Gedmo\Uploadable(path="/uploads/pictures")
 */
class Picture
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
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\UploadableFileName
     */
    protected $name;

//    /**
//     * @ORM\Column(name="mime_type", type="string")
//     * @Gedmo\UploadableFileMimeType
//     */
//    private $mimeType;
//
//    /**
//     * @ORM\Column(name="size", type="decimal")
//     * @Gedmo\UploadableFileSize
//     */
//    private $size;

    /**
     * Virtual field to get an upload input in forms
     * @Assert\Image(
     *      maxSize = "6M",
     *      mimeTypes = {"image/jpg", "image/jpeg", "image/png", "image/gif"}
     * )
     */
    protected $picture;

    /**
     * Virtual field to delete picture in forms
     */
    protected $delete;

    /**
     * Hash send with picture through flash uploader
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $token;

//    /**
//     * Hack to detect a changed form with only picture_picture. Work with a small piece of JS on partners forms
//     * @ORM\Column(type="integer", length=14, nullable=true)
//     */
//    protected $change;

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
     * @return Picture
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

//    /**
//     * Set mimeType
//     *
//     * @param string $mimeType
//     * @return File
//     */
//    public function setMimeType($mimeType)
//    {
//        $this->mimeType = $mimeType;
//
//        return $this;
//    }
//
//    /**
//     * Get mimeType
//     *
//     * @return string
//     */
//    public function getMimeType()
//    {
//        return $this->mimeType;
//    }
//
//    /**
//     * Set size
//     *
//     * @param string $size
//     * @return File
//     */
//    public function setSize($size)
//    {
//        $this->size = $size;
//
//        return $this;
//    }
//
//    /**
//     * Get size
//     *
//     * @return string
//     */
//    public function getSize()
//    {
//        return $this->size;
//    }

    /**
     * Set token
     *
     * @param string $token
     * @return Picture
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

//    /**
//     * Set change
//     *
//     * @param integer $change
//     * @return Picture
//     */
//    public function setChange($change)
//    {
//        $this->change = $change;
//
//        return $this;
//    }
//
//    /**
//     * Get change
//     *
//     * @return integer
//     */
//    public function getChange()
//    {
//        return $this->change;
//    }

    /************************************************/
    /*                                              */
    /*           methods                            */
    /*                                              */
    /************************************************/

    public function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return FILES_DESTINATION;
    }

    /**
     * Return root path to picture (include picture name)
     * @return string
     */
    public function getAbsolutePath()
    {
        return null === $this->name ? null : $this->getUploadRootDir().'/'.$this->name;
    }

    public function getWebPath()
    {
        return null === $this->name ? null : '/'.$this->getUploadDir().'/'.$this->name;
    }

    public function getThumbnailAbsolutePath()
    {
        if (($this->getId() === null) || ($this->getName() == null)) {
            return null;
        }
        $thumbnail_info = \pathinfo($this->getAbsolutePath());
        if (is_array($thumbnail_info && array_key_exists('name', $thumbnail_info))) {
            print_r($thumbnail_info);
            return $this->getUploadRootDir().'/'.$thumbnail_info['name'].'_small.'.$thumbnail_info['extension'];
        } else {
            return null;
        }

    }

    public function getThumbnailWebPath()
    {

        if (($this->getId() === null) || ($this->getName() == null)) {
            return null;
        }
        $thumbnail_info = \pathinfo($this->getAbsolutePath());

        if (is_array($thumbnail_info) && array_key_exists('name', $thumbnail_info)) {
            return '/'.$this->getUploadDir().'/'.$thumbnail_info['name'].'_small.'.$thumbnail_info['extension'];
        } else {
            return null;
        }

    }

    /**
     * Partner's picture
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function preUpload()
    {
        if (null !== $this->picture) {
            $this->removeUpload();
            $this->name = hash('sha256',uniqid(null, true)).'.'.$this->picture->guessExtension();

        }

        if (1 == $this->delete) {
            $this->removeUpload();
            $this->name = null;
        }

        // pictureToken is mandatory to upload a picture through flash upload
        if ($this->getToken() == null) {
            $this->token = md5(uniqid(null, true));
        }
    }

    /**
     * Partner's picture
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->picture) {
            return;
        }

        $this->picture->move($this->getUploadRootDir(), $this->name);

//        unset($this->picture);
    }

    /**
     * Delete partner's picture
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($picture = $this->getAbsolutePath()) {
            @unlink($picture);
        }

        if ($thumbnail = $this->getThumbnailAbsolutePath()) {
            @unlink($thumbnail);
        }

        $this->name = null;
    }


    public function getPicture(){
        return $this->picture;
    }
    public function getDelete(){
        return $this->delete;
    }
    public function setPicture($picture){
        $this->picture = $picture;
    }
    public function setDelete($delete){
        $this->delete = $delete;
    }

    public function __toString() {
        return "".$this->getWebPath();
    }
}
