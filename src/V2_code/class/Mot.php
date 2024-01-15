<?php
/**
 * Classe représentant un Mot.
 */
class Mot {
    // ATTRIBUTS
    /**
     * @var int l'id du Mot
     */
    private $id;

    /**
     * @var string le libelle du Mot
     */
    private $libelle = "";

    // GETTERS ET SETTERS
    //id
    /**
     * Obtient l'id du Mot.
     *
     * @return int ID.
     */
    public function getId() {
        return $this->id;
    }
    /**
     * Attribuer l'id à un Mot.
     *
     * @param int $id un id représentant l'id du Mot.
     */
    public function setId(int $id) {
        $this->id = $id;
    }

    //libelle
    /**
     * Obtient le libelle du Mot.
     *
     * @return string Libelle.
     */
    public function getLibelle() {
        return $this->libelle;
    }

    /**
     * Attribuer le libelle à un Mot.
     *
     * @param string $libelle un libelle représentant le libelle du Mot.
     */
    public function setLibelle(string $libelle) {
        $this->libelle = $libelle;
    }
}
?>