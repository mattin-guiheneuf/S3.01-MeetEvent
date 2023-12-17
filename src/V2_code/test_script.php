<?php

/**
 * Nom du fichier : test_script.php
 * Description : Test de l'algorithme et affichages pour vérification
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

//On récupére les classes Evenement, Utilisateur, Recommandation, Tag et Mot 
require_once 'CLASSs.php';

// Lire le contenu JSON depuis le fichier
$contenuJSON = file_get_contents('donnees.json');
$donnees = json_decode($contenuJSON, true);

//____________________________________________________________________________________//
//____________________________________________________________________________________//
//                                                                                    //
//                                 INITIALISATION                                     //
//                                                                                    //
//____________________________________________________________________________________//
//____________________________________________________________________________________//

//Corpus de TAGs prédéfinis
$corpusTag = ['Tournoi', 'Gastronomie', 'Ambiance', 'Bingo', 'Atelier', 'Film', 'Formation', 'Cinema', 'musique', 'Solidarite', 'Detente', 'Festival', 'Loisir', 'Tennis', 'Finance', 'Charite', 'Jeu de Plateau', 'Chant', 'Paysages', 'jeux', 'Degustation', 'Concert', 'Banquet', 'Blues', 'Musique', 'Rencontre', 'Futsal', 'Pays Basque', 'Football', 'Marche', 'Amusement', 'Course', 'Investissement', 'Seniors', 'Balade', 'Pratique', 'Oenologie', 'Competition', 'culture', 'Jeu de Societe', 'voyage', 'Decouverte', 'Exposition', 'Loto', 'Amical', 'Cuisine', 'Musee', 'Terroir', 'Plein Air', 'Charcuterie', 'Vin', 'Cafe', 'Match', 'Buvette', 'Divertissement', 'Diner', 'Creation', 'Italie', 'Association', 'Randonnee', 'Echange', 'Partage', 'Discussion', 'Jazz', 'Aperitif', 'Omelette', 'Lecture', 'Jeu de societe', 'Activite physique', 'Fete', 'lecture', 'Entrainement', 'Hunger Games', 'Economie', 'Montagne', 'Convivialite', 'Caritatif', 'Viande', 'Festin', 'sport', 'Raquette', 'Culture', 'Plaisir', 'festival', 'Argent', 'Livre', 'Sport', 'jeu de cartes', 'Conference', 'Repas', 'Renforcement musculaire', 'Aventure', 'Nature', 'Soiree'];
//Liste utilisé pour l'ACM
$eventsAndUserPreferences = [];

//affichage du corpus de tag
echo "/////////////////////////////" . "</br>" . "/// Corpus de Tag ///" . "</br>" . "/////////////////////////////" . "</br>";
foreach ($corpusTag as $key => $tag) {
    echo $tag . " ";
}
echo "</br>";
//-------------------------------------------------------------//
//                      Partie Evenement                       //
//-------------------------------------------------------------//

//Recuperer tous les evenement des données et les affecter dans objetEvenement
$objetEvenement = [];
//Affichage des événement et de leur tag
echo "</br>" . "///////////////////////////////////////////" . "</br>" . "/// Evenement et leurs Tags ///" . "</br>" . "///////////////////////////////////////////" . "</br>";
$n = 0;
foreach ($donnees['evenements'] as $element) {
    $objetEvenement[] = new Evenement($element['id'], $element['tags']);
    //Afficher tous les événements avec leur tags pour la vérification
    echo $objetEvenement[$n]->toString("") . "</br>";
    $n++;
}

// Transformation de tous les evenements
//On parcours tous les evenements existant
foreach ($objetEvenement as $event) {
    $eventsB = [];  //Liste pour UN evenement
    //Pour tous les tags de L'evenement
    $objetEvenementElement = $event->getTags();

    //On regarde si ils sont present dans le corpus tag et on y attribut un 1 sinon 0
    foreach ($corpusTag as $corpusTagElement) {
        $eventsB[] = (int) in_array($corpusTagElement, $objetEvenementElement);
    }
    //On ajoute l'evenement (avec valeurs binaires) à l'ensemble des évènements
    $eventsAndUserPreferences[] = $eventsB;
}

//____________________________________________________________________________________//
//____________________________________________________________________________________//
//                                                                                    //
//                                     TRAITEMENT                                     //
//                                                                                    //
//____________________________________________________________________________________//
//____________________________________________________________________________________//

//Récupérer la liste de tous les utilisateurs pour vérifier si celui saisi existe
$listeIdUtilisateur = [];
foreach($donnees['utilisateurs'] as $user){
    $listeIdUtilisateur[] = $user['id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST["idUser"]) && in_array($_POST["idUser"],$listeIdUtilisateur)) {
        $idUserConnected = $_POST["idUser"];
        //Affichage de l'utilisateur saisi et ses Tags
        echo "</br>" . "////////////////////////////////////////" . "</br>" . "/// Utilisateur et ses Tags ///" . "</br>" . "///////////////////////////////////////" . "</br>";
        echo "ID de l'utilisateur saisi : " . $idUserConnected . "</br>";

        $action = isset($_POST['action']) ? $_POST['action'] : '';

        // Inclure la logique pour chaque action
        switch ($action) {
            case 'creerUtilisateur':
                // Logique pour créer un utilisateur
                // Exécutez la méthode ajoutUtilisateur de votre fichier ajoutDonnee.js
                echo '<script>ajoutUtilisateur();</script>';
                break;

            case 'creerEvenement':
                // Logique pour créer un événement
                break;

            case 'afficherRecommandations':
                // Logique pour afficher les événements recommandés
                // Afficher les événements recommandés

                //créer l'utilisateur connecté
                $dicoUser = [];
                foreach ($donnees['utilisateurs'] as $element) {
                    $dicoUser[$element['id']] = $element['tags'];
                }

                $userConnected = new Utilisateur($idUserConnected, $dicoUser[$idUserConnected]);
                echo $userConnected->toString("") . "</br>" . "</br>";

                //On créé l'utilisateur à ajouter en dernier
                $user = [];
                foreach ($corpusTag as $tagElement) {
                    $user[] = (int) in_array($tagElement, $userConnected->getTags());
                }
                //On ajoute l'utilisateur (avec valeurs binaires) à l'ensemble des évènements
                $eventsAndUserPreferences[] = $user;



                // Affichage du tableau eventsAndUserPreferences
                afficherTabACM($corpusTag,$eventsAndUserPreferences,$objetEvenement,$userConnected);



                // Resultat Recommandation
                // Initialisation d'un objet Recommandation
                $recommandation = new Recommandation();
                // la recommandation et l'utilisateur
                $userConnected->linkToSuggest($recommandation);
                $recommandation->linkToUser($userConnected);
                //Affichage similarités
                echo "</br>" . "/////////////////////////////////////" . "</br>" . "/// Calcul de Similarité ///" . "</br>" . "////////////////////////////////////" . "</br>";
                //Calcul de la suggestion entre tous les événements et l'utilisateur
                $recommandation->calculerSuggestion($eventsAndUserPreferences, $objetEvenement);

                //Affichage suggestion
                echo "</br>" . "/////////////////////////" . "</br>" . "/// Suggestion ///" . "</br>" . "////////////////////////" . "</br>";
                //Création de la liste des événements à suggérer en fonction de l'utilisateur
                $listEventaRecommander = $userConnected->creerListeSuggest();
                echo "Liste des événements à recommander:</br>" . PHP_EOL;
                print_r($listEventaRecommander);
                break;

            default:
                // Action non reconnue
                break;
        }
    } else {
        echo "</br>ID de l'utilisateur inconnu.";
    }
}



/**
 * Affichage du tableau de l'ACM pour vérification avec tous les événements et l'utilisateur désignés
 * 
 * @param array $corpusTag liste des Tags
 * @param array $eventsAndUserPreferences Liste avec tous les evenements et l'utilisateur en dernier
 * @param array $objetEvenement Liste avec tous les evenements (objets Evenement)
 * @param Utilisateur $userConnected Utilisateur connecté
 * @return void tableau ACM
 */
