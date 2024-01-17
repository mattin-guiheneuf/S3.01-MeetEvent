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
     * @var string Le heure de début de l'evenement.
     */
    private $heure = "";

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
    //titre
    /**
     * Obtient l'id de l'événement.
     *
     * @return string ID.
     */
    public function getTitre() {
        return $this->titre;
    }
    /**
     * Attribuer l'id à un évenement.
     *
     * @param string $id un id représentant l'id de l'événement.
     */
    public function setTitre(string $titre) {
        $this->titre = $titre;
    }
    //titre
    /**
     * Obtient l'id de l'événement.
     *
     * @return string ID.
     */
    public function getDate() {
        return $this->date;
    }
    /**
     * Attribuer l'id à un évenement.
     *
     * @param string $id un id représentant l'id de l'événement.
     */
    public function setDate(string $date) {
        $this->date = $date;
    }
    //titre
    /**
     * Obtient l'id de l'événement.
     *
     * @return string ID.
     */
    public function getHeure() {
        return $this->heure;
    }
    /**
     * Attribuer l'id à un évenement.
     *
     * @param string $id un id représentant l'id de l'événement.
     */
    public function setHeure(string $heure) {
        $this->heure = $heure;
    }
    //titre
    /**
     * Obtient l'id de l'événement.
     *
     * @return string ID.
     */
    public function getLieu() {
        return $this->lieu;
    }
    /**
     * Attribuer l'id à un évenement.
     *
     * @param string $id un id représentant l'id de l'événement.
     */
    public function setLieu(string $lieu) {
        $this->lieu = $lieu;
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
    private function definirTags($dicoSynTag) {
        include_once "module.php";

        // VARIABLES
        $listeMots = $this->getMots();
        $listeMot = array();
        foreach($listeMots as $mot){
            array_push($listeMot,$mot->getLibelle());
        }
        $dicoMotToTag = array(); // Le résultat de la fonction avec les étapes par lesquelles on passe pour arriver aux tags
        $listeTag = array(); // Le résultat de la fonction avec la liste des tags

        // TRAITEMENTS
        foreach ($listeMot as $motCourant) { // Pour chaque mot de la liste
            // Vérif mot en double
            if (array_key_exists($motCourant, $dicoMotToTag)) { // Si le mot est déjà présent dans le dico
                echo $motCourant . " déjà présent dans le dicoMotToTag<br>"; // C'est que le mot est en double
                continue; // équivalent de pass
            }
            // Vérif présence dans dicoSynTag du mot
            if (array_key_exists($motCourant, $dicoSynTag)) { // Si le motCourant est présent dans le dicoSynTag
                // Ajout et enregistrement
                $dicoMotToTag[$motCourant] = $dicoSynTag[$motCourant];
                $listeTag[] = $dicoSynTag[$motCourant];
            }
            else // Sinon enrichissement de 1 degré à partir des mots
            {
                // Synonymes
                $listeSynMot = synAvecAPI(tradMotFrToAng($motCourant)); // Appel de l'API pour récupérer les synonymes du mot courant
                foreach ($listeSynMot as $synMotCrt) { // Pour chaque synonyme du motCourant
                    $synMotCourant = tradMotAngToFr($synMotCrt);
                    if (array_key_exists($synMotCourant, $dicoSynTag)) { // Si le synMotCourant est présent dans le dicoSynTag
                        // Ajout et enregistrement
                        $dicoMotToTag[$motCourant] = array($synMotCourant, $dicoSynTag[$synMotCourant]);
                        $listeTag[] = $dicoSynTag[$synMotCourant]; // Verif si déjà présent ???
                    }
                }

                // Générique
                $listeGenMot = genAvecAPI(tradMotFrToAng($motCourant)); // Appel de l'API pour récupérer les synonymes du mot courant
                foreach ($listeGenMot as $genMotCrt) { // Pour chaque synonyme du motCourant
                    $genMotCourant = tradMotAngToFr($genMotCrt);
                    if (array_key_exists($genMotCourant, $dicoSynTag)) { // Si le synMotCourant est présent dans le dicoSynTag
                        // Ajout et enregistrement
                        $dicoMotToTag[$motCourant] = array($genMotCourant, $dicoSynTag[$genMotCourant]);
                        $listeTag[] = $dicoSynTag[$genMotCourant]; // Verif si déjà présent ???
                    }
                }

                // Triggered
                $listeTrgMot = trgAvecAPI(tradMotFrToAng($motCourant)); // Appel de l'API pour récupérer les synonymes du mot courant
                foreach ($listeTrgMot as $trgMotCrt) { // Pour chaque synonyme du motCourant
                    $trgMotCourant = tradMotAngToFr($trgMotCrt);
                    if (array_key_exists($trgMotCourant, $dicoSynTag)) { // Si le synMotCourant est présent dans le dicoSynTag
                        // Ajout et enregistrement
                        $dicoMotToTag[$motCourant] = array($trgMotCourant, $dicoSynTag[$trgMotCourant]);
                        $listeTag[] = $dicoSynTag[$trgMotCourant]; // Verif si déjà présent ???
                    }
                }

                // Si pas trouvé c'est que pas liable avec le dicoSynTag donc avec le corpus
                if (!(array_key_exists($motCourant,$dicoMotToTag))) {
                    $dicoMotToTag[$motCourant] = array('Impossible à lier'); // On enregistre qu'il n'est pas liable
                }
            }
        }

        // Bonne mise en forme de la liste de tags
        $realListeTag = array(); // Enlever les doublons ou autre (pas nécessaires si vérif presence à chaque ajout dans liste ???)
        foreach ($listeTag as $liste) {
            foreach ($liste as $tag) {
                if (!in_array($tag, $realListeTag)) {
                    $realListeTag[] = $tag;
                }
            }
        }

        // Maj objet
        $this->setTags($realListeTag);

        //Afficher résultats----------------------------------------
        echo "<br>-----------------------------------";
        echo "<br>L'évènement ".$this->getTitre()." (".$this->getId().") est relié aux tags : ";
        echo '<br>';
        print_r($dicoMotToTag);
        echo "<br>-----------------------------------";

        // Maj donnes.json
        // Lire le contenu JSON depuis le fichier
        $contenuJSON = file_get_contents('./data/donnees.json');
        $donnees = json_decode($contenuJSON, true);
        $donnees['evenements'][$this->getId()]['tags'] = $realListeTag;
        file_put_contents('./data/donnees.json', json_encode($donnees, JSON_PRETTY_PRINT));

        // Renvoyer
        return array($dicoMotToTag, $realListeTag);
    }

    /**
     * METHODE SPECIFIQUE : Attribuer la liste de Mots à un évenement en fonction des mots saisis.
     *
     */
    public function definirDescription($dicoSynTag) {

        $motsLib = array();
        foreach ($this->getMots() as $mot) {
            $motsLib[] = $mot->getLibelle();
        }

        //Ajout des données dans le json-------------------------
        // Mise à jour des données
        // Lire le contenu JSON depuis le fichier
        $contenuJSON = file_get_contents('./data/donnees.json');
        $donnees = json_decode($contenuJSON, true);

        // Nouvel utilisateur à ajouter
        $nouvelEvent = array(
            "id" => $this->getId(),
            "titre" => $this->getTitre(),
            "date" => $this->getDate(),
            "heure" => $this->getHeure(),
            "lieu" => $this->getLieu(),
            "mots" => $motsLib,
            "tags" => []
        );
        //$donnees['utilisateurs'][$this->getId() - 1]['mots'] = $motsLib;
        
        // Ajouter le nouvel utilisateur à la liste des utilisateurs existants
        $donnees['evenements'][] = $nouvelEvent;
        
        // Écrire les données mises à jour dans le fichier JSON
        file_put_contents('./data/donnees.json', json_encode($donnees, JSON_PRETTY_PRINT));

        //Afficher résultats----------------------------------------
        echo "-----------------------------------";
        echo "<br>Evenement ".$this->getTitre()." (".$this->getId().") créé ! Il possède les mots : ";
        foreach ($this->getMots() as $mot) {
            echo $mot->getLibelle()." ";
        }
        echo "<br>-----------------------------------";

        $this->definirTags($dicoSynTag);
    }

    /**
     * METHODE SPECIFIQUE : Modifier les Mots saisis.
     *
     */
    public function modifierDescription($dicoSynTag) {
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
        $this->definirTags($dicoSynTag);
    }

    /**
     * METHODE SPECIFIQUE : Supprimer des Tags qui sont attribués à l'utilisateur.
     *
     * @param Tag $tagASupprimer un tag à supprimer
     */
    public function supprimerTag(Tag $tagASupprimer) {
        
        $listeTag = $this->getTags();
        $indiceDuTag = array_search($tagASupprimer, $listeTag);

        // Vérifier si l'élément existe dans la liste
        if ($indiceDuTag !== false) {
            // Utiliser la fonction array_splice pour supprimer l'élément à l'indice trouvé
            array_splice($listeTag, $indiceDuTag, 1);
            echo "L'élément '".$tagASupprimer->getLibelle()."' a été supprimé de la liste." . PHP_EOL;

            // Afficher la liste mise à jour
            echo implode(", ", $listeTag) . PHP_EOL;
        } else {
            echo "L'élément '".$tagASupprimer->getLibelle()."' n'a pas été trouvé dans la liste." . PHP_EOL;
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
            $resultat .= $element->getLibelle() . " ";
        }

        return $resultat;
    }
}