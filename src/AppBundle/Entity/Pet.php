<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as Grid;

/**
 * Pet
 * @ORM\Table(name="pet")
 * @ORM\Entity
 * 
 *@ORM\Entity(repositoryClass="AppBundle\Repository\PetRepository")
 */
class Pet
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Grid\Column(filterable=false, visible=false, export=false)
     */
    protected $id;
    
    
    /**
     * @var string
     
     * @ORM\Column(name="race", type="string") 
     * @Grid\Column(field="race", title="Race",  size="120", filterable=true,defaultOperator="eq",operators={"eq","like"}, visible=true)
     */
    private $race;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     * @Grid\Column(field="name", title="Name", size="120", filterable=false, visible=true)
    */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string")
     * @Grid\Column(field="description", size="120", title="Description", filterable=false, visible=true)
    */
    private $description;
    
    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string")
     * @Grid\Column(field="location", title="Last known location", size="120", filterable=false, visible=true)
    */
    private $location;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="found", type="boolean")
     * @Grid\Column(field="found", title="Found?", filterable=true, visible=false)
    */
    private $found;
    
    function getId() {
        return $this->id;
    }
       
    function getRace() {
        return $this->race;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getLocation() {
        return $this->location;
    }

    function setRace($race) {
        $this->race = $race;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setLocation($location) {
        $this->location = $location;
    }
    
    function getFound() {
        return $this->found;
    }

    function setFound($found) {
        $this->found = $found;
    }




}
