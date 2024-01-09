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
    function synAvecAPI($wordToSearch,$destinationFile = NULL)
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
    }

    // Fonction creaDicoSynTag
    function creaDicoSynTag($CORPUS_TAG)
    {
        echo "Lancement création dicoSynTag <br><br>";

        // VARIABLES
        $dicoSynTag = array();

        // TRAITEMENTS
        // Ajout des tags au dicoSynTag pour qu'ils soient également détectés
        foreach ($CORPUS_TAG as $tagCourant) {
            $dicoSynTag += array($tagCourant=>array($tagCourant));
        }
    
        // Enrichissement au premier degré du dictionnaire avec les synonymes des tags
        foreach ($CORPUS_TAG as $tagCourant)
        {
            $listeSynTagCourant = synAvecAPI($tagCourant)['synonyms'];
            
            foreach($listeSynTagCourant as $synTagCourant)
            {
                if(array_key_exists($synTagCourant,$dicoSynTag)){
                    if(!(in_array($tagCourant,$dicoSynTag[$synTagCourant]))){
                        array_push($dicoSynTag[$synTagCourant],$tagCourant);
                    }
                }
                else
                {
                    $dicoSynTag[$synTagCourant] = array($tagCourant);
                }
            }
        }

        echo "encodage<br>";
        file_put_contents('dicoSynTag.json',json_encode($dicoSynTag,JSON_PRETTY_PRINT));
        echo "encodage terminé<br><br>";

        return $dicoSynTag;
    }

    //$CORPUS_TAG_test = ['mother','father','bulge'];

    //creaDicoSynTag($CORPUS_TAG_test);

?>