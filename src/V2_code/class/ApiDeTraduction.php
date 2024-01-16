<?php
require_once "Synonyme.php";
/**
 * 
 */

class ApiDeTraduction{

    // METHODES
    public function utiliserApiTrad(Synonyme $motATrad){
        $api_url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=fr&dt=t&q=" . urlencode($motATrad->getLibelle()); // URL de l'API
        $resApi = file_get_contents($api_url); // Résultat de l'API
        // Le résultat est un JSON, alors on le décode
        $res = json_decode($resApi, true);
        // La traduction se trouve dans la première position du tableau
        return $res[0][0][0];
    } 
}

