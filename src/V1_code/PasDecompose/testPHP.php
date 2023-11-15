<?php

// Lire le contenu JSON depuis le fichier
$contenuJSON = file_get_contents('donnees.json');
$donnees = json_decode($contenuJSON, true);

// Classes

class Evenement {
    private $id;
    private $tags;

    public function __construct($id, $tags) {
        $this->id = $id;
        $this->tags = $tags;
    }

    public function getId() {
        return $this->id;
    }

    public function getTags() {
        return $this->tags;
    }

    // Ajoutez d'autres méthodes au besoin
}

class Utilisateur {
    private $id;
    private $tags;

    public function __construct($id, $tags) {
        $this->id = $id;
        $this->tags = $tags;
    }

    public function getId() {
        return $this->id;
    }

    public function getTags() {
        return $this->tags;
    }

    // Ajoutez d'autres méthodes au besoin
}

// Initialisation

$corpusTag = ["musique", "voyage", "lecture", "sport", "nature", "photographie", "cinema", "jeux video", "art", "film", "festival", "competition", "exposition"];
$eventsAndUserPreferences = [];

// Partie Evenement

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

// Partie Utilisateur

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

// Traitements ACM

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
        echo "Similarité entre l'événement {$objetEvenement[$i]->getId()} et l'utilisateur {$userConnected->getId()}: " . $similarity * 100 . "%<br>";
        $dicoEvents["events"][] = [$objetEvenement[$i]->getId(), $similarity];
    }

    afficherContenuDicoEvent($userConnected,$dicoEvents);
    return recupererEvenements($dicoEvents);
}

// Afficher les événements recommandés
$listEventaRecommander = ACM($userConnected, $eventsAndUserPreferences, $objetEvenement);
echo "\nListe des événements à recommander:\n";
print_r($listEventaRecommander);

// Autres fonctions à adapter au besoin

function afficherContenuDicoEvent($dico) {
    echo "<br>Contenu du dictionnaire:<br>";

    foreach ($dico as $key => $value) {
        if ($key === "events") {
            echo "Clé \"$key\":<br>";
            foreach ($value as $event) {
                echo "  Événement: {$event[0]}, Similarité: {$event[1]}%<br>";
            }
        } else {
            echo "Clé \"$key\": {$userConnected->getId()}<br>";
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
