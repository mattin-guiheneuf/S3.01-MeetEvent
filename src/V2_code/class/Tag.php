<?php

/**
 * Classe représentant un Tag.
 */
class Tag {
    // ATTRIBUTS

    /**
     * @var int l'id du Tag
     */
    private $id;

    /**
     * @var string le libelle du Tag
     */
    private $libelle = "";

    //CONSTRUCTEUR
    /**
     * Constructeur de la classe Tag.
     *
     * @param string $libelle Le libelle à attribuer au Tag créé.
     */
    public function __construct(string $libelle) {
        $this->setLibelle($libelle);
    }
    // GETTERS ET SETTERS
    //id
    /**
     * Obtient l'id du Tag.
     *
     * @return int ID.
     */
    public function getId() {
        return $this->id;
    }
    /**
     * Attribuer l'id à un Tag.
     *
     * @param int $id un id représentant l'id du Tag.
     */
    public function setId(int $id) {
        $this->id = $id;
    }

    //libelle
    /**
     * Obtient le libelle du Tag.
     *
     * @return string Libelle.
     */
    public function getLibelle() {
        return $this->libelle;
    }

    /**
     * Attribuer le libelle à un Tag.
     *
     * @param string $libelle un libelle représentant le libelle du Tag.
     */
    public function setLibelle(string $libelle) {
        $this->libelle = $libelle;
    }
}