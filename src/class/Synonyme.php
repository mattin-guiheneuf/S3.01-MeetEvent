<?php

/**
 * @file Synonyme.php
 * @author Yannis Duvignau
 * @brief Fichier contenant la classe Synonyme
 * @details Contient la structure de la classe Synonyme ayant un id et un libellé
 * @version 1.0
 */

class Synonyme{
    /** Attributs */
    /**
     * @brief L'identifiant du synonyme
     * @var int 
     */
    private $id;

    /**
     * @brief Le libellé du synonyme
     * @var string 
     */
    private $libelle;

    /** Constructeur */
    /**
     * @brief Constructeur de la classe Synonyme
     * @param string
     * @param int
     */
    public function __construct(String $lib, int $i = NULL){
        $this->$id = $i;
        $this->$libelle = $lib;
    }

    /** Encapsulation */
    /** $id */
    /**
     * @brief Obtient l'identifiant du synonyme
     * @return int $id Identifiant du synonyme
     */
    public function getId() {return $this->id;}
    
    /**
     * @brief Attribut l'identifiant au synonyme
     * @param int [in] Identifiant du synonyme
     */
    public function setId(int $id) {$this->id = $id;}


    /** $libelle */
    /**
     * @brief Obtient le libellé du synonyme
     * @return string $libelle Libellé du synonyme
     */
    public function getLibelle() {return $this->libelle;}
    
    /**
     * @brief Attribut le libellé au synonyme
     * @param string [in] Libellé du synonyme
     */
    public function setLibelle(string $libelle) {$this->libelle = $libelle;}
}

?>