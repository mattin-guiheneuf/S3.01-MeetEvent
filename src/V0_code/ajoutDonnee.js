const fs = require('fs'); // Nécessaire pour la lecture du fichier (environnement Node.js)
const prompt = require('prompt-sync')();
const contenuJSON = fs.readFileSync('donnees.json');
const donnees = JSON.parse(contenuJSON);

//CREATION D'UN TYPE ENUM POUR LE CHOIX DE L'AJOUT
const typeAjout={
    ajoutUtilisateur : 1,
    ajoutEvenement : 2
}


// Saisie de l'ID utilisateur à rechercher
const userId = 1;

// Recherche de l'utilisateur avec l'ID saisi
for (let i = 0; i < donnees.utilisateurs.length; i++) {
    const element = donnees.utilisateurs[i];
    if (element.id == userId) {
        console.log("Utilisateur ",element.id," (connecté) : tags", element.tags);
    }
}



// Accès aux événements
for (let i = 0; i < donnees.evenements.length; i++) {
    const element = donnees.evenements[i];
    console.log("Evénement ",element.id," : tags", element.tags);
}


// Extraction des ID des utilisateurs
//const idsUtilisateurs = donnees.utilisateurs.map(user => user.id);
//console.log("IDs des utilisateurs : ", idsUtilisateurs);
const Ajout = function(choixAjout){
    // Instructions à exécuter
    if(choixAjout == ajoutUtilisateur){
        ajoutUtilisateur();
    }else{
        ajoutEvenement();
    }
};


  

const ajoutEvenement = function(){
    // Saisie des détails de l'événement à ajouter
    const titre = prompt("Entrez le titre de l'événement :");
    const date = prompt("Entrez la date de l'événement (YYYY-MM-DD) :");
    const heure = prompt("Entrez l'heure de l'évèenement (HH:MM) : ");
    const lieu = prompt("Entrez l'endroit où a lieu l'évènement (adresse ou coordonnées GPS) : ");
    let mots = [];
    let motsX ="";
    while(true){
        motsX = prompt("Entrez un tag de l'evenement (quit pour quitter): ");
        if (motsX == "quit") {
            break;
        }else{
            mots.push(motsX);
        }
    }
    let tags = []
    //ATTRIBUTION DES TAGS AVEC LES MOTS

    // Nouvel événement à ajouter
    const nouvelEvenement = {
        "id": donnees.evenements[donnees.evenements.length - 1].id + 1,
        "titre": titre,
        "date": date,
        "heure": heure,
        "lieu":lieu,
        "mots": mots,
        "tags": tags
    };

    // Ajouter le nouvel événement à la liste des événements existants
    donnees.evenements.push(nouvelEvenement);

    // Écrire les données mises à jour dans le fichier JSON
    fs.writeFileSync('donnees.json', JSON.stringify(donnees, null, 2), 'utf8');
    console.log("Événement ajouté avec succès !");
};

const ajoutUtilisateur = function(){
    // Saisie des détails de l'événement à ajouter
    let nom = prompt("Entrez votre nom : ");
    let mots = [];
    let motsX ="";
    while(true){
        motsX = prompt("Entrez un tag de l'utilisateur (quit pour quitter): ");
        if (motsX == "quit") {
            break;
        }else{
            mots.push(motsX);
        }
    }
    let tags = []
    //ATTRIBUTION DES TAGS AVEC LES MOTS

    // Nouvel événement à ajouter
    const nouvelUtilisateur = {
    "id": donnees.utilisateurs[donnees.utilisateurs.length - 1].id + 1,
    "nom":nom,
    "mots":mots,
    "tags": tags
    };

    // Ajouter le nouvel événement à la liste des événements existants
    donnees.utilisateurs.push(nouvelUtilisateur);

    // Écrire les données mises à jour dans le fichier JSON
    fs.writeFileSync('donnees.json', JSON.stringify(donnees, null, 2), 'utf8');
    console.log("Utilisateur ajouté avec succès !");
};

let choixAjout;
// Appel de la fonction : 1er argument = si true alors ajout d'un utilisateur
//Choix d'ajout
while (true) {
    let choix = prompt("Voulez-vous ajouter (o/n) : ");
    if (choix == "n") {
        break;
    } else {
        let typeAjout = prompt("Voulez-vous ajouter un utilisateur(0) ou un evenement(1) : ");
        if (typeAjout == 0) {
            choixAjout = ajoutUtilisateur;
        } else {
            choixAjout = ajoutEvenement;
        }
        Ajout(choixAjout);
    }
    
}
