<?php

/**
 * Classe représentant un événement.
 */
class Evenement {
    //ATTRIBUTS

    /**
     * @var int L'id de l'evenement.
     */
    private $id;

    /**
     * @var string Le titre de l'evenement.
     */
    private $titre = "";

    /**
     * @var string La date prévu de l'evenement.
     */
    private $date = "";

    /**
     * @var string Le lieu de l'evenement.
     */
    private $lieu = "";

    /**
     * @var array Liste de mots (saisis) de l'evenement.
     */
    private $mesMots = [];

    /**
     * @var array Liste de Tags (attribués) de l'evenement.
     */
    private $desTags = [];


    //METHODES
    //CONSTRUCTEUR

    /**
     * Constructeur de la classe Evenement.
     *
     * @param int $id L'id à attribuer à l'événement créé.
     * @param array $tags Tableau de Tags à attribuer à l'événement créé.
     */
    public function __construct(int $id, array $tags) {
        $this->setId($id);
        $this->setTags($tags);
    }
    //ENCAPSULATION (get&set)
    //id
    /**
     * Obtient l'id de l'événement.
     *
     * @return int ID.
     */
    public function getId() {
        return $this->id;
    }
    /**
     * Attribuer l'id à un évenement.
     *
     * @param int $id un id représentant l'id de l'événement.
     */
    public function setId(int $id) {
        $this->id = $id;
    }
    //tags
    /**
     * Obtient la liste de Tag de l'événement.
     *
     * @return array Tags.
     */
    public function getTags() {
        return $this->desTags;
    }
    /**
     * Attribuer la liste de Tags à un évenement.
     *
     * @param array $tags une liste de Tag représentant les Tags de l'événement.
     */
    public function setTags(array $tags) {
        $this->desTags = $tags;
    }
    //mots
    /**
     * Obtient la liste de Mot de l'événement.
     *
     * @return array Mots.
     */
    public function getMots() {
        return $this->mesMots;
    }
    /**
     * Attribuer la liste de Tags à un évenement.
     *
     * @param array $tags une liste de Mot représentant les Mots de l'événement.
     */
    public function setMots(array $mots) {
        $this->mesMots = $mots;
    }

    //METHODES SPECIFIQUES
    /**
     * METHODE SPECIFIQUE : Attribuer la liste de Tags à un évenement en fonction des mots saisis.
     *
     * @return array $listeTags une liste de Tag représentant les Tags de l'événement.
     */
    private function definirTags() {
        $listeTags = array();
        //TRAITEMENT
        return $listeTags;
    }

    /**
     * METHODE SPECIFIQUE : Attribuer la liste de Mots à un évenement en fonction des mots saisis.
     *
     */
    public function definirDescription() {
        $listeMot = [];
        $motsX = "";

        while (true) {
            $motsX = readline("Entrez un des mots pour décrire l'événement (quit pour quitter): ");

            if ($motsX == "quit") {
                break;
            } else {
                $listeMot[] = $motsX;
            }
        }

        $this->setMots($listeMot);

        // Mise à jour des données
        $donnees['evenements'][$this->getId() - 1]['mots'] = $this->getMots();

        // Écrire les données mises à jour dans le fichier JSON
        file_put_contents('donnees.json', json_encode($donnees, JSON_PRETTY_PRINT));
    
        // Redéfinir les tags en fonction des nouveaux mots
        $this->definirTags();
    }

    /**
     * METHODE SPECIFIQUE : Modifier les Mots saisis.
     *
     */
    public function modifierDescription() {
        $listeMot = $this->getTags();
        echo implode(", ", $this->getTags()) . PHP_EOL;

        while (true) {
            $mot = readline("Entrez un tag (quit pour quitter): ");

            if ($mot == "quit") {
                break;
            } else {
                if (!in_array($mot, $listeMot)) {
                    // AJOUTER le mot
                    $listeMot[] = $mot;
                    echo "L'élément '$mot' a été ajouté à ta liste de tags." . PHP_EOL;
                    echo implode(", ", $this->getTags()) . PHP_EOL;
                } else {
                    // RETIRER le mot car il y est déjà
                    // Demander confirmation de suppression
                    $confirmation = readline("Êtes-vous sûr de vouloir supprimer '$mot' (o/n) : ");
                    if ($confirmation == "o") {
                        $index = array_search($mot, $listeMot);
                        if ($index !== false) {
                            unset($listeMot[$index]);
                            $listeMot = array_values($listeMot); // Réorganiser les indices du tableau
                            echo "L'élément '$mot' a été supprimé de la liste des tags." . PHP_EOL;
                            echo implode(", ", $this->getTags()) . PHP_EOL;
                        }
                    }
                }
            }
        }

        $this->setTags($listeMot);

        // Mise à jour des données
        $donnees['evenements'][$this->getId() - 1]['tags'] = $this->getTags();

        // Écrire les données mises à jour dans le fichier JSON
        file_put_contents('donnees.json', json_encode($donnees, JSON_PRETTY_PRINT, 2));

        // Redéfinir les tags en fonction des nouveaux mots
        $this->definirTags();
    }

    /**
     * METHODE SPECIFIQUE : Supprimer des Tags qui sont attribués à l'utilisateur.
     *
     * @param string $tagASupprimer un tag à supprimer
     */
    public function supprimerTag(string $tagASupprimer) {
        $listeTag = $this->getTags();
        $indiceDuTag = array_search($tagASupprimer, $listeTag);

        // Vérifier si l'élément existe dans la liste
        if ($indiceDuTag !== false) {
            // Utiliser la fonction array_splice pour supprimer l'élément à l'indice trouvé
            array_splice($listeTag, $indiceDuTag, 1);
            echo "L'élément '$tagASupprimer' a été supprimé de la liste." . PHP_EOL;

            // Afficher la liste mise à jour
            echo implode(", ", $listeTag) . PHP_EOL;
        } else {
            echo "L'élément '$tagASupprimer' n'a pas été trouvé dans la liste." . PHP_EOL;
        }

        $this->setTags($listeTag);

        // Mise à jour des données
        $donnees['utilisateurs'][$this->getId() - 1]['tags'] = $this->getTags();

        // Écrire les données mises à jour dans le fichier JSON
        file_put_contents('donnees.json', json_encode($donnees, JSON_PRETTY_PRINT, 2));
    }


    //METHODES USUELLES
    /**
     * METHODE SPECIFIQUE : Afficher la description de l'Evenement.
     *
     * @param string message de base à ajouter a la description de la class Evenement
     * @return string $resultat une chaine de caractere représentant la description de l'événement.
     */
    public function toString(string $message) {
        $resultat = $message;
        $resultat .= "L'évènement " . $this->getId() . " a pour tag : ";

        foreach ($this->getTags() as $element) {
            $resultat .= $element . " ";
        }

        return $resultat;
    }
}

?>