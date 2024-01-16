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
    public function utiliserApiTrad(Synonyme $motATrad){
        $api_url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=fr&dt=t&q=" . urlencode($motATrad->getLibelle()); /** Définition de l'URL de l'API en prenant le mot à traduire */
        $resApi = file_get_contents($api_url); /** Résultat de l'utilisation de l'API */
        $res = json_decode($resApi, true); /** Le résultat est un JSON, alors on le décode */
        return $res[0][0][0];    /** La traduction se trouve dans la première position du tableau */
    } 
}

