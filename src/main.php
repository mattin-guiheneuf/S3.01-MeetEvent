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
require_once "./class/Synonyme.php";
require_once "./class/ApiDeTraduction.php";
require_once "./class/ApiDictionnaireFr.php";
require_once "./class/ApiSynonyme.php";
require_once "./class/Corpus.php";
require_once "./class/DicoSynTags.php";
require_once "./class/Evenement.php";
require_once "./class/Mot.php";
require_once "./class/Recommandation.php";
require_once "./class/Tag.php";
require_once "./class/Utilisateur.php";

// Lire le contenu JSON depuis le fichier
$contenuJSON = file_get_contents('./data/donnees.json');
$donnees = json_decode($contenuJSON, true);

//____________________________________________________________________________________//
//____________________________________________________________________________________//
//                                                                                    //
//                                 INITIALISATION                                     //
//                                                                                    //
//____________________________________________________________________________________//
//____________________________________________________________________________________//

//Transformer les tags en objet Tag
$liste = [
    "Cuisine", "Art",
    "Musique", "Dessin", "Sport", "Entraînement", "Social",
    "Discussion", "Méditation", "Détente", "Lecture", "Écoute","Rire",
    "Divertissement", "Fête", "Exploration", "Voyage", "Découverte", 
    "Enseignement", "Travail", "Créativité", "Construction",
    "Jardinage", "Photographie", "Film", "Danse", "Chant", 
    "Instrument", "Collection", "Informatique", "Réflexion",
    "Engagement", "Volontariat", "Organisation",
    "Exercice", "Expérience", "Test",
    "Développement", "Amélioration", "Innovation", "Économie",
    "Partage", "Influence", "Motivation",
    "Inspiration", "Amusement",
    "Célébration", "Changement",
    "Imagination", "Jeux", "Festival",
    "Culture", "Concert", "Repas", "Aperitif", "Alcool",
    "Association", "Rencontre",
    "Marche", "Amical",
    "Plaisir", "Jeu de société", "Animaux",
    "Soiree", "Nature", "Paysages", "Atelier", 
    "Gastronomie", "Dégustation", "Exposition", "Musee",
    "Dîner", "Caritatif", "Solidarité", "Loisir",
    "Competition", "Tournoi", "Montagne",
    "Finance", "Formation","Océan"];
foreach ($liste as $tag) {
    $list_tag_corpus[] = new Tag(strtolower($tag));
}
//Création du corpus de Tag
$corpusTag = new Corpus(1, $list_tag_corpus);

// Récupération du dicoSynTag
$jsonDicoSynTag = file_get_contents('./data/dicoSynTag.json');
$dicoSynTag = json_decode($jsonDicoSynTag, true);
// Sinon création du dicoSynTag
// include_once "creaDicoSynTag.php";
// $dicoSynTag = creaDicoSynTag($liste);

//Liste utilisé pour l'ACM
$eventsAndUserPreferences = [];

//affichage du corpus de tag
echo "/////////////////////////////" . "</br>" . "/// Corpus de Tag ///" . "</br>" . "/////////////////////////////" . "</br>";
foreach ($corpusTag->getMesTags() as $key => $tag) {
    echo $tag->getLibelle() . " ";
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
    foreach ($element['tags'] as $tag) {
        $list_tags[] = new Tag($tag);
    }
    $objetEvenement[] = new Evenement($element['id'], $list_tags);
    //Afficher tous les événements avec leur tags pour la vérification
    echo $objetEvenement[$n]->toString("") . "</br>";
    $n++;
    $list_tags = [];
}

