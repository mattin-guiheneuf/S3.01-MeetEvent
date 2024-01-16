# -*- coding: utf-8 -*-
"""
Created on Sat Dec 16 13:35:41 2023

@author: duvig_
"""

# Votre JSON
votre_json = {
    "utilisateurs": [
      {
        "id": 1,
        "nom": "",
        "mots": [],
        "tags": [
          "musique",
          "voyage",
          "lecture",
          "jeux"
        ]
      },
      {
        "id": 2,
        "nom": "",
        "mots": [],
        "tags": [
          "musique",
          "festival",
          "sport",
          "jeux"
        ]
      }
    ],
    "evenements": [
      {
        "id": 10001,
        "titre": "Festival de musique en plein air",
        "date": "2023-08-20",
        "heure": "15:30",
        "lieu": "",
        "mots": [],
        "tags": [
          "musique",
          "festival",
          "sport"
        ]
      },
      {
        "id": 10002,
        "titre": "Concert choeurs basques",
        "date": "2023-11-19",
        "heure": "15:30",
        "lieu": "Salle commune de Anglet",
        "mots": [],
        "tags": [
          "Chant",
          "Culture",
          "Musique",
          "Concert"
        ]
      },
      {
        "id": 10003,
        "titre": "Repas sanglier ACCA",
        "date": "2023-11-24",
        "heure": "15:30",
        "lieu": "Salle Camiade",
        "mots": [
          
        ],
        "tags": ["Repas",
          "Charcuterie",
          "Viande",
          "Aperitif",
          "Vin",
          "Banquet",
          "Festin",
          "Association",
          "Ambiance"
        ]
      },
      {
        "id": 10004,
        "titre": "Cercle des lecteurs",
        "date": "2023-12-02",
        "heure": "15:30",
        "lieu": "Bibliotheque",
        "mots": [
          
        ],
        "tags": ["Echange",
          "Lecture",
          "Discussion",
          "Cafe",
          "Partage",
          "Rencontre",
          "Livre",
          "Culture"]
      },
      {
        "id": 10005,
        "titre": "Seance de Sport - Seniors",
        "date": "2023-15-12",
        "heure": "15:30",
        "lieu": "espace Jean Rameau",
        "mots": [
          
        ],
        "tags": ["Sport",
          "Renforcement musculaire",
          "Activite physique",
          "Seniors",
          "Course",
          "Entrainement"]
      },
      {
        "id": 10006,
        "titre": "Randonnee - Seniors",
        "date": "2023-12-22",
        "heure": "15:30",
        "lieu": "espace jean Rameau",
        "mots": [
          
        ],
        "tags": ["Randonnee",
          "Marche",
          "Seniors",
          "Entrainement",
          "Balade"]
      },
      {
        "id": 10007,
        "titre": "Match de Futsal",
        "date": "2023-12-15",
        "heure": "15:30",
        "lieu": "Club 64",
        "mots": [
          
        ],
        "tags": ["Sport",
          "Futsal",
          "Football",
          "Match",
          "Amical",
          "Plaisir"]
      },
      {
        "id": 10008,
        "titre": "Soiree Jeu de societe",
        "date": "2023-11-28",
        "heure": "15:30",
        "lieu": "Foyer Rural",
        "mots": [
          
        ],
        "tags": ["Jeu de societe",
          "Amusement",
          "Convivialite",
          "culture",
          "jeu de cartes",
          "Jeu de Plateau"]
      },
      {
        "id": 10009,
        "titre": "Soiree Hunger Games",
        "date": "2023-11-14",
        "heure": "15:30",
        "lieu": "cinema L'Estade a Sabres",
        "mots": [
          
        ],
        "tags": ["Cinema",
          "culture",
          "Film",
          "Hunger Games",
          "Convivialite"]
      },
      {
        "id": 10010,
        "titre": "Soiree Jazz et Blues",
        "date": "2023-12-07",
        "heure": "15:30",
        "lieu": "salle Communales de Labrit",
        "mots": [
          
        ],
        "tags": ["Musique",
          "Jazz",
          "Blues",
          "Soiree",
          "Ambiance",
          "Detente"]
      },
      {
        "id": 10011,
        "titre": "Randonnee en Montagne",
        "date": "2024-01-20",
        "heure": "15:30",
        "lieu": "pied de la Rhune",
        "mots": [
          
        ],
        "tags": ["Randonnee",
          "Montagne",
          "Aventure",
          "Nature",
          "Paysages",
          "Balade"]
      },
      {
        "id": 10012,
        "titre": "Activite de cuisine italienne",
        "date": "2024-02-15",
        "heure": "15:30",
        "lieu": "Etablissement Ferrandi a Bordeaux",
        "mots": [
          
        ],
        "tags": ["Cuisine",
          "Italie",
          "Atelier",
          "Decouverte",
          "Pratique",
          "Creation",
          "Gastronomie"]
      },
      {
        "id": 10013,
        "titre": "visite de la cite du vin",
        "date": "2024-03-16",
        "heure": "15:30",
        "lieu": "Cite du Vin a Bordeaux",
        "mots": [
          
        ],
        "tags": ["Vin",
          "Decouverte",
          "Culture",
          "Oenologie",
          "Degustation",
          "Exposition",
          "Musee"]
      },
      {
        "id": 10014,
        "titre": "Diner de Gala pour une association",
        "date": "2024-01-05",
        "heure": "15:30",
        "lieu": "Grand Hotel",
        "mots": [
          
        ],
        "tags": ["Diner",
          "Association",
          "Caritatif",
          "Gastronomie",
          "Solidarite",
          "Echange"]
      },
      {
        "id": 10015,
        "titre": "Festival de l'omelette",
        "date": "2024-04-01",
        "heure": "15:30",
        "lieu": "place de la Mairie",
        "mots": [
          
        ],
        "tags": ["Gastronomie",
          "Fete",
          "Omelette",
          "Terroir",
          "Ambiance"]
      },
      {
        "id": 10016,
        "titre": "Loto et Bingo pour une association",
        "date": "2024-09-23",
        "heure": "15:30",
        "lieu": "Complexe Sportif de Socoa",
        "mots": [
          
        ],
        "tags": ["Loto",
          "Bingo",
          "Association",
          "Charite",
          "Jeu de Societe",
          "Seniors",
          "Buvette"]
      },
      {
        "id": 10017,
        "titre": "Herri Urrats",
        "date": "2024-05-14",
        "heure": "15:30",
        "lieu": "Lac de Saint Pee sur Nivelle",
        "mots": [
          
        ],
        "tags": ["Fete",
          "Buvette",
          "Pays Basque",
          "Concert",
          "Solidarite"]
      },
      {
        "id": 10018,
        "titre": "Tournois de Tenis",
        "date": "2024-03-23",
        "heure": "15:30",
        "lieu": "Courts de Tennis Municipaux",
        "mots": [
          
        ],
        "tags": ["Sport",
          "Tennis",
          "Raquette",
          "Loisir",
          "Competition",
          "Tournoi"]
      },
      {
        "id": 10019,
        "titre": "Concert en plein air",
        "date": "2024-08-17",
        "heure": "15:30",
        "lieu": "Vieux Port",
        "mots": [
          
        ],
        "tags": ["Musique",
          "Concert",
          "Festival",
          "Plein Air",
          "Divertissement",
          "Culture"]
      },
      {
        "id": 10020,
        "titre": "Conference sur l'economie",
        "date": "2024-01-19",
        "heure": "15:30",
        "lieu": "Salle Camiade",
        "mots": [
          
        ],
        "tags": ["Conference",
          "Economie",
          "Finance",
          "Argent",
          "Echange",
          "Investissement",
          "Formation"]
      },
      {
        "id": 10021,
        "titre": "Concert en plein air",
        "date": "2024-08-17",
        "heure": "15:30",
        "lieu": "Vieux Port",
        "mots": [
          
        ],
        "tags": [
          "musique",
          "jeux",
          "Musique",
          "Concert",
          "Festival",
          "Plein Air",
          "Divertissement",
          "Culture"
        ]
      },
      {
        "id": 10022,
        "titre": "Conference sur l'economie",
        "date": "2024-01-19",
        "heure": "15:30",
        "lieu": "Salle Camiade",
        "mots": [
          
        ],
        "tags": ["Conference",
          "Economie",
          "Finance",
          "Argent",
          "Echange",
          "Investissement",
          "Formation"]
      }
    ]
  }

