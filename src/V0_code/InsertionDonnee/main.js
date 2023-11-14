const fs = require('fs'); // Nécessaire pour la lecture du fichier (environnement Node.js)
const prompt = require('prompt-sync')();
const contenuJSON = fs.readFileSync('donnees.json');
const donnees = JSON.parse(contenuJSON);


// Saisie de l'ID utilisateur à rechercher
const userId = 2;

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
const Ajout = function(utilisateur){
    // Instructions à exécuter
    if(utilisateur == true){
        ajoutUtilisateur();
    }else{
        ajoutEvenement();
    }
};


  

const ajoutEvenement = function(){
    // Saisie des détails de l'événement à ajouter
    const titre = prompt("Entrez le titre de l'événement :");
    const date = prompt("Entrez la date de l'événement (YYYY-MM-DD) :");
    let tags = [];
    let tagsX ="";
    while(true){
        tagsX = prompt("Entrez un tag de l'evenement (quit pour quitter): ");
        if (tagsX == "quit") {
            break;
        }else{
            tags.push(tagsX);
        }
    }
    // Nouvel événement à ajouter
    const nouvelEvenement = {
    "id": donnees.evenements[donnees.evenements.length - 1].id + 1,
    "tags": tags,
    "titre": titre,
    "date": date
    };

    // Ajouter le nouvel événement à la liste des événements existants
    donnees.evenements.push(nouvelEvenement);

    // Écrire les données mises à jour dans le fichier JSON
    fs.writeFileSync('donnees.json', JSON.stringify(donnees, null, 2), 'utf8');
    console.log("Événement ajouté avec succès !");
};

const ajoutUtilisateur = function(){
    // Saisie des détails de l'événement à ajouter
    let tags = [];
    let tagsX ="";
    while(true){
        tagsX = prompt("Entrez un tag de l'utilisateur (quit pour quitter): ");
        if (tagsX == "quit") {
            break;
        }else{
            tags.push(tagsX);
        }
    }
    // Nouvel événement à ajouter
    const nouvelUtilisateur = {
    "id": donnees.utilisateurs[donnees.utilisateurs.length - 1].id + 1,
    "tags": tags
    };

    // Ajouter le nouvel événement à la liste des événements existants
    donnees.utilisateurs.push(nouvelUtilisateur);

    // Écrire les données mises à jour dans le fichier JSON
    fs.writeFileSync('donnees.json', JSON.stringify(donnees, null, 2), 'utf8');
    console.log("Utilisateur ajouté avec succès !");
};


// Appel de la fonction : 1er argument = si true alors ajout d'un utilisateur
Ajout(false);