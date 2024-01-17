<?php
/**
 * 
 */

class ApiDictionnaireFr{

    // METHODES
    public function utiliserApiDicoFr(Mot $mot){
        $listeMotFr = json_decode(file_get_contents('../data/motsFr.json'), true); // récupération liste mots français
        //on regarde si il existe
        $estPresent = in_array(trim($mot->getLibelle()),$listeMotFr);
        //on renvoie si oui (1) ou non (0) il existe : appartient au dictionnaire
        return $estPresent;
    } 
}

