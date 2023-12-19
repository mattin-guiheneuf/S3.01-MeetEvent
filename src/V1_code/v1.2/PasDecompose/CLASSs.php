<?php

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

class Evenement {
    //ATTRIBUTS
    private $id;
    private $titre = "";
    private $date = "";
    private $lieu = "";
    private $mesMots = [];
    private $desTags = [];
    private $recommandation = null;

    //METHODES
    //CONSTRUCTEUR
    public function __construct($id, $tags) {
        $this->setId($id);
        $this->setTags($tags);
    }
    //ENCAPSULATION (get&set)
    //id
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
    //tags
    public function getTags() {
        return $this->desTags;
    }
    public function setTags($tags) {
        $this->desTags = $tags;
    }
    //mots
    public function getMots() {
        return $this->mesMots;
    }
    public function setMots($mots) {
        $this->mesMots = $mots;
    }

    //METHODES SPECIFIQUES
    private function definirTags() {
        $listeTags = array();
        //TRAITEMENT
        return $listeTags;
    }

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
    
    public function linkToSuggest($recommandation){
        $this->recommandation = $recommandation;
    }
    public function unlinkToSuggest(){
        if ($this->recommandation != null) {
            $this->recommandation = null;
        }
    }

    //METHODES USUELLES
    public function toString($message) {
        $resultat = $message;
        $resultat .= "L'évènement " . $this->getId() . " a pour tag : ";

        foreach ($this->getTags() as $element) {
            $resultat .= $element . " ";
        }

        return $resultat;
    }
}

class Utilisateur {
    //ATTRIBUTS
    private $id;
    private $nom = "";
    private $mesMots=  [];
    private $desTags= []; 
    public $recommandation = null;

    //METHODES
    //CONSTRUCTEUR
    public function __construct($id, $tags) {
        $this->setId($id);
        $this->setTags($tags);
    }
    //ENCAPSULATION (get&set)
    //id
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
    //tags
    public function getTags() {
        return $this->desTags;
    }
    public function setTags($tags) {
        $this->desTags = $tags;
    }
    //mots
    public function getMots() {
        return $this->mesMots;
    }
    public function setMots($mots) {
        $this->mesMots = $mots;
    }

    //METHODES SPECIFIQUES
    private function definirTags() {
        $listeTags = array();
        //TRAITEMENT
        return $listeTags;
    }

    public function definirDescription() {
        $listeMot = [];
        $motsX = "";

        while (true) {
            $motsX = readline("Entrez un des mots pour décrire l'utilisateur (quit pour quitter): ");

            if ($motsX == "quit") {
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
    public function creerListeSuggest() {
        //On recupere tous les evenement avec leur pourcentage
        $reco = $this->recommandation->getSuggestion();

        //On determine lesquelles sont à recommander
        $evenementsARecommander = [];
    
        foreach ($reco as $paire) {
            $evenementId = $paire['evenement'];
            $pourcentage = $paire['pourcentage'];
    
            // Filtrer les événements avec une similarité >= 0.7
            if ($pourcentage >= 0.7) {
                $evenementsARecommander[] = $evenementId;
            }
        }
    
        // Si le nombre d'événements recommandés est inférieur à 5, trier par pourcentage décroissant et prendre les 5 premiers
        if (count($evenementsARecommander) < 5) {
            usort($reco, function ($a, $b) {
                return $b['pourcentage'] - $a['pourcentage'];
            });
    
            for ($i = 0; $i < 5 && $i < count($reco); $i++) {
                if(!in_array($reco[$i]['evenement'],$evenementsARecommander)){
                    $evenementsARecommander[] = $reco[$i]['evenement'];
                }
            }
        }

        return $evenementsARecommander;
    }

    public function supprimerTag($tagASupprimer) {
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

    public function linkToSuggest($recommandation){
        $this->recommandation = $recommandation;
    }
    public function unlinkToSuggest(){
        if ($this->recommandation != null) {
            $this->recommandation = null;
        }
    }

    //METHODES USUELLES
    public function toString($message) {
        $resultat = $message;
        $resultat .= PHP_EOL . "L'utilisateur " . $this->getId() . " a pour tag : ";

        foreach ($this->getTags() as $element) {
            $resultat .= $element . " ";
        }

        return $resultat;
    }
}

class Tag {
    // ATTRIBUTS
    private $id;
    private $libelle;

    // GETTERS ET SETTERS
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getLibelle() {
        return $this->libelle;
    }

    public function setLibelle($libelle) {
        $this->libelle = $libelle;
    }
}

class Mot {
    // ATTRIBUTS
    private $id = 0;
    private $libelle = "";

    // GETTERS ET SETTERS
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getLibelle() {
        return $this->libelle;
    }

    public function setLibelle($libelle) {
        $this->libelle = $libelle;
    }
}

class Recommandation {
    // ATTRIBUTS
    private $utilisateurConnected = null;
    private $suggestion = array();

    // METHODES
    // GETTER ET SETTER
    public function getSuggestion() {
        return $this->suggestion;
    }

    // METHODE SPECIFIQUE
    public function addSuggestion($evenement, $pourcentage) {
        $this->suggestion[] = array('evenement' => $evenement, 'pourcentage' => $pourcentage);
    }
    public function linkToUser($user){
        $this->utilisateurConnected = $user;
    }
    public function unlinkToUser(){
        if ($this->utilisateurConnected != null) {
            $this->utilisateurConnected = null;
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

    public function calculerSuggestion($tabACM, $objetEvenement) {
        // Supposons que la dernière ligne représente les préférences de l'utilisateur
        $userPreferences = $tabACM[count($tabACM) - 1];

        // Comparaison des événements avec les préférences de l'utilisateur (similarité cosinus)
        for ($i = 0; $i < count($tabACM) - 1; $i++) {
            $event = $tabACM[$i];
            $similarity = $this->cosineSimilarity($userPreferences, $event);
            echo "Similarité entre l'événement {$objetEvenement[$i]->getId()} et l'utilisateur {$this->utilisateurConnected->getId()}: " . $similarity ."</br>". PHP_EOL;
            //Ajouter chaque évènement et sa similarité dans un dico
            $this->addSuggestion($objetEvenement[$i]->getId(), $similarity);
        }
    }

    // METHODE USUELLE
    public function toString() {
        // Affichage des données de la liste de paires
        if ($this->utilisateurConnected == null) {
            echo    PHP_EOL . "La recommandation n'as pas de user attribué </br>".PHP_EOL;
        }
        else {   
            echo    PHP_EOL . "Le user attribué est ". $this->utilisateurConnected->getId() .PHP_EOL;
        }
        foreach ($this->suggestion as $paire) {
            echo PHP_EOL . "Evenement : " . $paire['evenement'] . " -- Pourcentage : " . $paire['pourcentage'] ;
        }
            
    }
}

?>
