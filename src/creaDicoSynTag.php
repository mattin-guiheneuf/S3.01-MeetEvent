<!-- SAE -->
<?php

/**
 * @file creaDicoSynTag.php
 * @author Yannis Duvignau
 * @brief Fichier contenant la fonction creaDicoSynTag
 * @details Contient la focntion qui permet de créer le dictionnaire des synonyme de tags
 * @version 1.0
 */


    // Récupératiob de l'API
    include_once "module.php";

    /**
     * @brief Créer le dictionnaire des synonyme de Tags
     * @param Tag[]
     * @return array
     */
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
            /* // Synonymes
            $listeSynTagCourant = synAvecAPI(strtolower(tradMotFrToAng($tagCourant))); // On exploite l'API pour récupérer les synonymes du tagCourant
            
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
            } */

            // Mots liés
            $listeTrgTagCourant = trgAvecAPI(strtolower(tradMotFrToAng($tagCourant))); // On exploite l'API pour récupérer les synonymes du tagCourant
            
            foreach($listeTrgTagCourant as $trgTagCrt) // Pour chaque synonyme du tagCourant
            {
                $trgTagCourant = strtolower(tradMotAngToFr($trgTagCrt));
                if(array_key_exists($trgTagCourant,$dicoSynTag)){ // Si le synonyme est déjà présent comme clé
                    if(!(in_array(strtolower($tagCourant),$dicoSynTag[$trgTagCourant]))){ // Si le tag est pas déjà dans la liste
                        array_push($dicoSynTag[$trgTagCourant],strtolower($tagCourant)); // On l'ajoute
                    }
                }
                else // Sinon le triggered est pas encore présent comme clé
                {
                    $dicoSynTag[$trgTagCourant] = array(strtolower($tagCourant)); // Donc on l'ajoute associé à son tag
                }
            }

            /* // Mots génériques
            $listeGenTagCourant = genAvecAPI(strtolower(tradMotFrToAng($tagCourant))); // On exploite l'API pour récupérer les synonymes du tagCourant
            
            foreach($listeGenTagCourant as $genTagCrt) // Pour chaque synonyme du tagCourant
            {
                $genTagCourant = strtolower(tradMotAngToFr($genTagCrt));
                if(array_key_exists($genTagCourant,$dicoSynTag)){ // Si le synonyme est déjà présent comme clé
                    if(!(in_array(strtolower($tagCourant),$dicoSynTag[$genTagCourant]))){ // Si le tag est pas déjà dans la liste
                        array_push($dicoSynTag[$genTagCourant],strtolower($tagCourant)); // On l'ajoute
                    }
                }
                else // Sinon le générique est pas encore présent comme clé
                {
                    $dicoSynTag[$genTagCourant] = array(strtolower($tagCourant)); // Donc on l'ajoute associé à son tag
                }
            } */
        }

        echo "encodage<br>";
        file_put_contents('./data/dicoSynTagTrg.json',json_encode($dicoSynTag,JSON_PRETTY_PRINT));
        echo "encodage terminé<br><br>";

        return $dicoSynTag;
    }

    // Corpus plus court pour les tests
    $CORPUS_TAG_Test = ["Tournoi", "Gastronomie", "Ambiance", "Bingo", "Atelier", "Film", "Formation", "Cinema", "musique", "Solidarite", "Detente", "Festival", "Loisir", 'Tennis', 'Finance', 'Charite', 'Jeu de Plateau', 'Chant', 'Paysages', 'jeux', 'Degustation', 'Concert', 'Banquet', 'Blues', 'Musique', 'Rencontre', 'Futsal', 'Pays Basque', 'Football', 'Marche', 'Amusement', 'Course', 'Investissement', 'Seniors', 'Balade', 'Pratique', 'Oenologie', 'Competition', 'culture', 'Jeu de Societe', 'voyage', 'Decouverte', 'Exposition', 'Loto', 'Amical', 'Cuisine', 'Musee', 'Terroir', 'Plein Air', 'Charcuterie', 'Vin', 'Cafe', 'Match', 'Buvette', 'Divertissement', 'Diner', 'Creation', 'Italie', 'Association', 'Randonnee', 'Echange', 'Partage', 'Discussion', 'Jazz', 'Aperitif', 'Omelette', 'Lecture', 'Jeu de societe', 'Activite physique', 'Fete', 'lecture', 'Entrainement', 'Hunger Games', 'Economie', 'Montagne', 'Convivialite', 'Caritatif', 'Viande', 'Festin', 'sport', 'Raquette', 'Culture', 'Plaisir', 'festival', 'Argent', 'Livre', 'Sport', 'jeu de cartes', 'Conference', 'Repas', 'Renforcement musculaire', 'Aventure', 'Nature', 'Soiree'];

    // Vrai cropus de tags
    $CORPUS_TAG = [
        "Cuisine", "Ingrédients", "Art",
        "Musique", "Dessin", "Sport", "Entraînement", "Social", "Échange",
        "Discussion", "Méditation", "Détente", "Lecture", "Écoute","Rire",
        "Divertissement", "Fête", "Exploration", "Voyage", "Découverte", 
        "Enseignement", "Travail", "Créativité", "Construction",
        "Réparation", "Jardinage", "Photographie", "Film", "Danse", "Chant", 
        "Instrument", "Collection", "Informatique", "Réflexion",
        "Engagement", "Volontariat", "Organisation",
        "Événement", "Défense", "Exercice", "Expérience", "Test",
        "Développement", "Amélioration", "Innovation", "Économie",
        "Investissement", "Gestion", "Partage", "Influence", "Motivation",
        "Inspiration", "Amusement",
        "Célébration", "Changement",
        "Imagination", "Jeux", "Festival",
        "Culture", "Concert", "Repas", "Aperitif", "Alcool",
        "Association", "Cafe", "Rencontre",
        "Marche", "Amical",
        "Plaisir", "Jeu de société", "Animaux",
        "Soiree", "Nature", "Paysages", "Atelier", 
        "Gastronomie", "Oenologie", "Dégustation", "Exposition", "Musee",
        "Dîner", "Caritatif", "Solidarité", "Raquette", "Loisir",
        "Competition", "Tournoi", "Peinture", "Montagne",
        "Finance", "Formation", "Nourriture"
    ];

    //creaDicoSynTag($CORPUS_TAG);

    // Pour optimiser et faciliter la création du dictionnaire, on effectue chaque étape (synonymes, mots liés et mots génériques) séparément (commenter chaque partie dans le code, etc)
    // Nécéssité de modifier le fichier de destination à chaque fois pour ne pas écraser les données (directement dans le code ou mettre en paramètre)
    // Il faut donc fusionner les corpus
    function fusionnerCorpus($corpus1,$corpus2){
        $jsonCorpus1 = file_get_contents('./data/'.$corpus1.'.json');
        $Corpus1 = json_decode($jsonCorpus1, true);
        $jsonCorpus2 = file_get_contents('./data/'.$corpus2.'.json');
        $Corpus2 = json_decode($jsonCorpus2, true);
        return array_unique(array_merge($Corpus1,$Corpus2),SORT_REGULAR);
    }

    // La partie trg étant la plus longue, l'erreur 504 nous empçeche d'exécuter donc soit faire sous python soit diviser le corpus en trois
    // À mettre dans dicoSynTagTrg1.json
    $cTTrg1 = [
        "Cuisine", "Saveur", "Recette", "Ingrédients", "Art", "Création",
        "Musique", "Dessin", "Sport", "Entraînement", "Socialisation", "Échange",
        "Discussion", "Méditation", "Détente", "Lecture", "Écoute","Rire",
        "Divertissement", "Fête", "Exploration", "Voyage", "Découverte", 
        "Apprentissage", "Enseignement", "Travail", "Créativité", "Construction",
        "Réparation", "Jardinage", "Photographie", "Film", "Danse", "Chant", 
        "Instrument", "Collection", "Analyse", "Réflexion",
        "Résolution", "Engagement", "Volontariat", "Organisation"
    ];

    // À mettre dans dicoSynTagTrg2.json
    $cTTrg2 = [
        "Événement", "Défense", "Exercice", "Expérience", "Test",
        "Développement", "Amélioration", "Innovation", "Économie",
        "Investissement", "Gestion", "Partage", "Influence", "Motivation",
        "Inspiration", "Amusement", "Détente", "Profiter",
        "Célébration", "Changement", "Réflexion", "Créativité",
        "Imagination", "Réflexion", "Exploration", "Jeux", "Festival",
        "Culture", "Concert", "Repas", "Aperitif", "Vin", "Banquet",
        "Association", "Cafe", "Rencontre", "Renforcement musculaire",
        "Activite physique", "Course", "Entrainement", "Randonnee"
    ];

    // À mettre dans dicoSynTagTrg3.json
    $cTTrg3 = [
        "Marche", "Balade", "Football", "Amical",
        "Plaisir", "Jeu de societe", "Convivialite",
        "Jeu de cartes", "Jeu de Plateau", "Equitation",
        "Soiree", "Nature", "Paysages", "Atelier", 
        "Gastronomie", "Oenologie", "Degustation", "Exposition", "Musee",
        "Diner", "Caritatif", "Solidarite", "Fete", "Handball",
        "Buvette", "Tennis", "Raquette", "Loisir", "Golf", "Judo",
        "Competition", "Tournoi", "Peinture", "Cinema", "Montagne",
        "Finance", "Formation", "Nourriture", "Basket", "Rugby", "Natation"
    ];

    //creaDicoSynTag($cTTrgX);

    // Fonction pour fusionner correctement
    function fusionnerBienCorpus($c1,$c2){
        // Récupération des données
        $jsonCorpus1 = file_get_contents('./data/'.$c1.'.json');
        $Corpus1 = json_decode($jsonCorpus1);
        $jsonCorpus2 = file_get_contents('./data/'.$c2.'.json');
        $Corpus2 = json_decode($jsonCorpus2);

        $res = array();

        // Parcours et traitements
        // Premier corpus
        foreach ($Corpus1 as $syn => $listeTag) { // Pour chaque enregistrement (ligne) du json
            if (!(array_key_exists($syn,$res))) { // Si le synonyme n'est pas déjà dans le résultat
                $res += array($syn=>$listeTag); // On l'ajoute
            }
            else { // Sinon
                foreach ($listeTag as $tag) { // Pour chaque de la liste de tag associé au synonyme
                    if(!(in_array($tag,$res[$syn]))){ // Si le tag n'est pas déjà associé au synonyme
                        array_push($res[$syn],$tag); // On l'ajoute au tag associé à ce synonyme
                    }
                    // Sinon rien
                }
            }
        }

        // Second corpus
        foreach ($Corpus2 as $syn => $listeTag) { // Pour chaque enregistrement (ligne) du json
            if (!(array_key_exists($syn,$res))) { // Si le synonyme n'est pas déjà dans le résultat
                $res += array($syn=>$listeTag); // On l'ajoute
            }
            else { // Sinon
                foreach ($listeTag as $tag) { // Pour chaque de la liste de tag associé au synonyme
                    if(!(in_array($tag,$res[$syn]))){ // Si le tag n'est pas déjà associé au synonyme
                        array_push($res[$syn],$tag); // On l'ajoute au tag associé à ce synonyme
                    }
                    // Sinon rien
                }
            }
        }

        return $res;
    }

    // Fusionner pour obtenir dicoSynTagTrg (sur l'entièreté du corpus fonctionne quand-même mais provoque erreur 504)
    //file_put_contents('./data/dicoSynTagTrgTmp.json',json_encode(fusionnerBienCorpus('dicoSynTagTrg2','dicoSynTagTrg3'),JSON_PRETTY_PRINT));
    //file_put_contents('./data/dicoSynTagTrgTest.json',json_encode(fusionnerBienCorpus('dicoSynTagTrg1','dicoSynTagTrgTmp'),JSON_PRETTY_PRINT));

    // Pour tout fusionner
    //file_put_contents('./data/dicoSynTagTmp2.json',json_encode(fusionnerBienCorpus('dicoSynTagSyn','dicoSynTagTrg'),JSON_PRETTY_PRINT));
    //file_put_contents('./data/dicoSynTag.json',json_encode(fusionnerBienCorpus('dicoSynTagGen','dicoSynTagTmp2'),JSON_PRETTY_PRINT));
?>