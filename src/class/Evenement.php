<?php

/**
 * @file Evenement.php
 * @author Yannis Duvignau
 * @brief Fichier contenant la classe Evenement
 * @details Contient la structure de la classe Evenement ayant un id, un titre, une date, une heure, un lieu, une liste de mots et une liste de tags
 * @version 1.0
 */
class Evenement {
    /** Attributs */
    /**
     * @brief L'identifiant de l'évènement
     * @var int 
     */
    private $id;

    /**
     * @brief Le titre de l'évènement
     * @var string Le titre de l'evenement.
     */
    private $titre = "";

    /**
     * @brief La date de l'évènement
     * @var string La date prévu de l'evenement.
     */
    private $date = "";

    /**
     * @brief L'heure de l'évènement
     * @var string Le heure de début de l'evenement.
     */
    private $heure = "";

    /**
     * @brief Le lieu de l'évènement
     * @var string Le lieu de l'evenement.
     */
    private $lieu = "";

    /**
     * @brief La liste de mots saisie par l'organisateur pour l'évènement
     * @var array Liste de mots (saisis) de l'evenement.
     */
    private $mesMots = [];

    /**
     * @brief La liste de tags attribuée à l'évènement
     * @var array Liste de Tags (attribués) de l'evenement.
     */
    private $desTags = [];


    /** Constructeur */
    /**
     * @brief Constructeur de la classe Evenement
     * @param int 
     * @param array
     */
    public function __construct(int $id, array $tags) {
        $this->setId($id);
        $this->setTags($tags);
    }
    
    /** Encapsulation */
    /** $id */
    /**
     * @brief Obtient l'identifiant de l'évènement
     * @return int $id Identifiant de l'évènement
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * @brief Attribut l'identifiant à l'évènement
     * @param int [in] Identifiant de l'évènement
     */
    public function setId(int $id) {
        $this->id = $id;
    }
    
    /** $titre */
    /**
     * @brief Obtient le titre de l'évènement
     * @return string $titre Titre de l'évènement
     */
    public function getTitre() {
        return $this->titre;
    }
    
    /**
     * @brief Attribut le titre à l'évènement
     * @param string [in] Titre de l'évènement
     */
    public function setTitre(string $titre) {
        $this->titre = $titre;
    }
    
    /** $date */
    /**
     * @brief Obtient la date de l'évènement
     * @return string $date Date de l'évènement
     */
    public function getDate() {
        return $this->date;
    }
    
    /**
     * @brief Attribut la date à l'évènement
     * @param string [in] Date de l'évènement
     */
    public function setDate(string $date) {
        $this->date = $date;
    }
    
    /** $heure */
    /**
     * @brief Obtient l'heure de l'évènement
     * @return string $heure Heure de l'évènement
     */
    public function getHeure() {
        return $this->heure;
    }
    
    /**
     * @brief Attribut l'heure à l'évènement
     * @param string [in] Heure de l'évènement
     */
    public function setHeure(string $heure) {
        $this->heure = $heure;
    }
    
    /** $lieu */
    /**
     * @brief Obtient le lieu de l'évènement
     * @return string $lieu Lieu de l'évènement
     */
    public function getLieu() {
        return $this->lieu;
    }
    
    /**
     * @brief Attribut le lieu à l'évènement
     * @param string [in] Lieu de l'évènement
     */
    public function setLieu(string $lieu) {
        $this->lieu = $lieu;
    }
    
    /** $desTags */
    /**
     * @brief Obtient les tags de l'évènement
     * @return array $desTags Tags de l'évènement
     */
    public function getTags() {
        return $this->desTags;
    }
    
    /**
     * @brief Attribut les tags à l'évènement
     * @param array [in] Tags de l'évènement
     */
    public function setTags(array $tags) {
        $this->desTags = $tags;
    }
    
    /** $mesMots */
    /**
     * @brief Obtient les mots de l'évènement
     * @return array $mesMots Mots de l'évènement
     */
    public function getMots() {
        return $this->mesMots;
    }
    
    /**
     * @brief Attribut les mots à l'évènement
     * @param array [in] Mots de l'évènement
     */
    public function setMots(array $mots) {
        $this->mesMots = $mots;
    }

