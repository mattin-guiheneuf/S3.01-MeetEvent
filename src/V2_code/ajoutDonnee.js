/*
 * Nom du fichier : ajoutDonnee.js
 * Description : Ce fichier contient des fonctionnalités permettant d'ajouter un utilisateur ou un événement.
 * Auteur : Duvignau Yannis
 * Date de création : 17 décembre 2023
 * Dernière mise à jour : 17 décembre 2023
 * Copyright (c) 2023, MeetEvent
 */

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


//CREATION D'UN TYPE ENUM POUR LE CHOIX DE L'AJOUT
const typeAjout={
    ajoutUtilisateur : 1,
    ajoutEvenement : 2
}

//____________________________________________________________________________________//
//____________________________________________________________________________________//
//                                                                                    //
//                                     TRAITEMENT                                     //
//                                                                                    //
//____________________________________________________________________________________//
//____________________________________________________________________________________//


// Extraction des ID des utilisateurs
//const idsUtilisateurs = donnees.utilisateurs.map(user => user.id);
//console.log("IDs des utilisateurs : ", idsUtilisateurs);

//Fonction qui détermine le choix de l'ajout
const Ajout = function(choixAjout){
    // Instructions à exécuter
    if(choixAjout == ajoutUtilisateur){
        ajoutUtilisateur();
    }else{
        ajoutEvenement();
    }
};

//Fonction qui implémente choix de l'ajout d'un Evenement
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

//Fonction qui implémente choix de l'ajout d'un Utilisateur
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


//SAISIE UTILISATEUR
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