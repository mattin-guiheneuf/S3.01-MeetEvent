<!-- SAE -->
<?php

    function tradMotAngToFr($motATrad){ // Fonction qui traduit les mots d'anglais à français
        $api_url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=fr&dt=t&q=" . urlencode($motATrad); // URL de l'API
        $resApi = file_get_contents($api_url); // Résultat de l'API
        // Le résultat est un JSON, alors on le décode
        $res = json_decode($resApi, true);
        // La traduction se trouve dans la première position du tableau
        return $res[0][0][0];
    }

    //echo tradMotAngToFr('Lucas fuck you bro fucking bambi') . '<br><br>';
?>