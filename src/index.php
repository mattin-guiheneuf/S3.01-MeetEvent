<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test PHP</title>

    <!--
        Nom du fichier : index.html
        Description : Cette page contient un formulaire de similation d'utilisateur connecté.
        Auteur : Duvignau Yannis
        Date de création : 17 décembre 2023
        Dernière mise  jour : 17 décembre 2023
        Copyright (c) 2023, MeetEvent
    -->

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #333;
        }

        form {
            margin: 20px;
            display: inline-block;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            margin: 50px;
        }

        button:hover {
            background-color: #45a049;
        }

        h2 {
            color: #45a049;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <h1>Tester le code PHP</h1>
    <hr>
    <h2>Simuler la suggestion d'événement</h2>
    <!-- Formulaire avec champ pour saisir l'ID de l'utilisateur -->
    <form action="main.php" method="post">
        <label for="idUser">ID de l'utilisateur :</label>
        <input type="text" id="idUser" name="idUser" required>
        <button type="submit" name="action" value="afficherRecommandations">Afficher les événements recommandés</button>
    </form>
    <hr>
    <h2>Créer un Utilisateur</h2>
    <!-- Formulaire avec champ pour saisir l'inscription d'un utilisateur -->
    <form action="main.php" method="post">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>
    
        <label for="mot">Mot :</label>
        <input type="text" id="mot" name="mot">
        <button type="button" onclick="ajouterMot()">Ajouter</button>
        <div id="listeMots"></div>
    
        <input type="hidden" id="motsListeInput" name="motsListe" value="">
    
        <button type="submit" name="action" value="creerUtilisateur">Création d'un utilisateur</button>
    </form>
    <hr>
    <h2>Créer un Evenement</h2>
    <!-- Formulaire avec champ pour saisir l'inscription d'un utilisateur -->
    <form action="main.php" method="post">
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre">

        <label for="date">Date :</label>
        <input type="text" id="date" name="date">

        <label for="heure">Heure :</label>
        <input type="text" id="heure" name="heure">

        <label for="lieu">Lieu :</label>
        <input type="text" id="lieu" name="lieu">

        <label for="motEvenement">Mot :</label>
        <input type="text" id="motEvenement" name="motEvenement">
        <button type="button" onclick="ajouterMotEvenement()">Ajouter</button>
        <div id="listeMotsEvenement"></div>

        <input type="hidden" id="motsListeEvenementInput" name="motsListeEvenement" value="">

        <button type="submit" name="action" value="creerEvenement">Création d'un événement</button>
    </form>

	<?php 
        // Récupération du dicoMotsFr pour la saisieVerif des mots
        $jsonDicoMotsFr = file_get_contents('./data/motsFr.json');
        $dicoMotsFr = json_decode($jsonDicoMotsFr, true);
    ?>
    <script>
        var motsListe = [];
        var motsListeEvenement = [];
        var listeMotsFr = <?php echo $jsonDicoMotsFr; ?>;

        function saisieVerif(mot){
            return listeMotsFr.indexOf(mot) != -1; // mot in listeMotsFr
        }

        function ajouterMot() {
            var motSaisi = document.getElementById('mot').value.trim().toLowerCase();
            if(saisieVerif(motSaisi)){
                if (motSaisi !== '') {
                    motsListe.push(motSaisi);
                    afficherListeMots();
                    document.getElementById('mot').value = ''; // Efface le champ après ajout
                } else {
                    alert('Veuillez saisir un mot.');
                }
            }
            else {
                alert("Mot invalide, veuillez saisir un autre mot...");
            }
        }

        function afficherListeMots() {
            var listeMotsDiv = document.getElementById('listeMots');
            listeMotsDiv.innerHTML = '<p><strong>Liste de mots ajoutés :</strong></p>';
            for (var i = 0; i < motsListe.length; i++) {
                listeMotsDiv.innerHTML += '<p>' + motsListe[i] + '</p>';
            }

            // Mettre à jour la valeur de l'input caché avec la liste de mots
            document.getElementById("motsListeInput").value = JSON.stringify(motsListe);
    
        }

        function ajouterMotEvenement() {
            var motSaisi = document.getElementById('motEvenement').value.trim();
			if(saisieVerif(motSaisi)){
				if (motSaisi !== '') {
					motsListeEvenement.push(motSaisi);
					afficherListeMotsEvenement();
					document.getElementById('motEvenement').value = ''; 
				} else {
					alert('Veuillez saisir un mot.');
				}
			}
			else {
				alert("Mot invalide, veuillez saisir un autre mot...");
            }
        }

        function afficherListeMotsEvenement() {
            var listeMotsDiv = document.getElementById('listeMotsEvenement');
            listeMotsDiv.innerHTML = '<p><strong>Liste de mots ajoutés :</strong></p>';
            for (var i = 0; i < motsListeEvenement.length; i++) {
                listeMotsDiv.innerHTML += '<p>' + motsListeEvenement[i] + '</p>';
            }

            document.getElementById('motsListeEvenementInput').value = JSON.stringify(motsListeEvenement);
        }
    </script>

</body>

</html>