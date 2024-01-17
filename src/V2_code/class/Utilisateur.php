<?php


/**
 * @file Utilisateur.php
 * @author Yannis Duvignau
 * @brief Fichier contenant la classe Utilisateur
 * @details Contient la structure de la classe Utilisateur ayant un id, un nom, une liste de mots, une liste de tags et une recommandation d'évènements
 * @version 1.0
 */

class Utilisateur {
    /** Attributs */
    /**
     * @brief L'identifiant de l'utilisateur
     * @var int 
     */
    private $id;

    /**
     * @brief Le nom de l'utilisateur
     * @var string
     */
    private $nom = "";

    /**
     * @brief Les mots entrés par l'utilisateur
     * @var array
     */
    private $mesMots=  array();

    /**
     * @brief La liste de Tag (attribué) de l'utilisateur.
     * @var array 
     */
    private $desTags= []; 

    /**
     * @brief La recommandation de l'utilisateur.
     * @var Recommandation 
     */
    private $maRecommandation = null;

    /** Constructeur */
    /**
     * @brief Constructeur de la classe Utilisateur
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
     * @brief Obtient l'identifiant de l'utilisateur
     * @return int $id Identifiant de l'utilisateur
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * @brief Attribut l'identifiant à l'utilisateur
     * @param int [in] Identifiant de l'utilisateur
     */
    public function setId(int $id) {
        $this->id = $id;
    }
    
    /** $nom */
    /**
     * @brief Obtient le nom de l'utilisateur
     * @return string $nom Nom de l'utilisateur
     */
    public function getNom() {
        return $this->nom;
    }
    
    /**
     * @brief Attribut le nom à l'utilisateur
     * @param string [in] Nom de l'utilisateur
     */
    public function setNom(string $nom) {
        $this->nom = $nom;
    }
    
    /** $desTags */
    /**
     * @brief Obtient les tags de l'utilisateur
     * @return array $desTags Nom de l'utilisateur
     */
    public function getTags() {
        return $this->desTags;
    }
    
    /**
     * @brief Attribut les tags à l'utilisateur
     * @param array [in] Tags de l'utilisateur
     */
    public function setTags(array $tags) {
        $this->desTags = $tags;
    }
    
    /** $mesMots */
    /**
     * @brief Obtient les mots de l'utilisateur
     * @return array $mesMots Mots de l'utilisateur
     */
    public function getMots() {
        return $this->mesMots;
    }
    
    /**
     * @brief Attribut les mots à l'utilisateur
     * @param array [in] Mots de l'utilisateur
     */
    public function setMots(array $mots) {
        $this->mesMots = $mots;
    }
    
    /** $maRecommandation */
    /**
     * @brief Obtient la recommandation de l'utilisateur
     * @return Recommandation $maRecommandation Recommandation de l'utilisateur
     */
    public function getRecommandation() {
        return $this->maRecommandation;
    }
    
    /**
     * @brief Attribut la recommandation à l'utilisateur
     * @param Recommandation [in] Recommandation de l'utilisateur
     */
    public function setRecommandation(Recommandation $reco) {
        $this->maRecommandation = $reco;
    }

