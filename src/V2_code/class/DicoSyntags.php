<?php



/**
 * Cette classe sera un singleton instancié dans le fichier main.php
 */

class DicoSynTags {
    // ATTRIBUTS
    /**
     * @var array Le dictionnaire associant des synonymes de tags à leurs tags
     */
    private $dico = array();

    // CONSTRUCTEUR
    /**
     * Constructeur de la classe DicoSynTags
     * @param Corpus le corpus de tags défini au préalable (singleton)
     */
    public function __construct(Corpus $corpus_tag){
        // Lire le contenu JSON depuis le fichier dicoSynTag
        $jsonDicoSynTag = file_get_contents('./data/dicoSynTag.json');
        if(empty($jsonDicoSynTag)){
            $this->determinerSynonymes($corpus_tag);
        }
        else {
            $this->$dico = json_decode($jsonDicoSynTag, true);
        }
    }

    // MÉTHODES

    /**
     * Fonction permettant de peupler le DicoSynTags
     */
    private function determinerSynonymes($CORPUS_TAG) {
        // VARIABLES
        $dicoSynTag = array();
        $utilise = new ApiSynonyme();

        // TRAITEMENTS
        // Ajout des tags au dicoSynTag pour qu'ils soient également détectés
        foreach ($CORPUS_TAG as $tagCourant) { // Pour chaque tag
            $dicoSynTag += array($tagCourant=>array($tagCourant)); // Ajout dans le dico tagCourant : tagCourant pour que les tags puissent être directement relié à eux-mêmes
        }
    
        // Enrichissement au premier degré du dictionnaire avec les synonymes des tags
        foreach ($CORPUS_TAG as $tagCourant) // Pour chaque tag
        {
            $listeSynTagCourant = $utilise->utiliserApiSyn($tagCourant->getLibelle)['synonyms']; // On exploite l'API pour récupérer les synonymes du tagCourant
            
            foreach($listeSynTagCourant as $synTagCourant) // Pour chaque synonyme du tagCourant
            {
                if(array_key_exists($synTagCourant,$dicoSynTag)){ // Si le synonyme est déjà présent comme clé
                    if(!(in_array($tagCourant,$dicoSynTag[$synTagCourant]))){ // Si le tag est pas déjà dans la liste
                        array_push($dicoSynTag[$synTagCourant],$tagCourant); // On l'ajoute
                    }
                }
                else // Sinon le synonyme est pas encore présent comme clé
                {
                    $dicoSynTag[$synTagCourant] = array($tagCourant); // Donc on l'ajoute associé à son tag
                }
            }
        }

        // Encodage en json
        file_put_contents('./data/dicoSynTag.json',json_encode($dicoSynTag,JSON_PRETTY_PRINT));

        $this->$dico = $dicoSynTag;
    }

    // MÉTHODES D'ENCAPSULATION
    /**
     * @param array[out] Le dictionnaire associant des Synonyme à leurs Tag
     */
    public function getDicoSynTag() {
        return $this->$dico;
    }

    /**
     * @param array[in] Le nouveau dictionnaire associant des Synonyme à des Tag
     */
    public function setDicoSynTag(array $newDico) {
        $this->$dico = $newDico;
    }
}

