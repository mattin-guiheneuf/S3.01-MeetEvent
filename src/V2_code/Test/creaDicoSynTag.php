<!-- SAE -->
<?php
    // Récupératiob de l'API
    include_once "./synAvecAPI.php";

    // Fonction creaDicoSynTag
    function creaDicoSynTag($CORPUS_TAG)
    {
        echo "Lancement création dicoSynTag <br><br>";

        // VARIABLES
        $dicoSynTag = array(); // Dictionnaire résultat de la fonction

        // TRAITEMENTS
        // Ajout des tags au dicoSynTag pour qu'ils soient également détectés
        foreach ($CORPUS_TAG as $tagCourant) { // Pour chaque tag
            $dicoSynTag += array($tagCourant=>array($tagCourant)); // Ajout dans le dico tagCourant : tagCourant pour que les tags puissent être directement relié à eux-mêmes
        }
    
        // Enrichissement au premier degré du dictionnaire avec les synonymes des tags
        foreach ($CORPUS_TAG as $tagCourant) // Pour chaque tag
        {
            $listeSynTagCourant = synAvecAPI($tagCourant)['synonyms']; // On exploite l'API pour récupérer les synonymes du tagCourant
            
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

        echo "encodage<br>";
        file_put_contents('../data/dicoSynTag.json',json_encode($dicoSynTag,JSON_PRETTY_PRINT));
        echo "encodage terminé<br><br>";

        return $dicoSynTag;
    }

    //$CORPUS_TAG_test = ['mother','father','bulge'];

    //creaDicoSynTag($CORPUS_TAG_test);

?>