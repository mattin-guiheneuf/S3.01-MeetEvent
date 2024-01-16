<?php


/**
 * Classe représentant un utilisateur.
 */
class Utilisateur {
    //ATTRIBUTS

    /**
     * @var int L'id de l'utilisateur.
     */
    private $id;

    /**
     * @var string Le nom/pseudo de l'utilisateur.
     */
    private $nom = "";

    /**
     * @var array La liste de Mot (saisi) de l'utilisateur.
     */
    private $mesMots=  [];

    /**
     * @var array La liste de Tag (attribué) de l'utilisateur.
     */
    private $desTags= []; 

    /**
     * @var Recommandation La recommandation de l'utilisateur.
     */
    private $maRecommandation = null;

    //METHODES
    //CONSTRUCTEUR
    /**
     * Constructeur de la classe Utilisateur.
     *
     * @param int $id L'id à attribuer à l'utilisateur créé.
     * @param array $tags Tableau de Tags à attribuer à l'utilisateur créé.
     */
    public function __construct(int $id, array $tags) {
        $this->setId($id);
        $this->setTags($tags);
    }
    //ENCAPSULATION (get&set)
    //id
    /**
     * Obtient l'id de l'utilisateur.
     *
     * @return int ID.
     */
    public function getId() {
        return $this->id;
    }
    /**
     * Attribuer l'id à un utilisateur.
     *
     * @param int $id un id représentant l'id de l'utilisateur.
     */
    public function setId(int $id) {
        $this->id = $id;
    }
    //nom
    /**
     * Obtient le nom de l'utilisateur.
     *
     * @return string nom.
     */
    public function getNom() {
        return $this->nom;
    }
    /**
     * Attribuer un nom à un utilisateur.
     *
     * @param string $nom un nom représentant le nom de l'utilisateur.
     */
    public function setNom(string $nom) {
        $this->nom = $nom;
    }
    //tags
    /**
     * Obtient la liste de Tag de l'utilisateur.
     *
     * @return array Tags.
     */
    public function getTags() {
        return $this->desTags;
    }
    /**
     * Attribuer la liste de Tags à un utilisateur.
     *
     * @param array $tags une liste de Tag représentant les Tags de l'utilisateur.
     */
    public function setTags(array $tags) {
        $this->desTags = $tags;
    }
    //mots
    /**
     * Obtient la liste de Mot de l'utilisateur.
     *
     * @return array Mots.
     */
    public function getMots() {
        return $this->mesMots;
    }
    /**
     * Attribuer la liste de Tags à un utilisateur.
     *
     * @param Mot[] $tags une liste de Mot représentant les Mots de l'utilisateur.
     */
    public function setMots(array $mots) {
        $this->mesMots = $mots;
    }
    //maRecommandation
    /**
     * Obtient la recommandation de l'utilisateur.
     *
     * @return Recommandation maRecommandation.
     */
    public function getRecommandation() {
        return $this->maRecommandation;
    }
    /**
     * Attribuer la recommandation d'un utilisateur.
     *
     * @param Recommandation $reco une recommandation représentant la recommandation de l'utilisateur.
     */
    public function setRecommandation(Recommandation $reco) {
        $this->maRecommandation = $reco;
    }

    //METHODES SPECIFIQUES
    /**
     * METHODE SPECIFIQUE : Attribuer la liste de Tags à un utilisateur en fonction des mots saisis.
     *
     * @return array $listeTags une liste de Tag représentant les Tags de l'utilisateur.
     */
    private function definirTags() {
        // VARIABLES
        $dicoMotToTag = array(); // Le résultat de la fonction avec les étapes par lesquelles on passe pour arriver aux tags
        $listeTag = array(); // Le résultat de la fonction avec la liste des tags
        $listeMot = $this->getMots();
        $dicoSynTag = new DicoSynTags();

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
        file_put_contents('./data/motToTag.json',json_encode($dicoMotToTag,JSON_PRETTY_PRINT));

        // Renvoyer
        return $dicoMotToTag;
    }

    /**
     * METHODE SPECIFIQUE : Attribuer la liste de Mots à un utilisateur en fonction des mots saisis.
     *
     */
    public function definirDescription() {

        $motsLib = array();
        foreach ($this->getMots() as $mot) {
            $motsLib[] = $mot->getLibelle();
        }

        //Ajout des données dans le json-------------------------
        // Mise à jour des données
        // Lire le contenu JSON depuis le fichier
        $contenuJSON = file_get_contents('./data/donnees.json');
        $donnees = json_decode($contenuJSON, true);

        // Nouvel utilisateur à ajouter
        $nouvelUtilisateur = array(
            "id" => $this->getId(),
            "nom" => $this->getNom(),
            "mots" => $motsLib,
            "tags" => []
        );
        //$donnees['utilisateurs'][$this->getId() - 1]['mots'] = $motsLib;
        
        // Ajouter le nouvel utilisateur à la liste des utilisateurs existants
        $donnees['utilisateurs'][] = $nouvelUtilisateur;
        
        // Écrire les données mises à jour dans le fichier JSON
        file_put_contents('./data/donnees.json', json_encode($donnees, JSON_PRETTY_PRINT));

        //Afficher résultats----------------------------------------
        echo "-----------------------------------";
        echo "<br>Utilisateur ".$this->getNom()." (".$this->getId().") créé ! Il possède les mots : ";
        foreach ($this->getMots() as $mot) {
            echo $mot->getLibelle()." ";
        }
        echo "<br>-----------------------------------";

        $this->definirTags();
    }

