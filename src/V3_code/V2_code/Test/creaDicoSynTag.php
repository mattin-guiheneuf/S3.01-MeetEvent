<!-- SAE -->
<?php
    // Récupératiob de l'API
    //include_once "./synAvecAPI.php";

    

    // Fonction creaDicoSynTag
    function creaDicoSynTag($CORPUS_TAG)
    {
        echo "Lancement création dicoSynTag <br><br>";

        // VARIABLES
        $dicoSynTag = array(); // Dictionnaire résultat de la fonction

        // TRAITEMENTS
        // Ajout des tags au dicoSynTag pour qu'ils soient également détectés
        foreach ($CORPUS_TAG as $tagCourant) { // Pour chaque tag
            $dicoSynTag += array(strtolower($tagCourant)=>array(strtolower($tagCourant))); // Ajout dans le dico tagCourant : tagCourant pour que les tags puissent être directement relié à eux-mêmes
        }
    
        // Enrichissement au premier degré du dictionnaire avec les synonymes des tags
        foreach ($CORPUS_TAG as $tagCourant) // Pour chaque tag
        {
            // Synonymes
            $listeSynTagCourant = synAvecAPI(strtolower(tradMotFrToAng($tagCourant)))/* ['synonyms'] */; // On exploite l'API pour récupérer les synonymes du tagCourant
            
            foreach($listeSynTagCourant as $synTagCrt) // Pour chaque synonyme du tagCourant
            {
                $synTagCourant = strtolower(tradMotAngToFr($synTagCrt));
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

            // Gen
            $listeGenTagCourant = genAvecAPI(strtolower(tradMotFrToAng($tagCourant)))/* ['synonyms'] */; // On exploite l'API pour récupérer les synonymes du tagCourant
            
            foreach($listeGenTagCourant as $genTagCrt) // Pour chaque synonyme du tagCourant
            {
                $genTagCourant = strtolower(tradMotAngToFr($genTagCrt));
                if(array_key_exists($genTagCourant,$dicoSynTag)){ // Si le synonyme est déjà présent comme clé
                    if(!(in_array(strtolower($tagCourant),$dicoSynTag[$genTagCourant]))){ // Si le tag est pas déjà dans la liste
                        array_push($dicoSynTag[$genTagCourant],strtolower($tagCourant)); // On l'ajoute
                    }
                }
                else // Sinon le synonyme est pas encore présent comme clé
                {
                    $dicoSynTag[$genTagCourant] = array(strtolower($tagCourant)); // Donc on l'ajoute associé à son tag
                }
            }

            // Trg
            $listeTrgTagCourant = trgAvecAPI(strtolower(tradMotFrToAng($tagCourant)))/* ['synonyms'] */; // On exploite l'API pour récupérer les synonymes du tagCourant
            
            foreach($listeTrgTagCourant as $trgTagCrt) // Pour chaque synonyme du tagCourant
            {
                $trgTagCourant = strtolower(tradMotAngToFr($trgTagCrt));
                if(array_key_exists($trgTagCourant,$dicoSynTag)){ // Si le synonyme est déjà présent comme clé
                    if(!(in_array(strtolower($tagCourant),$dicoSynTag[$trgTagCourant]))){ // Si le tag est pas déjà dans la liste
                        array_push($dicoSynTag[$trgTagCourant],strtolower($tagCourant)); // On l'ajoute
                    }
                }
                else // Sinon le synonyme est pas encore présent comme clé
                {
                    $dicoSynTag[$trgTagCourant] = array(strtolower($tagCourant)); // Donc on l'ajoute associé à son tag
                }
            }
        }

        echo "encodage<br>";
        file_put_contents('../data/dicoSynTag.json',json_encode($dicoSynTag,JSON_PRETTY_PRINT));
        echo "encodage terminé<br><br>";

        return $dicoSynTag;
    }

    $CORPUS_TAG = ["Tournoi", "Gastronomie", "Ambiance", "Bingo", "Atelier", "Film", "Formation", "Cinema", "musique", "Solidarite", "Detente", "Festival", "Loisir", 'Tennis', 'Finance', 'Charite', 'Jeu de Plateau', 'Chant', 'Paysages', 'jeux', 'Degustation', 'Concert', 'Banquet', 'Blues', 'Musique', 'Rencontre', 'Futsal', 'Pays Basque', 'Football', 'Marche', 'Amusement', 'Course', 'Investissement', 'Seniors', 'Balade', 'Pratique', 'Oenologie', 'Competition', 'culture', 'Jeu de Societe', 'voyage', 'Decouverte', 'Exposition', 'Loto', 'Amical', 'Cuisine', 'Musee', 'Terroir', 'Plein Air', 'Charcuterie', 'Vin', 'Cafe', 'Match', 'Buvette', 'Divertissement', 'Diner', 'Creation', 'Italie', 'Association', 'Randonnee', 'Echange', 'Partage', 'Discussion', 'Jazz', 'Aperitif', 'Omelette', 'Lecture', 'Jeu de societe', 'Activite physique', 'Fete', 'lecture', 'Entrainement', 'Hunger Games', 'Economie', 'Montagne', 'Convivialite', 'Caritatif', 'Viande', 'Festin', 'sport', 'Raquette', 'Culture', 'Plaisir', 'festival', 'Argent', 'Livre', 'Sport', 'jeu de cartes', 'Conference', 'Repas', 'Renforcement musculaire', 'Aventure', 'Nature', 'Soiree'];

    creaDicoSynTag($CORPUS_TAG);
?>