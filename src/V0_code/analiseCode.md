# Analyse de Code JavaScript

## Importation des modules
Le code utilise les modules `fs` (opérations sur les fichiers) et `prompt-sync` (saisie utilisateur). Les données d'événements sont lues depuis le fichier `donnees.json` et converties en objet JavaScript.

## Création d'objets
Plusieurs classes d'objets sont définies (`Evenement`, `Utilisateur`, `Tag`, `Mot`, `Recommandation`) avec des attributs et des méthodes spécifiques.

## Initialisation
Un tableau `CorpusTag` est créé avec des libellés de tags. Des objets `Evenement` sont créés à partir des données JSON et stockés dans un tableau `objetEvenement`. Les tags des événements sont convertis en vecteurs binaires (`eventsAndUserPreferences`) en utilisant `CorpusTag`. Un objet `Utilisateur` représentant l'utilisateur connecté est créé.

## Traitement - ACM (Analyse de Correspondance Multiple)
Des fonctions pour calculer le produit scalaire, la norme et la similarité cosinus entre vecteurs sont définies. L'ACM est utilisée pour comparer les préférences de l'utilisateur avec les événements et générer une liste d'événements recommandés.

## Fonctions de vérification
Des fonctions (`afficherEventNB`, `afficherEventB`, etc.) semblent être prévues pour afficher des informations, mais elles ne sont pas implémentées dans le code fourni.

## Fonction de récupération d'événements recommandés
La fonction `recupererEvenements` filtre les événements avec une similarité supérieure ou égale à 0.7 et retourne une liste d'événements recommandés.

## Utilisation
La liste des événements recommandés est obtenue en appelant la fonction `ACM` et affichée à la fin du programme.

