<?php

// src/piquage/BillerBundle/Entity/Biller.php

namespace Piquage\BillerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\HasLifeCycleCallbacks
 * @ORM\Table(name="Billers")
 */
class Biller {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @var string
     * 
     * @ORM\Column(type="string", length="100", unique=true)
     */
    protected $name;

    /**
     *
     * @var string
     * 
     * @ORM\Column(type="string", length="200")
     */
    protected $website;

    /**
     *
     * @var datetime
     * 
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     *
     * @var datetime
     * 
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @ORM\OneToMany(targetEntity="BillTemplate", mappedBy="biller")
     */
    protected $billTemplates;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedValue() {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue() {
        $this->updated = new \DateTime();
    }

    public function __construct() {
        $this->billTemplates = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set website
     *
     * @param string $website
     */
    public function setWebsite($website) {
        $this->website = $website;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite() {
        return $this->website;
    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created) {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return datetime 
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     */
    public function setUpdated($updated) {
        $this->updated = $updated;
    }

    /**
     * Get updated
     *
     * @return datetime 
     */
    public function getUpdated() {
        return $this->updated;
    }

    /**
     * Add billTemplates
     *
     * @param Piquage\BillerBundle\Entity\BillTemplate $billTemplates
     */
    public function addBillTemplate(\Piquage\BillerBundle\Entity\BillTemplate $billTemplates) {
        $this->billTemplates[] = $billTemplates;
    }

    /**
     * Get billTemplates
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getBillTemplates() {
        return $this->billTemplates;
    }

}