# Fonction pour extraire les tags uniques
def extraire_tags_uniques(data):
    tags_uniques = set()

    for categorie, elements in data.items():
        for element in elements:
            tags_uniques.update(element.get("tags", []))

    return list(tags_uniques)

# Appel de la fonction avec votre JSON
tags_uniques = extraire_tags_uniques(votre_json)

# Affichage des tags uniques
print(tags_uniques)


#######################################################################
import random

# Corpus de tags actuel global (à remplacer par votre propre corpus)
corpus_tags = [
    "musique", "voyage", "lecture", "jeux",
    "festival", "sport", "Chant", "Culture",
    "Concert", "Repas", "Charcuterie", "Viande",
    "Aperitif", "Vin", "Banquet", "Festin",
    "Association", "Ambiance", "Echange", "Lecture",
    "Discussion", "Cafe", "Partage", "Rencontre",
    "Livre", "Renforcement musculaire", "Activite physique",
    "Seniors", "Course", "Entrainement", "Randonnee",
    "Marche", "Balade", "Football", "Match", "Amical",
    "Plaisir", "Jeu de societe", "Amusement", "Convivialite",
    "culture", "jeu de cartes", "Jeu de Plateau", "Film",
    "Hunger Games", "Jazz", "Blues", "Soiree", "Detente",
    "Nature", "Paysages", "Cuisine", "Italie", "Atelier",
    "Decouverte", "Pratique", "Creation", "Gastronomie",
    "Oenologie", "Degustation", "Exposition", "Musee",
    "Diner", "Caritatif", "Solidarite", "Fete", "Omelette",
    "Terroir", "Buvette", "Tennis", "Raquette", "Loisir",
    "Competition", "Tournoi", "Plein Air", "Divertissement",
    "Finance", "Argent", "Investissement", "Formation"
]

# Fonction pour créer un utilisateur au hasard avec des mots du corpus de tags
def creer_utilisateur_au_hasard(corpus_tags):
    utilisateur = {
        "id": random.randint(100, 999),
        "nom": f"Utilisateur{random.randint(1, 100)}",
        "mots": "",
        "tags": random.sample(corpus_tags, random.randint(1, 10))
    }
    return utilisateur

# Création de 5 utilisateurs au hasard
utilisateurs_au_hasard = [creer_utilisateur_au_hasard(corpus_tags) for _ in range(5)]

# Affichage des utilisateurs au hasard
for utilisateur in utilisateurs_au_hasard:
    print(utilisateur)

