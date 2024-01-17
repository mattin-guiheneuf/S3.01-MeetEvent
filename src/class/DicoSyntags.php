<?php

/**
 * @file DicoSyntags.php
 * @author Yannis Duvignau
 * @brief Fichier contenant la classe DicoSyntags
 * @details Contient la structure de la classe DicoSyntags
 * @version 1.0
 */

/**
 * Cette classe sera un singleton instancié dans le fichier main.php
 */

class DicoSynTags {
    /** Attributs */
    /**
     * @brief Le dictionnaire associant des synonymes de tags à leurs tags
     * @var array
     */
    private $dico = array();

    /** Constructeur */
    /**
     * @brief Constructeur de la classe DicoSyntags
     * @param Corpus 
     */
    public function __construct(Corpus $corpus_tag){
        // Lire le contenu JSON depuis le fichier dicoSynTag
        $jsonDicoSynTag = file_get_contents('./data/dicoSynTag.json');
        $this->setDicoSynTag(json_decode($jsonDicoSynTag, true));
    }

    /** Méthodes */
    /**
     * @brief Fonction permettant de peupler le DicoSynTags
     * @param Corpus
     */
    public function determinerSynonymes(Corpus $corpus) {
        // V1
        /* // VARIABLES
        $CORPUS_TAG = $CORPUS_TAG->getMesTags();
        $dicoSynTag = array();
        $utilise = new ApiSynonyme();
        $utiliseTrad = new ApiDeTraduction();

        // TRAITEMENTS
        // Ajout des tags au dicoSynTag pour qu'ils soient également détectés
        foreach ($CORPUS_TAG as $tagCourant) { // Pour chaque tag
            $libTagCourant = $tagCourant->getLibelle();
            $dicoSynTag += array($libTagCourant=>array(new Tag($libTagCourant))); // Ajout dans le dico tagCourant : tagCourant pour que les tags puissent être directement relié à eux-mêmes
        }
    
        // Enrichissement au premier degré du dictionnaire avec les synonymes des tags
        foreach ($CORPUS_TAG as $tagCourant) // Pour chaque tag
        {
            $libTagCourant = $tagCourant->getLibelle();
            $listeSynTagCourant = $utilise->utiliserApiSyn(new Mot($utiliseTrad->utiliserApiTrad(new Mot($libTagCourant),"fr","en")))/* ['synonyms']; // À enlever si pas RapidAPI ; // On exploite l'API pour récupérer les synonymes du tagCourant
            
            foreach($listeSynTagCourant as $synTagCrt) // Pour chaque synonyme du tagCourant
            {
                $synTagCourant = $utiliseTrad->utiliserApiTrad(new Mot($synTagCrt),"en","fr");
                if(array_key_exists($synTagCourant,$dicoSynTag)){ // Si le synonyme est déjà présent comme clé
                    if(!(in_array($libTagCourant,$dicoSynTag[$synTagCourant]))){ // Si le tag est pas déjà dans la liste
                        array_push($dicoSynTag[$synTagCourant],new Tag($libTagCourant)); // On l'ajoute
                    }
                }
                else // Sinon le synonyme est pas encore présent comme clé
                {
                    $dicoSynTag[$synTagCourant] = array(new Tag($libTagCourant)); // Donc on l'ajoute associé à son tag
                }
            }
        }

        // Encodage en json
        file_put_contents('./data/dicoSynTag.json',json_encode($dicoSynTag,JSON_PRETTY_PRINT));

        $this->setDicoSynTag($dicoSynTag); */

        // V2
        // VARIABLES
        $utiliseSyn = new ApiSynonyme();
        $utiliseTrad = new ApiDeTraduction();

        $CORPUS_TAG = array();
        foreach ($corpus as $tagDuCorpus) {
            array_push($CORPUS_TAG,$tagDuCorpus->getLibelle());
        }

        $dicoSynTag = array(); // Dictionnaire résultat de la fonction

        // TRAITEMENTS
        // Ajout des tags au dicoSynTag pour qu'ils soient également détectés
        foreach ($CORPUS_TAG as $tagCourant) { // Pour chaque tag
            $dicoSynTag += array(strtolower($tagCourant)=>array(strtolower($tagCourant))); // Ajout dans le dico tagCourant : tagCourant pour que les tags puissent être directement relié à eux-mêmes
        }
    
        // Enrichissement au premier degré du dictionnaire avec les synonymes des tags
        foreach ($CORPUS_TAG as $tagCourant) // Pour chaque tag
        {
            $listeSynTagCourant = $utiliseSyn->utiliserApiSyn(new Mot(strtolower($utiliseTrad->$utiliserApiTrad(new Mot($tagCourant),"fr","en")))); // On exploite l'API pour récupérer les synonymes du tagCourant
            
            foreach($listeSynTagCourant as $synTagCrt) // Pour chaque synonyme du tagCourant
            {
                $synTagCourant = strtolower($utiliseTrad->$utiliseTrad(new Mot($synTagCrt),"en","fr"));
                if(array_key_exists($synTagCourant,$dicoSynTag)){ // Si le synonyme est déjà présent comme clé
                    if(!(in_array(strtolower($tagCourant),$dicoSynTag[$synTagCourant]))){ // Si le tag est pas déjà dans la liste
                        array_push($dicoSynTag[$synTagCourant],strtolower($tagCourant)); // On l'ajoute
                    }
                }
                else // Sinon le synonyme est pas encore présent comme clé
                {
                    $dicoSynTag[$synTagCourant] = array(strtolower($tagCourant)); // Donc on l'ajoute associé à son tag
                }
            }
        }

        file_put_contents('../data/dicoSynTag.json',json_encode($dicoSynTag,JSON_PRETTY_PRINT));

        $this->setDicoSynTag($dicoSynTag);
    }

    /** Encapsulation */
    /** $DicoSynTag */
    /**
     * @brief Obtient le dictionnaire des synonymes
     * @return array
     */
    public function getDicoSynTag() {
        return $this->$dico;
    }

    /**
     * @brief Attribut le nouveau dictionnaire associant des Synonyme à des Tag
     * @param array
     */
    public function setDicoSynTag(/* array  */$newDico) {
        $this->$dico = $newDico;
    }
}

