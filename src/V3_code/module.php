<?php

// Fonction tradMotAngToFr
function tradMotAngToFr($motATrad){
    //$res = https://translate.google.fr/?sl=en&tl=fr&text=mother%0A&op=translate;

    $api_url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=fr&dt=t&q=" . urlencode($motATrad);

    $resApi = file_get_contents($api_url);

    // Le résultat est un JSON, alors nous le décodons
    $res = json_decode($resApi, true);

    // La traduction se trouve dans la première position du tableau
    return $res[0][0][0];
}

// Fonction tradMotFrToAng
function tradMotFrToAng($motATrad){
    //$res = https://translate.google.fr/?sl=en&tl=fr&text=mother%0A&op=translate;

    $api_url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=fr&tl=en&dt=t&q=" . urlencode($motATrad);

    $resApi = file_get_contents($api_url);

    // Le résultat est un JSON, alors nous le décodons
    $res = json_decode($resApi, true);

    // La traduction se trouve dans la première position du tableau
    return $res[0][0][0];
}

// Fonction synAvecAPI
function synAvecAPI($mot){
    // Version avec DataMuse
    $api_url = "https://api.datamuse.com/words?rel_syn=" . urlencode($mot);

    $resApi = file_get_contents($api_url);

    // Le résultat est un JSON, alors nous le décodons
    $res = json_decode($resApi, true);

    // Extrayez les synonymes du tableau associatif
    $synonymes = array_column($res, 'word');

    return $synonymes;
}

// Fonction trgAvecAPI
function trgAvecAPI($mot){
    // Version avec DataMuse
    $api_url = "https://api.datamuse.com/words?rel_trg=" . urlencode($mot);

    $resApi = file_get_contents($api_url);

    // Le résultat est un JSON, alors nous le décodons
    $res = json_decode($resApi, true);

    // Extrayez les synonymes du tableau associatif
    $trg = array_column($res, 'word');

    return $trg;
}

// Fonction genAvecAPI
function genAvecAPI($mot){
    // Version avec DataMuse
    $api_url = "https://api.datamuse.com/words?rel_gen=" . urlencode($mot);

    $resApi = file_get_contents($api_url);

    // Le résultat est un JSON, alors nous le décodons
    $res = json_decode($resApi, true);

    // Extrayez les synonymes du tableau associatif
    $gen = array_column($res, 'word');

    return $gen;
}

?>