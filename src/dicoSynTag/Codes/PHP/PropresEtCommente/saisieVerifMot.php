<?php

// Encodage du csv en json
/* echo 'Lancemebnt encodage motsFrTries<br>';
$fic="motsFrTries.csv";
$ficCsv= file_get_contents($fic);
$array = array_map("str_getcsv", explode("\n", $ficCsv));
$motsFr = array();
// Extraction des données
foreach ($array as $index => $mot) {
    foreach($mot as $motCourant) {
        array_push($motsFr,$motCourant);
    }
}
echo "encodage<br>";
file_put_contents('motsFr.json',json_encode($motsFr ,JSON_PRETTY_PRINT));
echo "encodage terminé<br><br>"; */

// Fonction de vérification d'appartenance d'elts d'une lise à une autre liste
// Pas nécessaire si un seul mot saisie à chaque fois (un par un quoi)
/* function checkAppartenance($listeMots, $listeACheck) {
    $res = array();
    foreach ($listeMots as $mot) {
        if (in_array($mot, $listeACheck)) {
            $res[$mot] = 1; // True
        } else {
            $res[$mot] = 0; // False
        }
    }
    return $res;
} */

// Fonction de saisieVerif
$listeMotFr = json_decode(file_get_contents('./motsFr.json'), true); // récupération liste mots français

function saisieVerif() {
    global $listeMotFr; // Récupération de la variable
    $saisie = $_GET['listeMotsSaisies']; // Récupération des mots saisies
    // Pas nécessaires si un seul mot saisie à chaque fois (un par un quoi)
    /* if (strpos($saisie, ',') !== false) {
        $listeMot = explode(',', $saisie);
        foreach ($listeMot as &$mot) {
            $mot = trim($mot);
        }
        unset($mot);
        
        while (($key = array_search('', $listeMot)) !== false) {
            unset($listeMot[$key]);
        }
        $res = checkAppartenance($listeMot, $listeMotFr);
    } elseif (strpos($saisie, ';') !== false) {
        $listeMot = explode(';', $saisie);
        foreach ($listeMot as &$mot) {
            $mot = trim($mot);
        }
        unset($mot);
        
        while (($key = array_search('', $listeMot)) !== false) {
            unset($listeMot[$key]);
        }
        $res = checkAppartenance($listeMot, $listeMotFr);
    } else {
        $listeMot = explode(' ', $saisie);
        foreach ($listeMot as &$mot) {
            $mot = trim($mot);
        }
        unset($mot);
        
        while (($key = array_search('', $listeMot)) !== false) {
            unset($listeMot[$key]);
        }
        $listeMot = array_values($listeMot);
        
        $res = array();
        $passer = 0; // False
        for ($i = 0; $i < count($listeMot) - 1; $i++) {
            if ($passer) {
                $passer = 0; // False
                continue;
            } else {
                if (in_array($listeMot[$i] . " " . $listeMot[$i + 1], $listeMotFr)) {
                    $res[$listeMot[$i] . " " . $listeMot[$i + 1]] = 1; // true
                    $passer = 1; // True
                } elseif (in_array($listeMot[$i], $listeMotFr)) {
                    $res[$listeMot[$i]] = 1; // True
                } else {
                    $res[$listeMot[$i]] = 0; // False
                }
            }
        }
        if (in_array($listeMot[count($listeMot) - 1], $listeMotFr)) {
            $res[$listeMot[count($listeMot) - 1]] = 1; // True
        } else {
            $res[$listeMot[count($listeMot) - 1]] = 0; // False
        }
    }
    print_r($listeMot);
    echo '<br><br>';
    print_r($res); */

    // On regarde si le mot est présent dans les mots du dico français
    $res = in_array(trim($saisie),$listeMotFr); // La fonction trim permet d'enlever les espaces en début et fin de chaîne

    // On renvoie le résultat
    return $res;
}

if (isset($_GET['listeMotsSaisies'])) {
    saisieVerif();
}
else {
    echo '<form action="./saisieVerifMot.php" method="get">
    Veuillez saisir un mot ou une liste de mot qui vous caractérise :  <input type="text" name="listeMotsSaisies"><br>
<input type="submit">
</form>';
}




?>