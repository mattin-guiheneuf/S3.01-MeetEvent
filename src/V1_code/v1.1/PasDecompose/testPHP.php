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
    private $mesMots = array();
    private $desTags = array();
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
    public function creerListeSuggest($user, $eventsAndUserPreferences, $objetEvenement) {
        return ACM($user, $eventsAndUserPreferences, $objetEvenement);
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

    //METHODES USUELLES
    public function toString($message) {
        $resultat = $message;
        $resultat .= "L'utilisateur " . $this->getId() . " a pour tag : ";

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
    private $pourcentage = 0.00;
    private $suggestion = array();

    // METHODES
    public function calculerPourcentage() {
        // Implémentez la logique du calcul du pourcentage ici
    }

    // GETTER ET SETTER
    public function getPourcentage() {
        return $this->pourcentage;
    }

    public function setPourcentage($pourcentage) {
        $this->pourcentage = $pourcentage;
    }
}

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

$objetEvenement = [];
foreach ($donnees['evenements'] as $element) {
    $objetEvenement[] = new Evenement($element['id'], $element['tags']);
}

// Transformation de tous les evenements
foreach ($objetEvenement as $event) {
    $eventsB = [];
    $objetEvenementElement = $event->getTags();

    foreach ($corpusTag as $corpusTagElement) {
        $eventsB[] = (int) in_array($corpusTagElement, $objetEvenementElement);
    }

    $eventsAndUserPreferences[] = $eventsB;
}

//-------------------------------------------------------------//
//                     Partie Utilisateur                      //
//-------------------------------------------------------------//

$dicoUser = [];
foreach ($donnees['utilisateurs'] as $element) {
    $dicoUser[$element['id']] = $element['tags'];
}

$idUserConnected = 1;
$userConnected = new Utilisateur($idUserConnected, $dicoUser[$idUserConnected]);

$user = [];
foreach ($corpusTag as $tagElement) {
    $user[] = (int) in_array($tagElement, $userConnected->getTags());
}

$eventsAndUserPreferences[] = $user;

//____________________________________________________________________________________//
//____________________________________________________________________________________//
//                                                                                    //
//                             TRAITEMENTS -- ACM                                     //
//                                                                                    //
//____________________________________________________________________________________//
//____________________________________________________________________________________//

function dotProduct($vec1, $vec2) {
    $result = 0;
    $length = count($vec1);

    for ($i = 0; $i < $length; $i++) {
        $result += $vec1[$i] * $vec2[$i];
    }

    return $result;
}

function norm($vec) {
    return sqrt(array_reduce($vec, function ($acc, $val) {
        return $acc + $val * $val;
    }, 0));
}

function cosineSimilarity($vec1, $vec2) {
    $dot = dotProduct($vec1, $vec2);
    $normVec1 = norm($vec1);
    $normVec2 = norm($vec2);

    // Vérifier si les vecteurs ont une norme non nulle
    if ($normVec1 != 0 && $normVec2 != 0) {
        return number_format($dot / ($normVec1 * $normVec2), 2);
    } else {
        return 0; // Retourner 0 si l'une des normes est nulle
    }
}

function ACM($userConnected, $eventsAndUserPreferences, $objetEvenement) {
    $userPreferences = $eventsAndUserPreferences[count($eventsAndUserPreferences) - 1];
    $dicoEvents = ["user" => $userConnected, "events" => []];

    for ($i = 0; $i < count($eventsAndUserPreferences) - 1; $i++) {
        $event = $eventsAndUserPreferences[$i];
        $similarity = cosineSimilarity($userPreferences, $event);
        echo "Similarité entre l'événement {$objetEvenement[$i]->getId()} et l'utilisateur {$userConnected->getId()}: " . $similarity * 100 . PHP_EOL;
        $dicoEvents["events"][] = [$objetEvenement[$i]->getId(), $similarity];
    }

    afficherContenuDicoEvent($dicoEvents,$userConnected);
    return recupererEvenements($dicoEvents);
}

// Afficher les événements recommandés
$listEventaRecommander = $userConnected->creerListeSuggest($userConnected, $eventsAndUserPreferences, $objetEvenement);
echo "\nListe des événements à recommander:\n";
print_r($listEventaRecommander);

//____________________________________________________________________________________//
//____________________________________________________________________________________//
//                                                                                    //
//                       FONCTION DE VERIFICATION (EXTERNE)                           //
//                                                                                    //
//____________________________________________________________________________________//
//____________________________________________________________________________________//

function afficherContenuDicoEvent($dico,$user) {
    echo "\nContenu du dictionnaire:" . PHP_EOL;

    foreach ($dico as $key => $value) {
        if ($key === "events") {
            echo "Clé \"$key\":<br>";
            foreach ($value as $event) {
                echo "Événement: {$event[0]}, Similarité: {$event[1]}%". PHP_EOL;
            }
        } else {
            echo "Clé \"$key\": {$user->getId()}". PHP_EOL;
        }
    }
}

function recupererEvenements($dico) {
    $evenements = [];
    $evenementsFiltres = array_filter($dico["events"], function ($event) {
        return $event[1] >= 0.7;
    });

    if (count($evenementsFiltres) === 0) {
        usort($dico["events"], function ($a, $b) {
            return $b[1] - $a[1];
        });

        for ($i = 0; $i < 5 && $i < count($dico["events"]); $i++) {
            $evenements[] = $dico["events"][$i][0];
        }
    } else {
        foreach ($evenementsFiltres as $event) {
            $evenements[] = $event[0];
        }
    }

    return $evenements;
}
?>
