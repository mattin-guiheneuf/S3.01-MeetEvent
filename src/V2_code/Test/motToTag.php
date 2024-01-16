<!-- SAE -->
<?php

    // Importation du dicoSynTag.php pour création pour tests
    include_once "./creaDicoSynTag.php";

    $CORPUS_TAG_test = ['mother','father','bulge'];

    

    $dicoSynonymeTags = creaDicoSynTag($CORPUS_TAG_test);

    $listeMot = ['female parent','get','pa']; // Pour le test
    
    function motToTag($listeMot,$dicoSynTag){
        echo 'Lancement motToTag<br><br>';

        // VARIABLES
        $dicoMotToTag = array(); // Le résultat de la fonction avec les étapes par lesquelles on passe pour arriver aux tags
        $listeTag = array(); // Le résultat de la fonction avec la liste des tags

        // TRAITEMENTS
        foreach ($listeMot as $motCourant) { // Pour chaque mot de la liste
            // Vérif mot en double
            if (array_key_exists($motCourant, $dicoMotToTag)) { // Si le mot est déjà présent dans le dico
                echo $motCourant . " déjà présent dans le dicoMotToTag<br>"; // C'est que le mot est en double
                continue; // équivalent de pass
            }
            // Vérif présence dans dicoSynTag du mot
            if (array_key_exists($motCourant, $dicoSynTag)) { // Si le motCourant est présent dans le dicoSynTag
                // Ajout et enregistrement
                $dicoMotToTag[$motCourant] = $dicoSynTag[$motCourant];
                $listeTag[] = $dicoSynTag[$motCourant];
            }
            else // Sinon enrichissement de 1 degré à partir des mots
            {
                $listeSynMot = synAvecAPI($motCourant)['synonyms']; // Appel de l'API pour récupérer les synonymes du mot courant
                foreach ($listeSynMot as $synMotCourant) { // Pour chaque synonyme du motCourant
                    if (array_key_exists($synMotCourant, $dicoSynTag)) { // Si le synMotCourant est présent dans le dicoSynTag
                        // Ajout et enregistrement
                        $dicoMotToTag[$motCourant] = array($synMotCourant, $dicoSynTag[$synMotCourant]);
                        $listeTag[] = $dicoSynTag[$synMotCourant]; // Verif si déjà présent ???
                    }
                    else // Sinon enrichissement de 1 degré supplémentaire (degré 2) à partir des tags
                    {
                        foreach ($dicoSynTag as $syn => $tag) { // Pour chaque synonyme (clé) du dicoSynTag
                            $listeSynSynDicoSynTag = synAvecAPI($syn)['synonyms']; // Appel de l'API pour récupérer les synonymes des clés du dicoSynTag
                            if (in_array($motCourant, $listeSynSynDicoSynTag)) { // Vérif présence du mot de base dans les synonymes de synonymes de tag
                                $dicoMotToTag[$motCourant] = array($syn, $dicoSynTag[$syn]); // Si présent, ajout dans le dicoMotToTag en précisant par quel syn on fait le lien
                                if (!in_array($dicoSynTag[$syn], $listeTag)) { // Vérif que le tag n'est pas déjà présent dans la liste de tags
                                    $listeTag[] = $dicoSynTag[$syn];
                                }
                                break;
                            }
                            elseif (in_array($synMotCourant, $listeSynSynDicoSynTag)) { // Vérif présence du synonyme du mot dans les synonymes de synonymes de tag
                                $dicoMotToTag[$motCourant] = array($synMotCourant, $syn, $dicoSynTag[$syn]); // Si présent, ajout dans le dicoMotToTag en précisant par quel syn on fait le lien
                                if (!in_array($dicoSynTag[$syn], $listeTag)) { // Vérif que le tag n'est pas déjà présent dans la liste de tags
                                    $listeTag[] = $dicoSynTag[$syn];
                                }
                                break;
                            }
                            else // Sinon pas de lien avec le corpus de tags
                            {
                                $dicoMotToTag[$motCourant] = array('Impossible à lier');
                            }
                        }
                    }
                }
            }
        }

        $realListeTag = array(); // Enlever les doublons ou autre (pas nécessaires si vérif presence à chaque ajout dans liste ???)
        foreach ($listeTag as $liste) {
            foreach ($liste as $tag) {
                if (!in_array($tag, $realListeTag)) {
                    $realListeTag[] = $tag;
                }
            }
        }

        // encodage en json
        echo "encodage<br>";
        file_put_contents('motToTag.json',json_encode($dicoMotToTag,JSON_PRETTY_PRINT));
        echo "encodage terminé<br><br>";

        // Affichage pour vérif res
        echo "DicoMotToTag :<br>";
        print_r($dicoMotToTag);
        echo "<br><br>listeTag :<br>";
        print_r($realListeTag);

        // Renvoyer
        return array($dicoMotToTag, $realListeTag);
    }

    motToTag($listeMot,$dicoSynonymeTags);

?>