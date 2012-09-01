<?php

namespace Piquage\BillsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="bills")
 * @ORM\Entity(repositoryClass="Piquage\BillsBundle\Repository\BillRepository")
 */
class Bill {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @var type 
     * 
     * @ORM\ManyToOne(targetEntity="BillTemplate", inversedBy="bills")
     * @ORM\JoinColumn(name="billTemplate", referencedColumnName="id")
     */
    protected $billTemplate;

    /**
     *
     * @var Float
     * 
     * @ORM\Column(type="decimal", scale=2)
     * 
     */
    protected $amount;

    /**
     *
     * @var Date
     * 
     * @ORM\Column(type="date")
     * 
     */
    protected $due;

    /**
     *
     * @var Date
     * 
     * @ORM\Column(type="date", nullable=true)
     */
    protected $scheduled;

    /**
     *
     * @var Date
     * When is this bill supposed to pay out
     * 
     * @ORM\Column(type="date", nullable=true)
     */
    protected $paid;

    /**
     *
     * @var Date
     * Date this bill cleared the bank
     * @ORM\Column(type="date", nullable=true)
     */
    protected $cleared;

    /**
     *
     * @var string
     * confirmation number, if available
     * @ORM\Column(type="string", nullable=true)
     */
    protected $confNumber;

    /**
     *
     * @var datetime
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     *
     * @var datetime
     * @ORM\Column(type="datetime")
     */
    protected $updated;

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

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set amount
     *
     * @param decimal $amount
     */
    public function setAmount($amount) {
        $this->amount = $amount;
    }

    /**
     * Get amount
     *
     * @return decimal 
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * Set due
     *
     * @param datetime $due
     */
    public function setDue($due) {
        $this->due = $due;
    }

    /**
     * Get due
     *
     * @return datetime 
     */
    public function getDue() {
        return $this->due;
    }

    /**
     * Set scheduled
     *
     * @param datetime $scheduled
     */
    public function setScheduled($scheduled) {
        $this->scheduled = $scheduled;
    }

    /**
     * Get scheduled
     *
     * @return datetime 
     */
    public function getScheduled() {
        return $this->scheduled;
    }

    /**
     * Set paid
     *
     * @param datetime $paid
     */
    public function setPaid($paid) {
        $this->paid = $paid;
    }

    /**
     * Get paid
     *
     * @return datetime 
     */
    public function getPaid() {
        return $this->paid;
    }

    /**
     * Set cleared
     *
     * @param datetime $cleared
     */
    public function setCleared($cleared) {
        $this->cleared = $cleared;
    }

    /**
     * Get cleared
     *
     * @return datetime 
     */
    public function getCleared() {
        return $this->cleared;
    }

    /**
     * Set confNumber
     *
     * @param string $confNumber
     */
    public function setConfNumber($confNumber) {
        $this->confNumber = $confNumber;
    }

    /**
     * Get confNumber
     *
     * @return string 
     */
    public function getConfNumber() {
        return $this->confNumber;
    }

    /**
     * Set billTemplate
     *
     * @param Piquage\BillsBundle\Entity\BillTemplate $billTemplate
     */
    public function setBillTemplate(\Piquage\BillsBundle\Entity\BillTemplate $billTemplate) {
        $this->billTemplate = $billTemplate;
    }

    /**
     * Get billTemplate
     *
     * @return Piquage\BillsBundle\Entity\BillTemplate 
     */
    public function getBillTemplate() {
        return $this->billTemplate;
    }


    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return datetime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * Get updated
     *
     * @return datetime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}