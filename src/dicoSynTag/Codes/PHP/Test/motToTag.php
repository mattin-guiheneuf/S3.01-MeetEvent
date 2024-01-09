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
                $dicoMotToTag[$motCourant] = array($dicoSynTag[$motCourant]);
                array_push($listeTag,$motCourant);
            }
            else // Sinon enrichissement de 1 degré à partir des mots
            {
                $listeSynMot = synAvecAPI($motCourant)['synonyms'];
                foreach ($listeSynMot as $synMotCourant) {
                    if(array_key_exists($synMotCourant,$dicoSynTag)) // Si présence ajout et enregistrement
                    {
                        $dicoMotToTag[$motCourant] = array($synMotCourant,$dicoSynTag[$synMotCourant]);
                        array_push($listeTag,$dicoSynTag[$synMotCourant]);
                    }
                    else // Sinon enrichissement de 1 degré supplémentaire (degré 2) à partir des tags
                    {
                        foreach($dicoSynTag as $syn => $listeSyn){
                            $listeSynSynDicoSynTag = synAvecAPI($syn)['synonyms'];
                            if(in_array($motCourant,$listeSynSynDicoSynTag)){ // Vérif présence du mot de base dans les synonymes de synonymes de tag
                                $dicoMotToTag[$motCourant]=array($syn,$dicoSynTag[$syn]);
                                if(!(in_array($dicoSynTag[$syn],$listeTag))){
                                    array_push($listeTag,$dicoSynTag[$syn]);
                                }
                                break;
                            }
                            elseif (in_array($synMotCourant,$listeSynSynDicoSynTag)) // Vérif présence du synonyme du mot dans les synonymes de synonymes de tag
                            {
                                $dicoMotToTag[$motCourant] = array($synMotCourant,$syn,$dicoSynTag[$syn]);
                                if(!(in_array($dicoSynTag[$syn],$listeTag))){
                                    array_push($listeTag,$dicoSynTag[$syn]);
                                }
                                break;
                            }
                            else
                            {
                                $dicoMotToTag[$motCourant] = array('Impossible à lier');
                            }
                        }
                    }
                }
            }
        }

        echo "encodage<br>";
        file_put_contents('motToTag.json',json_encode($dicoMotToTag,JSON_PRETTY_PRINT));
        echo "encodage terminé";

        print_r($dicoMotToTag);
        echo'<br>';
        print_r($listeTag);

        return array($dicoMotToTag,$listeTag);

    }

    motToTag($listeMot,$dicoSynonymeTags);

?>