    /** Methode */
    /**
     * @brief Attribuer la liste de Tags à un utilisateur en fonction des mots saisis.
     * @return array
     */
    private function definirTags() {
        // VARIABLES
        $dicoMotToTag = array(); // Le résultat de la fonction avec les étapes par lesquelles on passe pour arriver aux tags
        $listeTag = array(); // Le résultat de la fonction avec la liste des tags
        $listeMot = $this->getMots();
        $dicoSynTag = new DicoSynTags();

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
                $listeSynMot = synAvecAPI($motCourant)['synonyms']; // Appel de l'API pour récupérer les synonymes du mot courant
                foreach ($listeSynMot as $synMotCourant) { // Pour chaque synonyme du motCourant
                    if (array_key_exists($synMotCourant, $dicoSynTag)) { // Si le synMotCourant est présent dans le dicoSynTag
                        // Ajout et enregistrement
                        $dicoMotToTag[$motCourant] = array($synMotCourant, $dicoSynTag[$synMotCourant]);
                        $listeTag[] = $dicoSynTag[$synMotCourant]; // Verif si déjà présent ???
                    }
                    else // Sinon enrichissement de 1 degré supplémentaire (degré 2) à partir des tags
                    {
                        foreach ($dicoSynTag as $syn => $tag) { // Pour chaque synonyme (clé) du dicoSynTag
                            $listeSynSynDicoSynTag = synAvecAPI($syn)['synonyms']; // Appel de l'API pour récupérer les synonymes des clés du dicoSynTag
                            if (in_array($motCourant, $listeSynSynDicoSynTag)) { // Vérif présence du mot de base dans les synonymes de synonymes de tag
                                $dicoMotToTag[$motCourant] = array($syn, $dicoSynTag[$syn]); // Si présent, ajout dans le dicoMotToTag en précisant par quel syn on fait le lien
                                if (!in_array($dicoSynTag[$syn], $listeTag)) { // Vérif que le tag n'est pas déjà présent dans la liste de tags
                                    $listeTag[] = $dicoSynTag[$syn];
                                }
                                break;
                            }
                            elseif (in_array($synMotCourant, $listeSynSynDicoSynTag)) { // Vérif présence du synonyme du mot dans les synonymes de synonymes de tag
                                $dicoMotToTag[$motCourant] = array($synMotCourant, $syn, $dicoSynTag[$syn]); // Si présent, ajout dans le dicoMotToTag en précisant par quel syn on fait le lien
                                if (!in_array($dicoSynTag[$syn], $listeTag)) { // Vérif que le tag n'est pas déjà présent dans la liste de tags
                                    $listeTag[] = $dicoSynTag[$syn];
                                }
                                break;
                            }
                            else // Sinon pas de lien avec le corpus de tags
                            {
                                $dicoMotToTag[$motCourant] = array('Impossible à lier');
                            }
                        }
                    }
                }
            }
        }

        $realListeTag = array(); // Enlever les doublons ou autre (pas nécessaires si vérif presence à chaque ajout dans liste ???)
        foreach ($listeTag as $liste) {
            foreach ($liste as $tag) {
                if (!in_array($tag, $realListeTag)) {
                    $realListeTag[] = $tag;
                }
            }
        }

        // encodage en json
        file_put_contents('./data/motToTag.json',json_encode($dicoMotToTag,JSON_PRETTY_PRINT));

        // Renvoyer
        return $dicoMotToTag;
    }

    /**
     * @brief Attribuer la liste de Mots à un utilisateur en fonction des mots saisis.
     */
    public function definirDescription() {

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
        $nouvelUtilisateur = array(
            "id" => $this->getId(),
            "nom" => $this->getNom(),
            "mots" => $motsLib,
            "tags" => []
        );
        //$donnees['utilisateurs'][$this->getId() - 1]['mots'] = $motsLib;
        
        // Ajouter le nouvel utilisateur à la liste des utilisateurs existants
        $donnees['utilisateurs'][] = $nouvelUtilisateur;
        
        // Écrire les données mises à jour dans le fichier JSON
        file_put_contents('./data/donnees.json', json_encode($donnees, JSON_PRETTY_PRINT));

        //Afficher résultats----------------------------------------
        echo "-----------------------------------";
        echo "<br>Utilisateur ".$this->getNom()." (".$this->getId().") créé ! Il possède les mots : ";
        foreach ($this->getMots() as $mot) {
            echo $mot->getLibelle()." ";
        }
        echo "<br>-----------------------------------";

        $this->definirTags();
    }

    /**
     * @brief Modifier les Mots saisis.
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
        $donnees['utilisateurs'][$this->getId() - 1]['tags'] = $this->getTags();

        // Écrire les données mises à jour dans le fichier JSON
        file_put_contents('donnees.json', json_encode($donnees, JSON_PRETTY_PRINT, 2));

        // Redéfinir les tags en fonction des nouveaux mots
        $this->definirTags();
    }

    /**
     * @brief Désigner des événements qui correspondent aux envies de l'utilisateur.
     * @return array
     */
    public function creerListeSuggest() {
        // Récupérer tous les événements avec leurs pourcentages
        $reco = $this->getRecommandation()->getSuggestion();
    
        // Trier les événements par pourcentage par ordre décroissant
        usort($reco, function ($a, $b) {
            return $b['pourcentage'] <=> $a['pourcentage'];
        });
    
        // Déterminer quels événements recommander
        $evenementsARecommander = [];
        foreach ($reco as $paire) {
            $evenementId = $paire['evenement'];
            $pourcentage = $paire['pourcentage'];
    
            // Filtrer les événements avec une similarité >= 0.7
            if ($pourcentage >= 0.7) {
                $evenementsARecommander[] = $evenementId;
            }
        }
    
        // Si le nombre d'événements recommandés est inférieur à 5, prendre les 5 premiers basés sur le pourcentage
        if (count($evenementsARecommander) < 5) {
            for ($i = 0; $i < 5 && $i < count($reco); $i++) {
                $evenementsARecommander[] = $reco[$i]['evenement'];
            }
        }
    
        return $evenementsARecommander;
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
     * @brief Lier une recommandation et l'événement.
     * @param Recommandation
     */
    public function linkToSuggest(Recommandation $recommandation){
        $this->unlinkToSuggest();
        $this->setRecommandation($recommandation);
    }

     /**
     * METHODE SPECIFIQUE : Délier une recommandation et l'événement.
     *
     */
    /**
     * @brief Délier une recommandation et l'événement.
     */
    public function unlinkToSuggest(){
        if ($this->getRecommandation() != null) {
            $this->maRecommandation = null;
        }
    }

    /**
     * @brief Afficher la description de l'Utilisateur.
     * @param string
     * @return string
     */
    public function toString(string $message) {
        $resultat = $message;
        $resultat .= PHP_EOL . "L'utilisateur " . $this->getId() . " a pour tag : ";

        foreach ($this->getTags() as $element) {
            $resultat .= $element->getLibelle() . " ";
        }

        return $resultat;
    }
}