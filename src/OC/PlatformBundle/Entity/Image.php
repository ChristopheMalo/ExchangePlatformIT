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
 * @ORM\HasLifeCycleCallbacks
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
     * Var to tempory stock the name of upload file
     * 
     * @var string
     */
    private $tempFilename;


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
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        
        // Check if already had a file for this entity
        if (null !== $this->url)
        {
            // On sauvegarde l'extension du fichier pour le supprimer plus tard
            // Save file extension to remove it later
            $this->tempFilename = $this->url;

            // Reset the values ​​of the url and alt attributes
            $this->url = null;
            $this->alt = null;
        }
    }
    
    /**
   * @ORM\PrePersist()
   * @ORM\PreUpdate()
   */
    public function preUpload()
    {
        // If no file
        if (null === $this->file)
        {
            return;
        }

        // Name of file is id, also, need to store the extension
        $this->url = $this->file->guessExtension();

        // Create the alt attribute of tag < img> from the original value of filename computer user
        $this->alt = $this->file->getClientOriginalName();
    }

    
    /**
     * Manage the upload file
     * 
     * @return string
     * 
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // No file -> nothing is done
        if (null === $this->file)
        {
            return;
        }
        
        // If old file, remove it
        if (null !== $this->tempFilename) {
            $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
            if (file_exists($oldFile))
            {
                unlink($oldFile);
            }
        }
        
        // Moving the uploaded file in the directory (manage by getUploadDir())
        $this->file->move(
            $this->getUploadRootDir(), // The destination directory
            $this->id.'.'.$this->url   // The name of file to be created, here 'id.extension'
        );
    }
    
    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        // Temporarily store the file name, because it depends on the id
        $this->tempFilename = $this->getUploadRootDir() . '/' . $this->id . '.' . $this->url;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        // En PostRemove, on n'a pas accès à l'id, on utilise notre nom sauvegardé
        // In PostRemove , no access to the id , use the saved name
        if (file_exists($this->tempFilename)) {
            // Remove the file
            unlink($this->tempFilename);
        }
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
    
    /**
     * Get the path of image to simplify the use in a view
     * 
     * @return type
     */
    public function getWebPath()
    {
        return $this->getUploadDir() . '/' . $this->getId() . '.' . $this->getUrl(); 
    }
}
