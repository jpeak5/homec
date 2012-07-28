<?php

namespace Piquage\BillerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * A BillTemplate is the parent of, for example, a monthly bill
 * The template holds values for biller, avg amt, avg day, etc...
 *
 * @author jpeak5
 * @ORM\Entity
 * @ORM\Table(name="Billers")
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="BillTemplates")
 */
class BillTemplate {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Biller", inversedBy="billTemplates")
     * @ORM\JoinColumn(name="biller_id", referencedColumnName="id")
     */
    protected $biller;

    /**
     *
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Bill", mappedBy="bills")
     * 
     */
    protected $bills;

    /**
     *
     * @var string
     * can be set to (monthly, yearly, one-time)
     * @ORM\Column(type="string")
     */
    protected $recurrenceType;

    /**
     * this is the day of the (month|year) on which this is usually due
     * @var integer
     * null if the recurrence type is 'one-time'
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $recurrenceDay;

    /**
     * Average amount of the bill
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $avgAmount;

    /**
     *
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    protected $nickname;

    /**
     *
     * @var active
     * @ORM\Column(type="boolean")
     */
    protected $active;

    /**
     *
     * @var boolean
     * If the bill is charged automatically
     * @ORM\Column(type="boolean")
     * 
     */
    protected $autoDebit;

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

    public function __construct() {
        $this->bills = new ArrayCollection();
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
     * Set recurrenceType
     *
     * @param string $recurrenceType
     */
    public function setRecurrenceType($recurrenceType) {
        $this->recurrenceType = $recurrenceType;
    }

    /**
     * Get recurrenceType
     *
     * @return string 
     */
    public function getRecurrenceType() {
        return $this->recurrenceType;
    }

    /**
     * Set recurrenceDay
     *
     * @param integer $recurrenceDay
     */
    public function setRecurrenceDay($recurrenceDay) {
        $this->recurrenceDay = $recurrenceDay;
    }

    /**
     * Get recurrenceDay
     *
     * @return integer 
     */
    public function getRecurrenceDay() {
        return $this->recurrenceDay;
    }

    /**
     * Set avgAmount
     *
     * @param integer $avgAmount
     */
    public function setAvgAmount($avgAmount) {
        $this->avgAmount = $avgAmount;
    }

    /**
     * Get avgAmount
     *
     * @return integer 
     */
    public function getAvgAmount() {
        return $this->avgAmount;
    }

    /**
     * Set nickname
     *
     * @param string $nickname
     */
    public function setNickname($nickname) {
        $this->nickname = $nickname;
    }

    /**
     * Get nickname
     *
     * @return string 
     */
    public function getNickname() {
        return $this->nickname;
    }

    /**
     * Set active
     *
     * @param boolean $active
     */
    public function setActive($active) {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * Set autoDebit
     *
     * @param boolean $autoDebit
     */
    public function setAutoDebit($autoDebit) {
        $this->autoDebit = $autoDebit;
    }

    /**
     * Get autoDebit
     *
     * @return boolean 
     */
    public function getAutoDebit() {
        return $this->autoDebit;
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
     * Set biller
     *
     * @param Piquage\BillerBundle\Entity\Biller $biller
     */
    public function setBiller(\Piquage\BillerBundle\Entity\Biller $biller) {
        $this->biller = $biller;
    }

    /**
     * Get biller
     *
     * @return Piquage\BillerBundle\Entity\Biller 
     */
    public function getBiller() {
        return $this->biller;
    }


    /**
     * Add bills
     *
     * @param Piquage\BillerBundle\Entity\Bill $bills
     */
    public function addBill(\Piquage\BillerBundle\Entity\Bill $bills)
    {
        $this->bills[] = $bills;
    }

    /**
     * Get bills
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getBills()
    {
        return $this->bills;
    }
}