<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 * 
 * Class representing an image that can be added to job offer
 * 
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Entity\ImageRepository")
 */

class Image
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;
    
    /**
     * to upload file from form
     * 
     * @var string
     */
    private $file;


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
     * Set url
     *
     * @param string $url
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
    }
    
    /**
     * Get the uploaded file
     * 
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     * Set the uploaded file
     * 
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }
    
    /**
     * Manage the upload file
     * 
     * @return string
     */
    public function upload()
    {
        // No file -> nothing is done
        if (null === $this->file)
        {
            return;
        }

        // Retrieve the original name of the file send by the user
        $name = $this->file->getClientOriginalName();

        // Moving the uploaded file in the directory of our choice
        $this->file->move($this->getUploadRootDir(), $name);

        // the file name is saved in the $url attribute
        $this->url = $name;

        // Create the alt attribute of tag < img>
        $this->alt = $name;
    }
    
    /**
     * Return the relative path to the image for a user browser (relative to the directory /web)
     * 
     * @return string The path
     */
    public function getUploadDir()
    {
        return 'uploads/img';
    }
    
    /**
     * Return the relative path of the image for PHP code (Kind of absolute path)
     * 
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }
}
