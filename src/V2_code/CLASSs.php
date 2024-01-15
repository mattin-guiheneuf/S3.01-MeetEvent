<?php

/**
 * Nom du fichier : CLASSs.php
 * Description : Ce fichier contient toutes les classes nécessaire à l'algorithme 
 *               et présentes dans le diagramme de classe (Evenement, Utilisateur, Recommandation,Mot et Tag).
 * 
 * @author : Duvignau Yannis
 * Date de création: 17 décembre 2023 (date du jour mais à changer)
 * Dernière mise à jour : 17 décembre 2023
 * 
 * @copyright Copyright (c) 2023, MeetEvent
 */

//____________________________________________________________________________________//
//____________________________________________________________________________________//
//                                                                                    //
//                                   IMPORTATION                                      //
//                                                                                    //
//____________________________________________________________________________________//
//____________________________________________________________________________________//

// Lire le contenu JSON depuis le fichier
$contenuJSON = file_get_contents('donnees.json');
$donnees = json_decode($contenuJSON, true);

//____________________________________________________________________________________//
//____________________________________________________________________________________//
//                                                                                    //
//                                Creation OBJECTS                                    //
//                                                                                    //
//____________________________________________________________________________________//
//____________________________________________________________________________________//

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

/**
 * Classe représentant un utilisateur.
 */
class Utilisateur {
    //ATTRIBUTS

    /**
     * @var int L'id de l'utilisateur.
     */
    private $id;

    /**
     * @var string Le nom/pseudo de l'utilisateur.
     */
    private $nom = "";

    /**
     * @var array La liste de Mot (saisi) de l'utilisateur.
     */
    private $mesMots=  [];

    /**
     * @var array La liste de Tag (attribué) de l'utilisateur.
     */
    private $desTags= []; 

    /**
     * @var Recommandation La recommandation de l'utilisateur.
     */
    private $maRecommandation = null;

    //METHODES
    //CONSTRUCTEUR
    /**
     * Constructeur de la classe Utilisateur.
     *
     * @param int $id L'id à attribuer à l'utilisateur créé.
     * @param array $tags Tableau de Tags à attribuer à l'utilisateur créé.
     */
    public function __construct(int $id, array $tags) {
        $this->setId($id);
        $this->setTags($tags);
    }
    //ENCAPSULATION (get&set)
    //id
    /**
     * Obtient l'id de l'utilisateur.
     *
     * @return int ID.
     */
    public function getId() {
        return $this->id;
    }
    /**
     * Attribuer l'id à un utilisateur.
     *
     * @param int $id un id représentant l'id de l'utilisateur.
     */
    public function setId(int $id) {
        $this->id = $id;
    }
    //nom
    /**
     * Obtient le nom de l'utilisateur.
     *
     * @return string nom.
     */
    public function getNom() {
        return $this->nom;
    }
    /**
     * Attribuer un nom à un utilisateur.
     *
     * @param string $nom un nom représentant le nom de l'utilisateur.
     */
    public function setNom(string $nom) {
        $this->nom = $nom;
    }
    //tags
    /**
     * Obtient la liste de Tag de l'utilisateur.
     *
     * @return array Tags.
     */
    public function getTags() {
        return $this->desTags;
    }
    /**
     * Attribuer la liste de Tags à un utilisateur.
     *
     * @param array $tags une liste de Tag représentant les Tags de l'utilisateur.
     */
    public function setTags(array $tags) {
        $this->desTags = $tags;
    }
    //mots
    /**
     * Obtient la liste de Mot de l'utilisateur.
     *
     * @return array Mots.
     */
    public function getMots() {
        return $this->mesMots;
    }
    /**
     * Attribuer la liste de Tags à un utilisateur.
     *
     * @param array $tags une liste de Mot représentant les Mots de l'utilisateur.
     */
    public function setMots(array $mots) {
        $this->mesMots = $mots;
    }
    //maRecommandation
    /**
     * Obtient la recommandation de l'utilisateur.
     *
     * @return Recommandation maRecommandation.
     */
    public function getRecommandation() {
        return $this->maRecommandation;
    }
    /**
     * Attribuer la recommandation d'un utilisateur.
     *
     * @param Recommandation $reco une recommandation représentant la recommandation de l'utilisateur.
     */
    public function setRecommandation(Recommandation $reco) {
        $this->maRecommandation = $reco;
    }

    //METHODES SPECIFIQUES
    /**
     * METHODE SPECIFIQUE : Attribuer la liste de Tags à un utilisateur en fonction des mots saisis.
     *
     * @return array $listeTags une liste de Tag représentant les Tags de l'utilisateur.
     */
    private function definirTags() {
        $listeTags = array();
        //TRAITEMENT
        return $listeTags;
    }

