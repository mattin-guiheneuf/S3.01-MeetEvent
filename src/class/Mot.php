<?php


/**
 * @file Mot.php
 * @author Yannis Duvignau
 * @brief Fichier contenant la classe Mot
 * @details Contient la structure de la classe Mot ayant un id et un libellé
 * @version 1.0
 */
class Mot {
    /** Attributs */
    /**
     * @brief L'identifiant du mot
     * @var int 
     */
    private $id;

    /**
     * @brief Le libellé du mot
     * @var string 
     */
    private $libelle = "";

    /** Constructeur */
    /**
     * @brief Constructeur de la classe Mot
     * @param string
     */
    public function __construct(string $lib){
        $this->setLibelle($lib);
    }
    
    /** Encapsulation */
    /** $id */
    /**
     * @brief Obtient l'identifiant du mot
     * @return int $id Identifiant du mot
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * @brief Attribut l'identifiant au mot
     * @param int [in] Identifiant du mot
     */
    public function setId(int $id) {
        $this->id = $id;
    }

    /** $libelle */
    /**
     * @brief Obtient le libellé du mot
     * @return string $libelle Libellé du mot
     */
    public function getLibelle() {
        return $this->libelle;
    }

    /**
     * @brief Attribut le libellé au mot
     * @param string [in] Libellé du mot
     */
    public function setLibelle(string $libelle) {
        $this->libelle = $libelle;
    }
}