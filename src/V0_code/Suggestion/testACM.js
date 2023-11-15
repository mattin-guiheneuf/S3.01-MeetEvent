//____________________________________________________________________________________//
//____________________________________________________________________________________//
//                                                                                    //
//                                Creation OBJECTS                                    //
//                                                                                    //
//____________________________________________________________________________________//
//____________________________________________________________________________________//


//Objet evenement utilisé pour le traitement
class Evenement {
    
    //VARIABLES
    #id = "";
    #titre = "";
    #date = "";
    #lieu = "";
    #mesMots = [];
    #desTags = [];

    //METHODES
    //CONSTRUCTEUR
    constructor(id, tag) {
        this.setId(id); // Attribut public
        this.setTag(tag); // Attribut public
    }

    //ENCAPSULATION
    getId(){return this.#id;}
    setId(id){this.#id = id;}
    getTag(){return this.#desTags;}
    setTag(tag){this.#desTags = tag;}

    //METHODES SPECIFIQUE
    #definirTag(){
        listeTag = []
        //TRAITEMENT
        return listeTag;
    }
    definirDescription(){
        listeMot = []
        //TRAITEMENT
        return listeMot;
    }
    supprimerTag(){

    }
    modifierDescription(){}
    //METHODES USUELLES
    toSTring(message){
        resultat = message;
        resultat += "L'évènement "+ this.getId() + " a pour tag : ";
        for (const element in this.getTag()) {
            resultat += element + " ";
        }
        return resultat;
    }
}

//Objet utilisateur utilisé pour le traitement
class Utilisateur {

    //VARIABLES
    #id = "";
    #nom = "";
    #mesMots = [];
    #desTags = [];

    //METHODES
    //CONSTRUCTEUR
    constructor(id, tag) {
        this.setId(id); // Attribut public
        this.setTag(tag); // Attribut public
    }

    //ENCAPSULATION
    getId(){return this.#id;}
    setId(id){this.#id = id;}
    getTag(){return this.#desTags;}
    setTag(tag){this.#desTags = tag;}

    //METHODES SPECIFIQUE
    #definirTag(){
        listeTag = []
        //TRAITEMENT
        return listeTag;
    }
    definirDescription(){
        listeMot = []
        return listeMot;
    }
    modifierDescription(){}
    creerListeSuggest(){
        return ACM();
    }
    supprimerTag(){

    }
    //METHODES USUELLES
    toSTring(message){
        resultat = message;
        resultat += "L'utilisateur "+ this.getId() + " a pour tag : ";
        for (const element in this.getTag()) {
            resultat += element + " ";
        }
        return resultat;
    }
}


//____________________________________________________________________________________//
//____________________________________________________________________________________//
//                                                                                    //
//                                   IMPORTATION                                      //
//                                                                                    //
//____________________________________________________________________________________//
//____________________________________________________________________________________//


const fs = require('fs'); // Nécessaire pour la lecture du fichier (environnement Node.js)
const prompt = require('prompt-sync')();
const contenuJSON = fs.readFileSync('donnees.json');
const donnees = JSON.parse(contenuJSON);


//____________________________________________________________________________________//
//____________________________________________________________________________________//
//                                                                                    //
//                                 INITIALISATION                                     //
//                                                                                    //
//____________________________________________________________________________________//
//____________________________________________________________________________________//

let CorpusTag = ["musique","voyage","lecture","sport","nature","photographie","cinema","jeux video","art","film","festival","competition","exposition"];
let eventsAndUserPreferences = [];

//-------------------------------------------------------------//
//                      Partie Evenement                       //
//-------------------------------------------------------------//

let objetEvenement = [];    //On stock tous les objets Evenement
//Créer et Stocker des objets evenements
for (let i = 0; i < donnees.evenements.length; i++) {
    const element = donnees.evenements[i];
    //console.log("Evénement ",element.id," : tags", element.tags);
    objetEvenement.push(new Evenement(element.id,element.tags));
}

//afficherEventNB();


//Transformation de tous les evenements
//On parcours tous les evenements existant
for (let i = 0; i < objetEvenement.length; i++) {
    let eventsB = [];    //Liste pour UN evenement
    const objetEvenementElement = objetEvenement[i].getTag();
    //Pour tous les tags de L'evenement
    for (let j = 0; j < CorpusTag.length; j++) {    //On regarde si ils sont present dans le corpus tag et on y attribut un 1 sinon 0
        const CorpusTagElement = CorpusTag[j];
        if (objetEvenementElement.includes(CorpusTagElement)) {
            eventsB.push(1);
        }else{
            eventsB.push(0);
        }
    }
    //On ajoute l'evenement (avec valeurs binaires) à l'ensemble des évènements
    eventsAndUserPreferences.push(eventsB);
}

//afficherEventB();

//-------------------------------------------------------------//
//                     Partie Utilisateur                      //
//-------------------------------------------------------------//

//créer l'utilisateur connecté
let dicoUser = {}
for (let i = 0; i < donnees.utilisateurs.length; i++) {
    const element = donnees.utilisateurs[i];
    dicoUser[element.id]=element.tags;
}
let idUserConnected = 1; //x = VARIABLE GLOBALE (id de l'utilisateur connecté)
let userConnected = new Utilisateur(idUserConnected,dicoUser[idUserConnected]);


//afficherUtilisateurNB();

//On ajout l'utilisateur en dernier
let user = [];
//Pour tous les tags de L'utilisateur
for (let i = 0; i < CorpusTag.length; i++) {    //On regarde si ils sont present dans le corpus tag et on y attribut un 1 sinon 0
    const TagElement = CorpusTag[i];
    if (userConnected.getTag().includes(TagElement)) {
        user.push(1);
    }else{
        user.push(0);
    }
}
//On ajoute l'utilisateur (avec valeurs binaires) à l'ensemble des évènements
eventsAndUserPreferences.push(user);

//afficherUtilisateurB();

//____________________________________________________________________________________//
//____________________________________________________________________________________//
//                                                                                    //
//                             TRAITEMENTS -- ACM                                     //
//                                                                                    //
//____________________________________________________________________________________//
//____________________________________________________________________________________//


// Fonction pour calculer le produit scalaire
function dotProduct(vec1, vec2) {
    let result = 0;
    for (let i = 0; i < vec1.length; i++) {
        result += vec1[i] * vec2[i];
    }
    return result;
}

// Fonction pour calculer la norme
function norm(vec) {
    let sum = 0;
    for (let i = 0; i < vec.length; i++) {
        sum += vec[i] * vec[i];
    }
    return Math.sqrt(sum);
}

// Fonction pour calculer la similarité cosinus
function cosineSimilarity(vec1, vec2) {
    const dot = dotProduct(vec1, vec2);
    const normVec1 = norm(vec1);
    const normVec2 = norm(vec2);
    return ((dot / (normVec1 * normVec2))).toFixed(2);
}

function ACM(){
    // Supposons que la dernière ligne représente les préférences de l'utilisateur
    const userPreferences = eventsAndUserPreferences[eventsAndUserPreferences.length - 1];

    //Création d'un dico pour le stockage
    let dicoEvents = {"user" : userConnected, "events" : []};


    // Comparaison des événements avec les préférences de l'utilisateur (similarité cosinus)
    for (let i = 0; i < eventsAndUserPreferences.length - 1; i++) {
        const event = eventsAndUserPreferences[i];
        const similarity = cosineSimilarity(userPreferences, event);
        console.log(`Similarité entre l'événement ${objetEvenement[i].getId()} et l'utilisateur ${userConnected.getId()} : ${similarity*100}%`);
        //Ajouter chaque évènement et sa similarité dans un dico
        dicoEvents["events"].push([objetEvenement[i].getId(),similarity]);
    }

    afficherContenuDicoEvent(dicoEvents);

    //Création d'une liste pour le stockage d'events de plus de 70% de similarité
    return recupererEvenements(dicoEvents);
    
}

//let listEventaRecommander = ACM();
//console.log("\nListe des événements à recommander:");
//console.log(listEventaRecommander);

let listEventaRecommander = userConnected.creerListeSuggest();
console.log("\nListe des événements à recommander:");
console.log(listEventaRecommander);

//____________________________________________________________________________________//
//____________________________________________________________________________________//
//                                                                                    //
//                       FONCTION DE VERIFICATION (EXTERNE)                           //
//                                                                                    //
//____________________________________________________________________________________//
//____________________________________________________________________________________//

//Afficher les tags des evenements (objet) NB = non binaire
function afficherEventNB(){
    for (let i = 0; i < objetEvenement.length; i++) {
        const objet = objetEvenement[i];
        console.log(objet.tag);
    }
}

//Afficher les tags des evenements (objet) B = binaire
function afficherEventB(){
    for (let i = 0; i < eventsAndUserPreferences.length; i++) {
        const objet = eventsAndUserPreferences[i];
        console.log(objet);
    }
}

//Afficher les tags de l'utilisateur (objet) NB = non binaire
function afficherUtilisateurNB(){
    console.log(userConnected.getId()," ",userConnected.getTag());
}

//Afficher les tags de l'utilisateur (objet) B = binaire
function afficherUtilisateurB(){
    console.log(eventsAndUserPreferences);
}

//Afficher le contenu du dictionnaire contenant tous les évènement et leur pourcentage de similarité
function afficherContenuDicoEvent(dico){
    console.log("\nContenu du dictionnaire:");
    for (const key in dico) {
        if (key === "events") {
            console.log(`Clé "${key}": `);
            dico[key].forEach(event => {
                console.log(`  Événement: ${event[0]}, Similarité: ${event[1]}`);
            });
        } else {
            console.log(`Clé "${key}": ${userConnected.getId()}`);
        }
    }
}


//Tri/déterminer les événements à recommander
function recupererEvenements(dico) {
    let evenements = [];

    // Filtrer les événements avec une similarité >= 0.7
    let evenementsFiltres = dico.events.filter(event => event[1] >= 70);

    if (evenementsFiltres.length === 0) {
        // S'il n'y a pas d'événements avec similarité >= 0.7, trier par similarité décroissante et prendre les 5 premiers
        dico.events.sort((a, b) => b[1] - a[1]); // Trie par similarité décroissante
        for (let i = 0; i < 5 && i < dico.events.length; i++) {
            evenements.push(dico.events[i][0]); // Ajoute le nom de l'événement à la liste
        }
    } else {
        // Ajoute les événements avec similarité >= 0.7 à la liste
        evenementsFiltres.forEach(event => {
            evenements.push(event[0]); // Ajoute le nom de l'événement à la liste
        });
    }

    return evenements;
}