    /**
     * METHODE SPECIFIQUE : Attribuer la liste de Mots à un utilisateur en fonction des mots saisis.
     *
     */
    public function definirDescription() {
        $listeMot = [];
        $motsX = new Mot();

        while (true) {
            $motsX->setLibelle(readline("Entrez un des mots pour décrire l'utilisateur (quit pour quitter): "));

            if ($motsX->getLibelle() == "quit") {
                break;
            } else {
                $listeMot[] = $motsX;
            }
        }

        $this->setMots($listeMot);

        // Mise à jour des données
        $donnees['utilisateur'][$this->getId() - 1]['mots'] = $this->getMots();

        // Écrire les données mises à jour dans le fichier JSON
        file_put_contents('donnees.json', json_encode($donnees, JSON_PRETTY_PRINT));
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
        $donnees['utilisateurs'][$this->getId() - 1]['tags'] = $this->getTags();

        // Écrire les données mises à jour dans le fichier JSON
        file_put_contents('donnees.json', json_encode($donnees, JSON_PRETTY_PRINT, 2));

        // Redéfinir les tags en fonction des nouveaux mots
        $this->definirTags();
    }

    /**
     * METHODE SPECIFIQUE : Désigner des événements qui correspondent aux envies de l'utilisateur.
     *
     * @return array $evenementsARecommander une liste d'événements à recommander.
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

    /**
     * METHODE SPECIFIQUE : Lier une recommandation et l'événement.
     *
     * @param Recommandation $recommandation une recommandation représentant la recommandation de l'événement.
     */
    public function linkToSuggest(Recommandation $recommandation){
        $this->unlinkToSuggest();
        $this->setRecommandation($recommandation);
    }

     /**
     * METHODE SPECIFIQUE : Délier une recommandation et l'événement.
     *
     */
    public function unlinkToSuggest(){
        if ($this->getRecommandation() != null) {
            $this->maRecommandation = null;
        }
    }

    //METHODES USUELLES
    /**
     * METHODE SPECIFIQUE : Afficher la description de l'Utilisateur.
     *
     * @param string message de base à ajouter a la description de la class Utilisateur
     * @return string $resultat une chaine de caractere représentant la description de l'utilisateur.
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

/**
 * Classe représentant une Recommandation.
 */
class Recommandation {
    // ATTRIBUTS
    private $monUtilisateur = null;
    private $suggestion = array();

    // METHODES
    //CONSTRUCTEUR
    public function __construct(Utilisateur $monUtilisateur = null){
        $this->linkToUser($monUtilisateur);
        $this->monUtilisateur->linkToSuggest($this);
    }
    // GETTER ET SETTER
    //suggestion
    public function getSuggestion() {
        return $this->suggestion;
    }
    private function setSuggestion(Evenement $evenement,float $pourcentage){
        $this->suggestion[] = array('evenement' => $evenement->getId(), 'pourcentage' => $pourcentage);
    }
    //monUtilisateur
    public function getUtilisateur(){
        return $this->monUtilisateur;
    }
    public function setUtilisateur(Utilisateur $user){
        $this->monUtilisateur = $user;
    }

    // METHODE SPECIFIQUE
    private function linkToUser(Utilisateur $user){
        $this->unlinkToUser();
        $this->setUtilisateur($user);
    }
    private function unlinkToUser(){
        if ($this->monUtilisateur != null) {
            $this->monUtilisateur = null;
        }
    }

    // Fonction pour calculer le produit scalaire
    private function dotProduct($vec1, $vec2) {
        $result = 0;
        $length = count($vec1);

        for ($i = 0; $i < $length; $i++) {
            $result += $vec1[$i] * $vec2[$i];
        }
        return $result;
    }

    // Fonction pour calculer la norme
    private function norm($vec) {
        return sqrt(array_reduce($vec, function ($acc, $val) {
            return $acc + $val * $val;
        }, 0));
    }

    // Fonction pour calculer la similarité cosinus
    private function cosineSimilarity($vec1, $vec2) {
        $dot = $this->dotProduct($vec1, $vec2);
        $normVec1 = $this->norm($vec1);
        $normVec2 = $this->norm($vec2);

        // Vérifier si les vecteurs ont une norme non nulle
        if ($normVec1 != 0 && $normVec2 != 0) {
            return number_format($dot / ($normVec1 * $normVec2), 2);
        } else {
            return 0; // Retourner 0 si l'une des normes est nulle
        }
    }

    public function calculerSuggestion(array $tabACM,array $objetEvenement) {
        // Supposons que la dernière ligne représente les préférences de l'utilisateur
        $userPreferences = $tabACM[count($tabACM) - 1];

        // Comparaison des événements avec les préférences de l'utilisateur (similarité cosinus)
        for ($i = 0; $i < count($tabACM) - 1; $i++) {
            $event = $tabACM[$i];
            $similarity = $this->cosineSimilarity($userPreferences, $event);
            echo "Similarité entre l'événement {$objetEvenement[$i]->getId()} et l'utilisateur {$this->monUtilisateur->getId()}: " . $similarity ."</br>". PHP_EOL;
            //Ajouter chaque évènement et sa similarité dans un dico
            $this->setSuggestion($objetEvenement[$i],(float) $similarity);
        }
    }

    // METHODE USUELLE
    public function toString() {
        // Affichage des données de la liste de paires
        if ($this->monUtilisateur == null) {
            echo    PHP_EOL . "La recommandation n'as pas de user attribué </br>".PHP_EOL;
        }
        else {   
            echo    PHP_EOL . "Le user attribué est ". $this->monUtilisateur->getId() .PHP_EOL;
        }
        foreach ($this->suggestion as $paire) {
            echo PHP_EOL . "Evenement : " . $paire['evenement'] . " -- Pourcentage : " . $paire['pourcentage'] ;
        }
            
    }
}

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

?>
