<?php
require_once "Synonyme.php";
/**
 * 
 */

class ApiDeTraduction{

    // METHODES
    public function utiliserApiTrad(Mot $motATrad, String $langue1, String $langue2){
        $api_url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=".$langue1."&tl=".$langue2."&dt=t&q=" . urlencode($motATrad->getLibelle()); // URL de l'API
        $resApi = file_get_contents($api_url); // Résultat de l'API
        // Le résultat est un JSON, alors on le décode
        $res = json_decode($resApi, true);
        // La traduction se trouve dans la première position du tableau
        return $res[0][0][0];
    } 
}

