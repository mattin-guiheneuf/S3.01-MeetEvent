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
    public function utiliserApiDicoFr(Mot $motAVerif){
        $listeMotFr = json_decode(file_get_contents('../data/motsFr.json'), true); /** Récupération des mots français sous forme de liste à partir d'un fichier json */
        $estPresent = in_array(trim($mot->getLibelle()),$listeMotFr); /** On regarde si le $motAVerif est présent dans notre liste */
        return $estPresent; /** S'il existe et qu'il appartient au dictionnaire  */
    } 
}

