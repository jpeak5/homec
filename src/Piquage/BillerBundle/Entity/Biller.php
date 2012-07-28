<?php
//// src/piquage/BillerBundle/Entity/Biller.php
namespace Piquage\BillerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Billers")
 */
class Biller
{
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
     * @ORM\Column(type="string", length="100")
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
     * @var boolean
     * 
     * @ORM\Column(type="boolean")
     */
    protected $autoDebit;

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
     */
    public function setName($name)
    {
        $this->name = $name;
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

    /**
     * Set website
     *
     * @param String $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * Get website
     *
     * @return String 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set autoDebit
     *
     * @param boolean $autoDebit
     */
    public function setAutoDebit($autoDebit)
    {
        $this->autoDebit = $autoDebit;
    }

    /**
     * Get autoDebit
     *
     * @return boolean 
     */
    public function getAutoDebit()
    {
        return $this->autoDebit;
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