    /** Methode */
    /**
     * @brief Attribuer la liste de Tags à un évenement en fonction des mots saisis.
     * @param array
     * @return array
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
			
			// Création de la clé motCourant dans le dicoMotTTag
            $dicoMotToTag[$motCourant] = array();
			
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
                        array_push($dicoMotToTag[$motCourant],array($synMotCourant, $dicoSynTag[$synMotCourant]));
                        $listeTag[] = $dicoSynTag[$synMotCourant]; // Verif si déjà présent ???
                    }
                }

                // Générique
                $listeGenMot = genAvecAPI(tradMotFrToAng($motCourant)); // Appel de l'API pour récupérer les synonymes du mot courant
                foreach ($listeGenMot as $genMotCrt) { // Pour chaque synonyme du motCourant
                    $genMotCourant = tradMotAngToFr($genMotCrt);
                    if (array_key_exists($genMotCourant, $dicoSynTag)) { // Si le synMotCourant est présent dans le dicoSynTag
                        // Ajout et enregistrement
                        array_push($dicoMotToTag[$motCourant],array($genMotCourant, $dicoSynTag[$genMotCourant]));
                        $listeTag[] = $dicoSynTag[$genMotCourant]; // Verif si déjà présent ???
                    }
                }

                // Triggered
                $listeTrgMot = trgAvecAPI(tradMotFrToAng($motCourant)); // Appel de l'API pour récupérer les synonymes du mot courant
                foreach ($listeTrgMot as $trgMotCrt) { // Pour chaque synonyme du motCourant
                    $trgMotCourant = tradMotAngToFr($trgMotCrt);
                    if (array_key_exists($trgMotCourant, $dicoSynTag)) { // Si le synMotCourant est présent dans le dicoSynTag
                        // Ajout et enregistrement
                        array_push($dicoMotToTag[$motCourant],array($trgMotCourant, $dicoSynTag[$trgMotCourant]));
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
        echo "<br><br>-----------------------------------";
        echo "<br>Évènement ".$this->getTitre()." (".$this->getId().") possède les tags : ";
        foreach ($this->getTags() as $tag) {
            echo $tag." ";
        }
        echo "<br>-----------------------------------";

        //Afficher résultats----------------------------------------
        echo "<br><br>-----------------------------------";
        echo "<br>L'évènement ".$this->getTitre()." (".$this->getId().") est relié aux tags grâce à : ";
        echo '<br>';
        foreach ($dicoMotToTag as $mot => $listeLien) {
            echo '<br>' . $mot . ' est relié à : <br>';
            foreach ($listeLien as $lien) {
                echo '  - ';
                if(is_array($lien)){
                    foreach ($lien[1] as $motLien) {
                        echo $motLien . ' ';
                    }
                    echo ' par le mot ' . $lien[0];
                }
                else {
                    print_r($lien);
                }
                echo '<br>';
            }
            /* echo '<br>'; */
        }
        echo "<br>-----------------------------------";

        // Maj donnes.json
        // Lire le contenu JSON depuis le fichier
        $contenuJSON = file_get_contents('./data/donnees.json');
        $donnees = json_decode($contenuJSON, true);
        $donnees['evenements'][$this->getId()-1-10000]['tags'] = $realListeTag;
        file_put_contents('./data/donnees.json', json_encode($donnees, JSON_PRETTY_PRINT));

        // Renvoyer
        return array($dicoMotToTag, $realListeTag);
    }

    /**
     * @brief Attribuer la liste de Mots à un évenement en fonction des mots saisis.
     * @param array
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
     * @brief Modifier les Mots saisis.
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
     * @brief Supprimer des Tags qui sont attribués à l'utilisateur.
     * @param Tag
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


    /**
     * @brief Afficher la description de l'Evenement.
     * @param string
     * @return string
     */
    public function toString(string $message) {
        $resultat = $message;
        $resultat .= "<strong>L'évènement " . $this->getId() . " a pour tag :</strong> ";

        foreach ($this->getTags() as $element) {
            $resultat .= $element->getLibelle() . " ";
        }

        return $resultat;
    }
}