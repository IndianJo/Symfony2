<?php

namespace JO\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Advert
 *
 * @ORM\Table(name="jo_advert")
 * @ORM\Entity(repositoryClass="JO\PlatformBundle\Entity\AdvertRepository")
 * @ORM\HasLifeCycleCallbacks()
 */
class Advert
{

	//-----------------------------------------------PROPERTIES-----------------------------------------------------
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
   
	 /**
	* @ORM\OneToOne(targetEntity="JO\PlatformBundle\Entity\Image", cascade={"persist"})
	*/
	private $image;

	/**
	* @ORM\ManyToMany(targetEntity="JO\PlatformBundle\Entity\Category", cascade={"persist"})
	*/
	private $categories;

	/**
	* @ORM\OneToMany(targetEntity="JO\PlatformBundle\Entity\Application", mappedBy="advert")
	*/
	private $applications;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date", type="datetime")
	 */
	private $date;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="title", type="string", length=255)
	 */
	private $title;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="author", type="string", length=255)
	 */
	private $author;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="content", type="text")
	 */
	private $content;

	/**
	* @var boolean
	* @ORM\Column(name="published", type="boolean")
	*/
	private $published = true;

	/**
	* @var \DateTime
	* @ORM\Column(name="updateAt", type="datetime", nullable=true)
	*/
	private $updateAt;

	/**
	* @var integer
	* @ORM\Column(name="nb_applications", type="integer")
	*/
	private $nbApplications = 0;

	//------------------------------------------------CONSTRUCTOR-----------------------------------------------------
	public function __construct()
	{
		$this->date = new \Datetime();
		$this->categories = new ArrayCollection();
		$this->applications = new ArrayCollection();
	}
	//------------------------------------------------CALLBACK EVENT-----------------------------------------------------
	
	/**
	* ORM\PreUpdate
	*/
	public function updateDate()
	{
		$this->setUpdateAt(new \Datetime());
	}

	//------------------------------------------------METHODS-----------------------------------------------------	
	/**
	* @ORM\PrePersist
	*/
	public function increaseApplication()
	{
		$this->applications++;
	}

	/**
	* @ORM\PreRemove
	*/
	public function decreaseApplication()
	{
		$this->applications--;
	}
	//------------------------------------------------SETTER / GETTER-----------------------------------------------------
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

	public function setImage(Image $image = null)
	{
	  $this->image = $image;
	}
	public function getImage()
	{
	  return $this->image;
	}

	/**
	 * Add categories
	 *
	 * @param \JO\PlatformBundle\Entity\Category $categories
	 * @return Advert
	 */
	public function addCategory(Category $category)
	{
		$this->categories[] = $category;

		return $this;
	}

	/**
	 * Remove categories
	 *
	 * @param \JO\PlatformBundle\Entity\Category $categories
	 */
	public function removeCategory(Category $category)
	{
		$this->categories->removeElement($category);
	}

	/**
	 * Get categories
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getCategories()
	{
		return $this->categories;
	}

	/**
	 * Add applications
	 *
	 * @param \JO\PlatformBundle\Entity\Application $application
	 * @return Advert
	 */
	public function addApplication(\JO\PlatformBundle\Entity\Application $application)
	{
		$this->applications[] = $application;

		// L'annonce doit être lié à l'application (relation bi-directionel)
		$application->setAdvert($this);

		return $this;
	}

	/**
	 * Remove applications
	 *
	 * @param \JO\PlatformBundle\Entity\Application $application
	 */
	public function removeApplication(\JO\PlatformBundle\Entity\Application $application)
	{
		$this->applications->removeElement($application);
	}

	/**
	 * Get applications
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
    public function setUpdateAt($updateAt)
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
}
