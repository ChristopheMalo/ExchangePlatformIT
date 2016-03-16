<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use OC\PlatformBundle\Validator\Antiflood;

/**
 * Advert
 * 
 * Class representing a job offer
 * This class contains lyfe cycle callbacks
 * 
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Entity\AdvertRepository")
 * @ORM\HasLifecycleCallbacks()
 */

class Advert
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\Datetime()
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\Length(min=10)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     * @Assert\Length(min=2)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank()
     * @Antiflood()
     */
    private $content;
    
    /**
     * @var boolean
     * 
     * @ORM\Column(name="published", type="boolean")
     */
    private $published = true;
    
    /**
     * @var integer
     * 
     * @ORM\OneToOne(targetEntity="OC\PlatformBundle\Entity\Image", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $image;
    
    /**
     * @ORM\ManyToMany(targetEntity="OC\PlatformBundle\Entity\Category", cascade={"persist"})
     */
    private $categories;
    
    /**
     * Job offer is link to many applications
     * Bidirectional relation
     * 
     * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\Application", mappedBy="advert")
     */
    private $applications;
    
    /**
     * Represent the date of the last edition of the announcement
     * 
     * @var \Datetime
     * 
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updateAt;
    
    /**
     * Represent a counter of number applications for a job offer
     * 
     * @var integer
     * 
     * @ORM\Column(name="nb_applications", type="integer")
     */
    private $nbApplications = 0;
    
    /**
     * Slug for job offer
     * 
     * @var string
     * 
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;
    
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->date = new \Datetime(); // By default, the date of the job offer is the date today
        $this->categories = new ArrayCollection();
        $this->applications = new ArrayCollection();
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
     * Set date
     *
     * @param \DateTime $date
     * @return Advert
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Advert
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
     * Set author
     *
     * @param string $author
     * @return Advert
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Advert
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return Advert
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set image
     *
     * @param \OC\PlatformBundle\Entity\Image $image
     * @return Advert
     */
    public function setImage(Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \OC\PlatformBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add category
     *
     * @param \OC\PlatformBundle\Entity\Category $category
     * @return Advert
     */
    public function addCategory(Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \OC\PlatformBundle\Entity\Category $category
     */
    public function removeCategory(Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories (array)
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add application
     *
     * @param \OC\PlatformBundle\Entity\Application $application
     * @return Advert
     */
    public function addApplication(Application $application)
    {
        $this->applications[] = $application;
        
        // Link job offer to application
        $application->setAdvert($this);

        return $this;
    }

    /**
     * Remove application
     *
     * @param \OC\PlatformBundle\Entity\Application $application
     */
    public function removeApplication(Application $application)
    {
        $this->applications->removeElement($application);
        
        // if relation is optional (nullable = true)
        // $application->setAdvert(null);
    }

    /**
     * Get applications (array)
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     * @return Advert
     */
    public function setUpdateAt(\Datetime $updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime 
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }
    
    /**
     * This method should set the $updatedAt attribute to the current date ,
     * to automatically update the release date of job offer
     * 
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
        $this->setUpdateAt(new \Datetime());
    }
    
    /**
     * Increase the counter of applications for a job offer
     * 
     * @ORM\PrePersist
     */
    public function increaseApplication()
    {
        $this->nbApplications++;
    }
    
    /**
     * Decrease the counter of applications for a job offer
     * 
     * @ORM\PreRemove
     */
    public function decreaseApplication()
    {
        $this->nbApplications--;
    }

    /**
     * Set nbApplications
     *
     * @param integer $nbApplications
     * @return Advert
     */
    public function setNbApplications($nbApplications)
    {
        $this->nbApplications = $nbApplications;

        return $this;
    }

    /**
     * Get nbApplications
     *
     * @return integer 
     */
    public function getNbApplications()
    {
        return $this->nbApplications;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Advert
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
