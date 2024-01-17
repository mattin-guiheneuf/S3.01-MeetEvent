<?php
/**
 * @file apiDictionnaireFr.php
 * @author Yannis Duvignau
 * @brief Fichier contenant la classe apiDictionnaireFr
 * @details Contient la structure de la classe apiDictionnaireFr
 * @version 1.0
 */

/**
 * Classe apiDictionnaireFr qui permet d'utiliser notre API de Dictionnaire Français
 */

class ApiDictionnaireFr{
    /** Methode */
    /**
     * @brief Verifie si un mot est correctement écrit
     * @param [in] Mot $motAVerif
     * @return bool
     */
    public function utiliserApiDicoFr(Mot $mot){
        $listeMotFr = json_decode(file_get_contents('../data/motsFr.json'), true); // récupération liste mots français
        //on regarde si il existe
        $estPresent = in_array(trim($mot->getLibelle()),$listeMotFr);
        //on renvoie si oui (1) ou non (0) il existe : appartient au dictionnaire
        return $estPresent;
    } 
}

