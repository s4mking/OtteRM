<?php

namespace Examples\Entity;

use OtteRM\Annotations\Table;
use OtteRM\Annotations\Column;
use OtteRM\Annotations\Type;

/**
 * Class Film
 * @Table(name="films")
 */
class Film
{
    /**
     * @Column(column="id_film")
     * @Type(type="int")
     */
    private $id;

    /**
     * @Column(column="titre")
     * @Type(type="string")
     */
    private $titre;

    /**
     * @Column(column="resum")
     * @Type(type="string")
     */
    private $resum;

    /**
     * @var \DateTime
     * @Column(column="date_debut_affiche")
     * @Type(type="date")
     */
    private $dateDebut;
    /**
     * @var \DateTime
     * @Column(column="date_fin_affiche")
     * @Type(type="date")
     */
    private $dateFin;

    /** 
     * @Column(column="duree_minutes")
     * @Type(type="int")
     */
    private $duration;

    /** 
     * @Column(column="annee_production")
     * @Type(type="int")
     */
    private $year;

    /**
     * @var ?string
     * @Column(column="id_distributeur")
     * @Type(type="relation")
     */
    private $director;

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }



    /**
     * Get the value of resum
     */
    public function getResum()
    {
        return $this->resum;
    }

    /**
     * Set the value of resum
     *
     * @return  self
     */
    public function setResum($resum)
    {
        $this->resum = $resum;

        return $this;
    }

    /**
     * Get the value of dateDebut
     *
     * @return  \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set the value of dateDebut
     *
     * @param  \DateTime  $dateDebut
     *
     * @return  self
     */
    public function setDateDebut(\DateTime $dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get the value of dateFin
     *
     * @return  \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set the value of dateFin
     *
     * @param  \DateTime  $dateFin
     *
     * @return  self
     */
    public function setDateFin(\DateTime $dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get the value of duration
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set the value of duration
     *
     * @return  self
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get the value of year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set the value of year
     *
     * @return  self
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get the value of titre
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set the value of titre
     *
     * @return  self
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get the value of director
     *
     * @return  ?string
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * Set the value of director
     *
     * @param  ?string  $director
     *
     * @return  self
     */
    public function setDirector(?string $director)
    {
        $this->director = $director;

        return $this;
    }
}
