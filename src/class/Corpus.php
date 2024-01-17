<?php

class Corpus {
    // ATTRIBUTS
    /**
     * @var int 
     */
    private $id;

    /**
     * @var array 
     */
    private $mesTags = [];


    // METHODES
    // CONSTRUCTEUR
    /**
     * Constructeur de la classe Corpus
     * @param int $id
     * @param array $mesTags
     */
    public function __construct(int $id, array $mesTags){
        $this->setId($id);
        $this->setMesTags($mesTags);
    }

    // ENCAPSULATION
    // id
    /**
     * Obtient l'id du Corpus
     * @return int 
     */
    public function getId() {return $this->id;}

    /**
     * Attribut l'id au Corpus
     * @param int
     */
    public function setId(int $id) {$this->id = $id;}


    // id
    /**
     * Obtient les Tags du Corpus
     * @return array 
     */
    public function getMesTags() {return $this->mesTags;}

    /**
     * Attribut les Tags au Corpus
     * @param array
     */
    public function setMesTags(array $mesTags) {$this->mesTags = $mesTags;}
}