// Transformation de tous les evenements
//On parcours tous les evenements existant
foreach ($objetEvenement as $event) {
    $eventsB = [];  //Liste pour UN evenement
    //Pour tous les tags de L'evenement
    $objetEvenementElement = $event->getTags();

    //On regarde si ils sont present dans le corpus tag et on y attribut un 1 sinon 0
    foreach ($corpusTag->getMesTags() as $corpusTagElement) {
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
foreach ($donnees['utilisateurs'] as $user) {
    $listeIdUtilisateur[] = $user['id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST["idUser"]) && in_array($_POST["idUser"], $listeIdUtilisateur)) {
        $idUserConnected = $_POST["idUser"];
        //Affichage de l'utilisateur saisi et ses Tags
        echo "</br>" . "////////////////////////////////////////" . "</br>" . "/// Utilisateur et ses Tags ///" . "</br>" . "///////////////////////////////////////" . "</br>";
        echo "ID de l'utilisateur saisi : " . $idUserConnected . "</br>";

        // Logique pour afficher les événements recommandés
        // Afficher les événements recommandés

        //Dico avec tous les utilisateurs et leurs tags associés
        $dicoUser = [];
        foreach ($donnees['utilisateurs'] as $element) {
            foreach ($element['tags'] as $tag) {
                $list_tag_user[] = new Tag($tag);
            }
            $dicoUser[$element['id']] = $list_tag_user;
            $list_tag_user = [];
        }

        //créer l'utilisateur connecté
        $userConnected = new Utilisateur($idUserConnected, $dicoUser[$idUserConnected]);
        echo $userConnected->toString("") . "</br>" . "</br>";

        //On créé l'utilisateur à ajouter en dernier
        $user = [];
        foreach ($corpusTag->getMesTags() as $tagElement) {
            $user[] = (int) in_array($tagElement, $userConnected->getTags());
        }
        //On ajoute l'utilisateur (avec valeurs binaires) à l'ensemble des évènements
        $eventsAndUserPreferences[] = $user;



        // Affichage du tableau eventsAndUserPreferences
        afficherTabACM($corpusTag, $eventsAndUserPreferences, $objetEvenement, $userConnected);



        // Resultat Recommandation
        // Initialisation d'un objet Recommandation
        $recommandation = new Recommandation($userConnected);
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

    } elseif (isset($_POST["action"])) {
        $action = $_POST['action'];
        // Inclure la logique pour chaque action
        switch ($action) {
            case 'creerUtilisateur':
                // Logique pour créer un utilisateur
                $nom = $_POST['nom'];
                $id_user = $donnees['utilisateurs'][count($donnees['utilisateurs']) - 1]['id'] + 1;
                $user_courrant = new Utilisateur($id_user,[]);
                
                // Récupère la liste de mots envoyée par le formulaire
                $motsListe = isset($_POST['motsListe']) ? json_decode($_POST['motsListe']) : [];

                //on crée ajout l'utilisateur dans la BD
                $user_courrant->setId($id_user);
                $user_courrant->setNom($nom);
                //Création liste de mot objet
                $listeMot_objet = array();
                foreach($motsListe as $motX){
                    $listeMot_objet[]= new Mot($motX);
                }
                //On attributs les mots de l'utilisateur
                $user_courrant->setMots($listeMot_objet);
                $user_courrant->definirDescription($dicoSynTag);
                break;

            case 'creerEvenement':
                // Logique pour créer un événement
                $titre = $_POST['titre'];
                $date = $_POST['date'];
                $heure = $_POST['heure'];
                $lieu = $_POST['lieu'];
                $id_event = $donnees['evenements'][count($donnees['evenements']) - 1]['id'] + 1;
                $event_courrant = new Evenement($id_event,[]);

                // Récupère la liste de mots envoyée par le formulaire
                $motsListe = isset($_POST['motsListeEvenement']) ? json_decode($_POST['motsListeEvenement']) : [];
                if ($motsListe===[]) {
                    echo "putain de merde ";
                }
                //on crée ajout l'utilisateur dans la BD
                $event_courrant->setId($id_event);
                $event_courrant->setTitre($titre);
                $event_courrant->setDate($date);
                $event_courrant->setHeure($heure);
                $event_courrant->setLieu($lieu);
                //Création liste de mot objet
                $listeMot_objet = array();
                foreach($motsListe as $motX){
                    $listeMot_objet[]= new Mot($motX);
                }
                $event_courrant->setMots($listeMot_objet);
                $event_courrant->definirDescription($dicoSynTag);
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
 * @param Corpus $corpusTag liste des Tags
 * @param array $eventsAndUserPreferences Liste avec tous les evenements et l'utilisateur en dernier
 * @param array $objetEvenement Liste avec tous les evenements (objets Evenement)
 * @param Utilisateur $userConnected Utilisateur connecté
 * @return void tableau ACM
 */
function afficherTabACM(Corpus $corpusTag, array $eventsAndUserPreferences, array $objetEvenement, Utilisateur $userConnected)
{
    // Affichage des étiquettes pour les colonnes (tags)
    echo "</br>///////////////////////////////////////////////////////////</br>/// Tableau eventsAndUserPreferences ///</br>///////////////////////////////////////////////////////////</br>";
    echo "<table border='1' style='text-align:center;font-weight:bold;'>";
    echo "<tr><td></td>"; // Cellule vide pour l'angle supérieur gauche

    // Afficher les étiquettes des colonnes (tags)
    foreach ($corpusTag->getMesTags() as $tag) {
        echo "<td style='padding:10px;'>" . $tag->getLibelle() . "</td>";
    }
    //Afficher les étiquettes lignes et les valeurs binaire pour les événements
    for ($i = 0; $i < count($eventsAndUserPreferences) - 1; $i++) {
        echo "<tr><td style='padding:10px;'>Evenement " . $objetEvenement[$i]->getId() . "</td>";
        foreach ($eventsAndUserPreferences[$i] as $valeur) {
            if ($valeur == 0) {
                echo "<td style='background-color:red;'>$valeur</td>";
            } else {
                echo "<td style='background-color:green'>$valeur</td>";
            }
        }
        echo "</tr>";
    }

    //Afficher l'utilisateur
    echo "<tr><td style='padding:10px;'>Utilisateur " . $userConnected->getId() . "</td>";
    foreach (end($eventsAndUserPreferences) as $valeur) {
        if ($valeur == 0) {
            echo "<td style='background-color:red;'>$valeur</td>";
        } else {
            echo "<td style='background-color:green'>$valeur</td>";
        }
    }
    echo "</table>";
}
