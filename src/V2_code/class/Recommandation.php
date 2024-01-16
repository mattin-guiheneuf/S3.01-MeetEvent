<?php
/**
 * @file Recommandation.php
 * @author Yannis Duvignau
 * @brief Fichier contenant la classe Recommandation
 * @details Contient la structure de la classe Mot ayant un utilisateur et un array d'évènements
 * @version 1.0
 */
class Recommandation {
    /** Attributs */
    /**
     * @brief L'utilisateur de la recommandation
     * @var Utilisateur 
     */
    private $monUtilisateur = null;

    /**
     * @brief Les évènements suggérer à l'utilisateur
     * @var array 
     */
    private $suggestion = array();


    /** Constructeur */
    /**
     * @brief Constructeur de la classe Recommandation
     * @param Utilisateur
     */
    public function __construct(Utilisateur $monUtilisateur = null){
        $this->linkToUser($monUtilisateur);
        $this->monUtilisateur->linkToSuggest($this);
    }
    
    /** Encapsulation */
    /** $suggestion */
    /**
     * @brief Obtient la suggestion de l'utilisateur
     * @return array $suggestion Suggestion de l'utilisateur
     */
    public function getSuggestion() {
        return $this->suggestion;
    }

    /**
     * @brief Attribut la suggestion à l'utilisateur
     * @param Evenement [in] Evenement suggérer
     * @param float [in] Pourcentage de suggestion
     */
    private function setSuggestion(Evenement $evenement,float $pourcentage){
        $this->suggestion[] = array('evenement' => $evenement->getId(), 'pourcentage' => $pourcentage);
    }

    /** $monUtilisateur */
    /**
     * @brief Obtient l'utilisateur'
     * @return Utilisateur $monUtilisateur Utilisateur pour la recommandation
     */
    public function getUtilisateur(){
        return $this->monUtilisateur;
    }

    /**
     * @brief Attribut l'utilisateur pour la recommandation
     * @param Utilisateur [in] Utilisateur pour la recommandation 
     */
    public function setUtilisateur(Utilisateur $user){
        $this->monUtilisateur = $user;
    }

    // METHODE SPECIFIQUE
    /** Methode */
    /**
     * @brief Lier un utilisateur
     */
    private function linkToUser(Utilisateur $user){
        $this->unlinkToUser();
        $this->setUtilisateur($user);
    }

    /**
     * @brief Délier un utilisateur
     */
    private function unlinkToUser(){
        if ($this->monUtilisateur != null) {
            $this->monUtilisateur = null;
        }
    }

    /**
     * @brief Calculer le produit scalaire
     * @param array
     * @param array
     * @return int
     */
    private function dotProduct($vec1, $vec2) {
        $result = 0;
        $length = count($vec1);

        for ($i = 0; $i < $length; $i++) {
            $result += $vec1[$i] * $vec2[$i];
        }
        return $result;
    }

    /**
     * @brief Calculer la norme
     * @param array
     * @return int
     */
    private function norm($vec) {
        return sqrt(array_reduce($vec, function ($acc, $val) {
            return $acc + $val * $val;
        }, 0));
    }

    /**
     * @brief Calculer la similarité cosinus
     * @param array
     * @param array
     * @return string
     */
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

    /**
     * @brief Calculer le pourcentage de suggestion
     * @param array
     * @param array
     */
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

    /**
     * @brief Afficher la description de la recommandation.
     */
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