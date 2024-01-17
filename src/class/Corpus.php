<?php
/**
 * @file Corpus.php
 * @author Yannis Duvignau
 * @brief Fichier contenant la classe Corpus
 * @details Contient la structure de la classe Corpus ayant un nom et une liste de Tag
 * @version 1.0
 */

 /**
  * Classe Corpus qui permet de mettre en place le Corpus de Tag
  */

class Corpus {
    /** Attributs */
    /**
     * @brief L'identifiant du Corpus
     * @var int 
     */
    private $id;

    /**
     * @brief Liste de Tag contenu dans le Corpus
     * @var Tag[]
     */
    private $mesTags = [];


    /** Methodes */
    /** Constructeur */
    /**
     * @brief Constructeur de la classe Corpus
     * @param int $id Identifiant du Corpus
     * @param Tag[] $mesTags Liste des Tag présent dans le Corpus 
     */
    public function __construct(int $id, array $mesTags){
        $this->setId($id);
        $this->setMesTags($mesTags);
    }

    /** Encapsulation */
    /** $id */
    /**
     * @brief Obtient l'identifiant du Corpus
     * @return int $id Identifiant du Corpus
     */
    public function getId() {return $this->id;}

    /**
     * @brief Attribut l'identifiant au Corpus
     * @param int [in] Identifiant du Corpus
     */
    public function setId(int $id) {$this->id = $id;}


    // $mesTags
    /**
     * @brief Obtient les Tags du Corpus
     * @return Tag[] $mesTags Liste des Tag présent dans le Corpus 
     */
    public function getMesTags() {return $this->mesTags;}

    /**
     * @brief Attribut les Tags au Corpus
     * @param Tag[] $mesTags Liste des Tag présent dans le Corpus 
     */
    public function setMesTags(array $mesTags) {$this->mesTags = $mesTags;}
}