    /**
     * METHODE SPECIFIQUE : Modifier les Mots saisis.
     *
     */
    public function modifierDescription() {
        $listeMot = $this->getTags();
        echo implode(", ", $this->getTags()) . PHP_EOL;

        while (true) {
            $mot = readline("Entrez un tag (quit pour quitter): ");

            if ($mot == "quit") {
                break;
            } else {
                if (!in_array($mot, $listeMot)) {
                    // AJOUTER le mot
                    $listeMot[] = $mot;
                    echo "L'élément '$mot' a été ajouté à ta liste de tags." . PHP_EOL;
                    echo implode(", ", $this->getTags()) . PHP_EOL;
                } else {
                    // RETIRER le mot car il y est déjà
                    // Demander confirmation de suppression
                    $confirmation = readline("Êtes-vous sûr de vouloir supprimer '$mot' (o/n) : ");
                    if ($confirmation == "o") {
                        $index = array_search($mot, $listeMot);
                        if ($index !== false) {
                            unset($listeMot[$index]);
                            $listeMot = array_values($listeMot); // Réorganiser les indices du tableau
                            echo "L'élément '$mot' a été supprimé de la liste des tags." . PHP_EOL;
                            echo implode(", ", $this->getTags()) . PHP_EOL;
                        }
                    }
                }
            }
        }

        $this->setTags($listeMot);

        // Mise à jour des données
        $donnees['utilisateurs'][$this->getId() - 1]['tags'] = $this->getTags();

        // Écrire les données mises à jour dans le fichier JSON
        file_put_contents('donnees.json', json_encode($donnees, JSON_PRETTY_PRINT, 2));

        // Redéfinir les tags en fonction des nouveaux mots
        $this->definirTags();
    }

    /**
     * METHODE SPECIFIQUE : Désigner des événements qui correspondent aux envies de l'utilisateur.
     *
     * @return array $evenementsARecommander une liste d'événements à recommander.
     */
    public function creerListeSuggest() {
        // Récupérer tous les événements avec leurs pourcentages
        $reco = $this->getRecommandation()->getSuggestion();
    
        // Trier les événements par pourcentage par ordre décroissant
        usort($reco, function ($a, $b) {
            return $b['pourcentage'] <=> $a['pourcentage'];
        });
    
        // Déterminer quels événements recommander
        $evenementsARecommander = [];
        foreach ($reco as $paire) {
            $evenementId = $paire['evenement'];
            $pourcentage = $paire['pourcentage'];
    
            // Filtrer les événements avec une similarité >= 0.7
            if ($pourcentage >= 0.7) {
                $evenementsARecommander[] = $evenementId;
            }
        }
    
        // Si le nombre d'événements recommandés est inférieur à 5, prendre les 5 premiers basés sur le pourcentage
        if (count($evenementsARecommander) < 5) {
            for ($i = 0; $i < 5 && $i < count($reco); $i++) {
                $evenementsARecommander[] = $reco[$i]['evenement'];
            }
        }
    
        return $evenementsARecommander;
    }

    /**
     * METHODE SPECIFIQUE : Supprimer des Tags qui sont attribués à l'utilisateur.
     *
     * @param Tag $tagASupprimer un tag à supprimer
     */
    public function supprimerTag(Tag $tagASupprimer) {
        $listeTag = $this->getTags();
        $indiceDuTag = array_search($tagASupprimer, $listeTag);

        // Vérifier si l'élément existe dans la liste
        if ($indiceDuTag !== false) {
            // Utiliser la fonction array_splice pour supprimer l'élément à l'indice trouvé
            array_splice($listeTag, $indiceDuTag, 1);
            echo "L'élément '".$tagASupprimer->getLibelle()."' a été supprimé de la liste." . PHP_EOL;

            // Afficher la liste mise à jour
            echo implode(", ", $listeTag) . PHP_EOL;
        } else {
            echo "L'élément '".$tagASupprimer->getLibelle()."' n'a pas été trouvé dans la liste." . PHP_EOL;
        }

        $this->setTags($listeTag);

        // Mise à jour des données
        $donnees['utilisateurs'][$this->getId() - 1]['tags'] = $this->getTags();

        // Écrire les données mises à jour dans le fichier JSON
        file_put_contents('donnees.json', json_encode($donnees, JSON_PRETTY_PRINT, 2));
    }

    /**
     * METHODE SPECIFIQUE : Lier une recommandation et l'événement.
     *
     * @param Recommandation $recommandation une recommandation représentant la recommandation de l'événement.
     */
    public function linkToSuggest(Recommandation $recommandation){
        $this->unlinkToSuggest();
        $this->setRecommandation($recommandation);
    }

     /**
     * METHODE SPECIFIQUE : Délier une recommandation et l'événement.
     *
     */
    public function unlinkToSuggest(){
        if ($this->getRecommandation() != null) {
            $this->maRecommandation = null;
        }
    }

    //METHODES USUELLES
    /**
     * METHODE SPECIFIQUE : Afficher la description de l'Utilisateur.
     *
     * @param string message de base à ajouter a la description de la class Utilisateur
     * @return string $resultat une chaine de caractere représentant la description de l'utilisateur.
     */
    public function toString(string $message) {
        $resultat = $message;
        $resultat .= PHP_EOL . "L'utilisateur " . $this->getId() . " a pour tag : ";

        foreach ($this->getTags() as $element) {
            $resultat .= $element->getLibelle() . " ";
        }

        return $resultat;
    }
}