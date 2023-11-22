<?php

//____________________________________________________________________________________//
//____________________________________________________________________________________//
//                                                                                    //
//                                   IMPORTATION                                      //
//                                                                                    //
//____________________________________________________________________________________//
//____________________________________________________________________________________//


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

$corpusTag = ["musique", "voyage", "lecture", "sport", "nature", "photographie", "cinema", "jeux video", "art", "film", "festival", "competition", "exposition"];
$eventsAndUserPreferences = [];

//-------------------------------------------------------------//
//                      Partie Evenement                       //
//-------------------------------------------------------------//

//Recuperer tous les evenement des données et les affecter dans objetEvenement
$objetEvenement = [];
foreach ($donnees['evenements'] as $element) {
    $objetEvenement[] = new Evenement($element['id'], $element['tags']);
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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST["idUser"])) {
        $idUserConnected = $_POST["idUser"];
        echo "</br>ID de l'utilisateur saisi : " . $idUserConnected ."</br>";

        $action = isset($_POST['action']) ? $_POST['action'] : '';

        // Inclure votre logique pour chaque action ici

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

                //On créé l'utilisateur à ajouter en dernier
                $user = [];
                foreach ($corpusTag as $tagElement) {
                    $user[] = (int) in_array($tagElement, $userConnected->getTags());
                }
                //On ajoute l'utilisateur (avec valeurs binaires) à l'ensemble des évènements
                $eventsAndUserPreferences[] = $user;

                //Resultat Recommandation
                // Initialisation d'un objet Recommandation
                $recommandation = new Recommandation();
                // la recommandation et l'utilisateur
                $userConnected->linkToSuggest($recommandation);
                $recommandation->linkToUser($userConnected);
                $recommandation->calculerSuggestion($eventsAndUserPreferences,$objetEvenement);
                

                $listEventaRecommander = $userConnected->creerListeSuggest();
                echo PHP_EOL . "</br>Liste des événements à recommander:</br>" . PHP_EOL;
                print_r($listEventaRecommander);
                break;

            default:
                // Action non reconnue
                break;
        }
       
    } else {
        echo "ID de l'utilisateur non spécifié dans le formulaire.";
    }
    
}

?>
