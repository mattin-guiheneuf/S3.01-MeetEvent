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
 * @return tuple (dicoMotToTag,listeTag)
 """
def main():

    # VARIABLES
    dicoMotToTag = {}
    listeTag = []

    # TRAITEMENTS
    for motCourant in listeMot :
        if motCourant in dicoMotToTag.keys() : # Vérif mot en double
            print(motCourant + " déjà présent dans le dicoMotToTag")
            pass
        # Vérif présence dans dicoSynTag du mot
        if motCourant in dicoSynTag.keys() : # Si présence ajout et enregistrement
            dicoMotToTag[motCourant] = [dicoSynTag[motCourant]]
            listeTag.append(dicoSynTag[motCourant])
        else : # Sinon enrichissement de 1 degré à partir des mots
            listeSynMot = synAvecAPI(motCourant)['synonyms']
            for synMotCourant in listeSynMot :
                if synMotCourant in dicoSynTag.keys() : # Si présence ajout et enregistrement
                    dicoMotToTag[motCourant] = [synMotCourant,dicoSynTag[motCourant]]
                    listeTag.append(dicoSynTag[motCourant])
                else : # Sinon enrichissement de 1 degré supplémentaire (degré 2) à partir des tags
                    for syn in dicoSynTag.keys() :
                        listeSynSynDicoSynTag = synAvecAPI(syn)['synonyms']
                        if motCourant in listeSynSynDicoSynTag : # Vérif présence du mot de base dans les synonymes de synonymes de tag
                            dicoMotToTag[motCourant] = [syn,dicoSynTag[motCourant]]
                            listeTag.append(dicoSynTag[motCourant])
                        elif synMotCourant in listeSynSynDicoSynTag : # Vérif présence du synonyme du mot dans les synonymes de synonymes de tag
                            dicoMotToTag[motCourant] = [synMotCourant,syn,dicoSynTag[motCourant]]
                            listeTag.append(dicoSynTag[motCourant])
                        else : # Pas de liaison avec le corpus de tags
                            dicoMotToTag[motCourant] = ['Impossible à lier']
    
    print(dicoMotToTag)
    print(listeTag)
    
    return (dicoMotToTag,listeTag)


# DÉFINITION DES SOUS-PROGRAMMES
