"""
 * @file motToTag.py
 * @author Clément MOURGUE
 * @brief Code respectant l'algorithme d'association des mots aux tags
 * @version 1.0
 * @date 2023-11-15
"""

# INCLUSIONS
# API
import requests
def url(wordToSearch):
    if type(wordToSearch) != str :
        raise TypeError("The word has to be a str type.")
    urlToComplete = "https://wordsapiv1.p.rapidapi.com/words/"
    urlToComplete += wordToSearch
    urlToComplete += "/synonyms"
    return urlToComplete

headers = {
"X-RapidAPI-Key": "f59a2efa60msha84f78f61a68ddap12ca6djsnadb8f76a8e62",
"X-RapidAPI-Host": "wordsapiv1.p.rapidapi.com"
}

def synAvecAPI(word):
    res = requests.get(url(word), headers=headers)
    #print(res.json())
    return res.json()

# VARIABLES GLOBALES
CORPUS_TAG = ['mother','father']#['cat','dog','rugby','sport','wing','plane']

import creaDicoSynTag
dicoSynTag = creaDicoSynTag.main()

listeMot = ['female parent','get']


# PROGRAMME PRINCIPAL
"""
 * @brief Le programme principal créant le dictionnaire dicoSynTag
 * 
 * @return int = 0
 """
def main():

    # VARIABLES
    dicoMotToTag = {}
    listeTag = []

    # TRAITEMENTS
    for motCourant in listeMot :
        listeSynMot = synAvecAPI(motCourant)['synonyms']
        for synMotCourant in listeSynMot :
            if synMotCourant in dicoSynTag :
                
    
    return 0


# DÉFINITION DES SOUS-PROGRAMMES
