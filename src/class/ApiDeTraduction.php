<?php
require_once "Synonyme.php";
/**
 * @file apiDeTraduction.php
 * @author Yannis Duvignau
 * @brief Fichier contenant la classe apiDeTraduction
 * @details Contient la structure de la classe apiDeTraduction
 * @version 1.0
 */

 /**
  * Classe apiDeTraduction qui permet d'utiliser notre API de traduction
  */

class ApiDeTraduction{
    /** Methode  */ 
    /**
     * @brief Traduit un mot de l'anglais à français en utilisant l'API de Google Translate
     * @param [in] Synonyme $motATrad Mot que l'on souhaite traduire
     * @return string
     */
    public function utiliserApiTrad(Mot $motATrad, String $langue1, String $langue2){
        $api_url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=".$langue1."&tl=".$langue2."&dt=t&q=" . urlencode($motATrad->getLibelle()); // URL de l'API
        $resApi = file_get_contents($api_url); // Résultat de l'API
        // Le résultat est un JSON, alors on le décode
        $res = json_decode($resApi, true);
        // La traduction se trouve dans la première position du tableau
        return $res[0][0][0];
    } 
}

