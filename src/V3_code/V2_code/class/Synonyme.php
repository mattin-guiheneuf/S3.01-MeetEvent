<?php

/**
 * 
 */

class Synonyme{
    // ATTRIBUTS
    /**
     * @var int L'identifiant du synonyme
     */
    private $id;

    /**
     * @var string Le libellé du synonyme
     */
    private $libelle;

    // CONSTRUCTEUR
    public function __construct(String $lib, int $i = NULL){
        $this->$id = $i;
        $this->$libelle = $lib;
    }

    // METHODES
    // ENCAPSULATION
    // id
    /**
     * Obtient l'id du Synonyme
     * @return int $id
     */
    public function getId() {return $this->id;}
    
    /**
     * Attribuer un id à un Synonyme
     * @param int $idUn identifiant représentant l'id du Synonyme
     */
    public function setId(int $id) {$this->id = $id;}


    // libelle
        /**
     * Obtient le libelle du Synonyme
     * @return string $libelle
     */
    public function getLibelle() {return $this->libelle;}
    
    /**
     * Attribuer un libelle à un Synonyme
     * @param string $libelle - Le libelle du Synonyme
     */
    public function setLibelle(string $libelle) {$this->libelle = $libelle;}
}

?>