function afficherTabACM(array $corpusTag,array $eventsAndUserPreferences,array $objetEvenement,Utilisateur $userConnected) {
    // Affichage des étiquettes pour les colonnes (tags)
    echo "</br>///////////////////////////////////////////////////////////</br>/// Tableau eventsAndUserPreferences ///</br>///////////////////////////////////////////////////////////</br>";
    echo "<table border='1' style='text-align:center;font-weight:bold;'>";
    echo "<tr><td></td>"; // Cellule vide pour l'angle supérieur gauche

    // Afficher les étiquettes des colonnes (tags)
    foreach ($corpusTag as $tag) {
        echo "<td style='padding:10px;'>$tag</td>";
    }
    //Afficher les étiquettes lignes et les valeurs binaire pour les événements
    for ($i=0; $i < count($eventsAndUserPreferences)-1; $i++) { 
        echo "<tr><td style='padding:10px;'>Evenement " . $objetEvenement[$i]->getId() . "</td>";
        foreach($eventsAndUserPreferences[$i] as $valeur){
            if($valeur == 0){
                echo "<td style='background-color:red;'>$valeur</td>";
            }else{
                echo "<td style='background-color:green'>$valeur</td>";
            }
        }
        echo "</tr>";
    }

    //Afficher l'utilisateur
    echo "<tr><td style='padding:10px;'>Utilisateur " . $userConnected->getId() . "</td>";
    foreach(end($eventsAndUserPreferences) as $valeur){
        if($valeur == 0){
            echo "<td style='background-color:red;'>$valeur</td>";
        }else{
            echo "<td style='background-color:green'>$valeur</td>";
        }
    }
    echo "</table>";
}

