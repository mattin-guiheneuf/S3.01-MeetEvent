<!-- SAE -->
<?php
    // Programme principal lié à index pour le test, etc, ...

    if (isset($_POST['submit'])) {
        $url = curl_init();

        if (isset($_POST['WORDTOSEARCH'])) {
            $word = $_POST['WORDTOSEARCH'];
        }
        else {
            // Redirection
            echo "<script> window.location.replace('./index.html');</script>";
        }
        

        $urlARechercher = "https://wordsapiv1.p.rapidapi.com/words/";
        $urlARechercher = $urlARechercher . $word . "/synonyms";


        curl_setopt_array($url, [
            CURLOPT_URL => $urlARechercher,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: wordsapiv1.p.rapidapi.com",
                "X-RapidAPI-Key: f59a2efa60msha84f78f61a68ddap12ca6djsnadb8f76a8e62"
            ],
        ]);
        
        $response = curl_exec($url);
        $err = curl_error($url);
        
        curl_close($url);
        
        if ($err) {
            echo "URL Error #:" . $err;
        } else {
            echo gettype($response) . "<br>";
            echo $response;
            $data = json_decode($response,true);
            file_put_contents('./dicoSynTag.json',json_encode($data,JSON_PRETTY_PRINT));
        }
    }

    // Transformation en fonction
    /* function synAvecAPI($wordToSearch,$destinationFile = NULL)
    {
        $url = curl_init();
        $urlARechercher = "https://wordsapiv1.p.rapidapi.com/words/";
        $urlARechercher = $urlARechercher . $wordToSearch . "/synonyms";
        curl_setopt_array($url, [
            CURLOPT_URL => $urlARechercher,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: wordsapiv1.p.rapidapi.com",
                "X-RapidAPI-Key: f59a2efa60msha84f78f61a68ddap12ca6djsnadb8f76a8e62"
            ],
        ]);
            
        $response = curl_exec($url);
        $err = curl_error($url);
            
        curl_close($url);
            
        if ($err) {
            echo "URL Error #:" . $err;
        } else {
            $data = json_decode($response,true);
            if ($destinationFile != NULL)
            {
                file_put_contents($destinationFile,json_encode($data,JSON_PRETTY_PRINT));
            }
        }
        
        return $data;
    } */

    include_once "./index.php";

    $CORPUS_TAG_test = ['mother','father','bulge'];

    

    $dicoSynonymeTags = creaDicoSynTag($CORPUS_TAG_test);

    $listeMot = ['female parent','get','pa'];

    function motToTag($listeMots,$dicoSynTag){
        echo 'Lancement motToTag<br><br>';

        // VARIABLES
        $dicoMotToTag = array();
        $listeTag = array();

        // TRAITEMENTS
        foreach ($listeMots as $motCourant) {
            // Vérif mot en double
            if (array_key_exists($motCourant,$dicoMotToTag)){
                echo $motCourant.' déjà présent dans le dicoMotToTag<br>';
                //pass
            }
            // Vérif présence dans dicoSynTag du mot
            if (array_key_exists($motCourant,$dicoSynTag)){ // Si présence ajout et enregistrement
                $dicoMotToTag[$motCourant] = /* array( */$dicoSynTag[$motCourant]/* ) */;
                //array_push($dicoMotToTag[$motCourant],$dicoSynTag[$motCourant]);
                array_push($listeTag,$dicoSynTag[$motCourant]/* $motCourant */);
            }
            else // Sinon enrichissement de 1 degré à partir des mots
            {
                $listeSynMot = synAvecAPI($motCourant)['synonyms'];
                foreach ($listeSynMot as $synMotCourant) {
                    if(array_key_exists($synMotCourant,$dicoSynTag)) // Si présence ajout et enregistrement
                    {
                        //$dicoMotToTag[$motCourant] = array($synMotCourant,$dicoSynTag[$synMotCourant]);
                        array_push($dicoMotToTag[$motCourant],$synMotCourant,$dicoSynTag[$synMotCourant]);
                        array_push($listeTag,$dicoSynTag[$synMotCourant]);
                    }
                    else // Sinon enrichissement de 1 degré supplémentaire (degré 2) à partir des tags
                    {
                        $cpt=0;
                        foreach($dicoSynTag as $syn => $listeSyn){
                            $cpt++;
                            $listeSynSynDicoSynTag = synAvecAPI($syn)['synonyms'];
                            if(in_array($motCourant,$listeSynSynDicoSynTag)){ // Vérif présence du mot de base dans les synonymes de synonymes de tag
                                if(is_array($dicoMotToTag[$motCourant])){
                                    array_push($dicoMotToTag[$motCourant],$syn,$dicoSynTag[$syn]);
                                }
                                else {
                                    $dicoMotToTag[$motCourant]=array($syn,$dicoSynTag[$syn]);
                                }
                                if(!(in_array($dicoSynTag[$syn],$listeTag))){
                                    array_push($listeTag,$dicoSynTag[$syn]);
                                }
                                break;
                            }
                            elseif (in_array($synMotCourant,$listeSynSynDicoSynTag)) // Vérif présence du synonyme du mot dans les synonymes de synonymes de tag
                            {
                                if(is_array($dicoMotToTag[$motCourant])){
                                    array_push($dicoMotToTag[$motCourant],$synMotCourant,$syn,$dicoSynTag[$syn]);
                                }
                                else
                                {
                                    $dicoMotToTag[$motCourant] = array($synMotCourant,$syn,$dicoSynTag[$syn]);
                                }
                                if(!(in_array($dicoSynTag[$syn],$listeTag))){
                                    array_push($listeTag,$dicoSynTag[$syn]);
                                }
                                break;
                            }
                            else
                            {
                                //None;
                            }
                            if (count($dicoSynTag)==$cpt) {
                                $dicoMotToTag[$motCourant] = array('Impossible à lier');
                                //array_push($dicoMotToTag[$motCourant],'Impossible à lier');
                            }
                        }
                    }
                }
            }
        }

        echo "encodage<br>";
        file_put_contents('motToTag.json',json_encode($dicoMotToTag,JSON_PRETTY_PRINT));
        echo "encodage terminé<br><br>";

        print_r($dicoMotToTag);
        echo'<br><br>';
        print_r($listeTag);

        return array($dicoMotToTag,$listeTag);

    }

    //motToTag($listeMot,$dicoSynonymeTags);

    function motToTagV2($listeMot,$dicoSynTag) {
        echo 'Lancement motToTagV2<br><br>';

        $dicoMotToTag = array();
        $listeTag = array();
        
        foreach ($listeMot as $motCourant) {
            if (array_key_exists($motCourant, $dicoMotToTag)) {
                echo $motCourant . " déjà présent dans le dicoMotToTag";
                continue;
            }
            
            if (array_key_exists($motCourant, $dicoSynTag)) {
                if (is_array($dicoMotToTag[$motCourant])) {
                    array_push($dicoMotToTag[$motCourant],$dicoSynTag[$motCourant]);
                }
                else
                {
                    $dicoMotToTag[$motCourant] = array($dicoSynTag[$motCourant]);
                }
                
                //echo "ajout type1";
                $listeTag[] = $dicoSynTag[$motCourant];
            } else {
                $listeSynMot = synAvecAPI($motCourant)['synonyms'];
                foreach ($listeSynMot as $synMotCourant) {
                    if (array_key_exists($synMotCourant, $dicoSynTag)) {
                        if(is_array($dicoMotToTag[$motCourant])){
                            array_push($dicoMotToTag[$motCourant],$synMotCourant, $dicoSynTag[$synMotCourant]);
                        }
                        else
                        {
                            $dicoMotToTag[$motCourant] = array($synMotCourant, $dicoSynTag[$synMotCourant]);
                        }
                        $listeTag[] = $dicoSynTag[$synMotCourant];
                        
                        //echo "ajout type2";
                    } else {
                        foreach ($dicoSynTag as $syn => $tag) {
                            $listeSynSynDicoSynTag = synAvecAPI($syn)['synonyms'];
                            if (in_array($motCourant, $listeSynSynDicoSynTag)) {
                                if(is_array($dicoMotToTag[$motCourant])){
                                    array_push($dicoMotToTag[$motCourant],$syn, $dicoSynTag[$syn]);
                                }
                                else
                                {
                                    $dicoMotToTag[$motCourant] = array($syn, $dicoSynTag[$syn]);
                                }
                                
                                if (!in_array($dicoSynTag[$syn], $listeTag)) {
                                    $listeTag[] = $dicoSynTag[$syn];
                                    
                                    //echo "ajout type3";
                                }
                                break;
                            } elseif (in_array($synMotCourant, $listeSynSynDicoSynTag)) {
                                if(is_array($dicoMotToTag[$motCourant])){
                                    array_push($dicoMotToTag[$motCourant],$synMotCourant, $syn, $dicoSynTag[$syn]);
                                }
                                else
                                {
                                    $dicoMotToTag[$motCourant] = array($synMotCourant, $syn, $dicoSynTag[$syn]);
                                }
                                if (!in_array($dicoSynTag[$syn], $listeTag)) {
                                    $listeTag[] = $dicoSynTag[$syn];
                                    
                                    //echo "ajout type4";
                                }
                                break;
                            } else {
                                $dicoMotToTag[$motCourant] = array('Impossible à lier');
                            }
                        }
                    }
                }
            }
        }
        
        $realListeTag = array();
        foreach ($listeTag as $liste) {
            foreach ($liste as $tag) {
                if (!in_array($tag, $realListeTag)) {
                    $realListeTag[] = $tag;
                }
            }
        }

        echo "encodage<br>";
        file_put_contents('motToTag.json',json_encode($dicoMotToTag,JSON_PRETTY_PRINT));
        echo "encodage terminé<br><br>";

        echo "DicoMotToTag :";
        print_r($dicoMotToTag);
        echo "<br><br>listeTag :";
        print_r($realListeTag);
        return array($dicoMotToTag, $realListeTag);
    }

    function tradMotAngToFr($motATrad){
        //$res = https://translate.google.fr/?sl=en&tl=fr&text=mother%0A&op=translate;

        $api_url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=fr&dt=t&q=" . urlencode($motATrad);

        $resApi = file_get_contents($api_url);

        // Le résultat est un JSON, alors nous le décodons
        $res = json_decode($resApi, true);

        // La traduction se trouve dans la première position du tableau
        return $res[0][0][0];
    }

    //echo tradMotAngToFr('Lucas fuck you bro fucking bambi') . '<br><br>';
    
    function getSyn($motPourSyn)
{
    $api_url = "https://api.datamuse.com/words?rel_syn=" . urlencode($motPourSyn);

    $resApi = file_get_contents($api_url);

    // Le résultat est un JSON, alors nous le décodons
    $res = json_decode($resApi, true);

    // Extrayez les synonymes du tableau associatif
    $synonymes = array_column($res, 'word');

    return $synonymes;
}

    $motAGetSyn = 'dog';

    //echo "Synonymes de '$motAGetSyn' : " . tradMotAngToFr(implode(", ", getSyn($motAGetSyn)));

    //motToTagV2($listeMot,$dicoSynonymeTags);
    
    function motToTagV3Test($listeMot,$dicoSynTag){
        $dicoMotToTag = array();
        $listeTag = array();

        foreach ($listeMot as $motCourant) {
            if (array_key_exists($motCourant, $dicoMotToTag)) {
                echo $motCourant . " déjà présent dans le dicoMotToTag<br>";
                continue;
            }
            
            if (array_key_exists($motCourant, $dicoSynTag)) {
                /* if(is_array($dicoMotToTag[$motCourant])){
                    array_push($dicoMotToTag[$motCourant],$dicoSynTag[$motCourant]);
                }
                else{$dicoMotToTag[$motCourant] = array($dicoSynTag[$motCourant]);}
                 */
                $dicoMotToTag[$motCourant] = $dicoSynTag[$motCourant];
                //echo "ajout type1";
                $listeTag[] = $dicoSynTag[$motCourant];
            } else {
                $listeSynMot = synAvecAPI($motCourant)['synonyms'];
                foreach ($listeSynMot as $synMotCourant) {
                    if (array_key_exists($synMotCourant, $dicoSynTag)) {
                        $dicoMotToTag[$motCourant] = array($synMotCourant, $dicoSynTag[$synMotCourant]);
                        $listeTag[] = $dicoSynTag[$synMotCourant];
                        
                        //echo "ajout type2";
                    } else {
                        foreach ($dicoSynTag as $syn => $tag) {
                            $listeSynSynDicoSynTag = synAvecAPI($syn)['synonyms'];
                            if (in_array($motCourant, $listeSynSynDicoSynTag)) {
                                $dicoMotToTag[$motCourant] = array($syn, $dicoSynTag[$syn]);
                                if (!in_array($dicoSynTag[$syn], $listeTag)) {
                                    $listeTag[] = $dicoSynTag[$syn];
                                    
                                    //echo "ajout type3";
                                }
                                break;
                            } elseif (in_array($synMotCourant, $listeSynSynDicoSynTag)) {
                                $dicoMotToTag[$motCourant] = array($synMotCourant, $syn, $dicoSynTag[$syn]);
                                if (!in_array($dicoSynTag[$syn], $listeTag)) {
                                    $listeTag[] = $dicoSynTag[$syn];
                                    
                                    //echo "ajout type4";
                                }
                                break;
                            } else {
                                $dicoMotToTag[$motCourant] = array('Impossible à lier');
                            }
                        }
                    }
                }
            }
        }

        $realListeTag = array();
        foreach ($listeTag as $liste) {
            foreach ($liste as $tag) {
                if (!in_array($tag, $realListeTag)) {
                    $realListeTag[] = $tag;
                }
            }
        }

        echo "encodage<br>";
        file_put_contents('motToTag.json',json_encode($dicoMotToTag,JSON_PRETTY_PRINT));
        echo "encodage terminé<br><br>";

        echo "DicoMotToTag :<br>";
        print_r($dicoMotToTag);
        echo "<br><br>listeTag :<br>";
        print_r($realListeTag);

        return array($dicoMotToTag, $realListeTag);
    }

    motToTagV3Test($listeMot,$dicoSynonymeTags);

?>