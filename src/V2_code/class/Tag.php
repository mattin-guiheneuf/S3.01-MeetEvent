<?php

/**
 * @file Tag.php
 * @author Yannis Duvignau
 * @brief Fichier contenant la classe Tag
 * @details Contient la structure de la classe Tag ayant un id et un libellé
 * @version 1.0
 */
class Tag {
    /** Attributs */
    /**
     * @brief L'identifiant du tag
     * @var int 
     */
    private $id;

    /**
     * @brief Le libellé du tag
     * @var string 
     */
    private $libelle = "";

    /** Constructeur */
    /**
     * @brief Constructeur de la classe Tag
     * @param string
     */
    public function __construct(string $libelle) {
        $this->setLibelle($libelle);
    }
    
    /** Encapsulation */
    /** $id */
    /**
     * @brief Obtient l'identifiant du tag
     * @return int $id Identifiant du tag
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * @brief Attribut l'identifiant au tag
     * @param int [in] Identifiant du tag
     */
    public function setId(int $id) {
        $this->id = $id;
    }

    /** $libelle */
    /**
     * @brief Obtient le libellé du tag
     * @return string $libelle Libellé du tag
     */
    public function getLibelle() {
        return $this->libelle;
    }

    /**
     * @brief Attribut le libellé au tag
     * @param string [in] Libellé du tag
     */
    public function setLibelle(string $libelle) {
        $this->libelle = $libelle;
    }
}