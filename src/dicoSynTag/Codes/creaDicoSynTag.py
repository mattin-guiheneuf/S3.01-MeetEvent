"""
 * @file creaDicoSynTag.py
 * @author Clément MOURGUE
 * @brief Code respectant l'algorithme de création du dictionnaire dicoSynTag
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

# TYPES
"""
 * @brief Une chaîne de caractères correspondant à un synonyme.
 * 
 """
#typedef string Synonyme;

"""
 * @brief Une chaîne de caractères correspondant à un tag.
 * 
 """
 #typedef string Tag;

"""
 * @brief Un dictionnaire associant un Synonyme à un liste de tags.
 * 
 """
#typedef map<Synonyme,list<Tag>> DicoSynonymesTags;

# VARIABLES GLOBALES
"""
 * @brief Le corpus de tag définit par l'équipe. Il sera une constante une fois définie.
 * 
 """
CORPUS_TAG = ['mother','father']#['cat','dog','rugby','sport','wing','plane']

"""
 * @brief Le dictionnaire associant des synonymes de tags avec leur tag.
 * 
 """
dicoSynTag = {}

# DÉCLARATION DES SOUS-PROGRAMMES


# PROGRAMME PRINCIPAL
"""
 * @brief Le programme principal créant le dictionnaire dicoSynTag
 * 
 * @return int = 0
 """
def main():

    # VARIABLES
    

    # TRAITEMENTS
    # Ajout des tags au dicoSynTag pour qu'ils soient également détectés
    for tagCourant in CORPUS_TAG :
        dicoSynTag[tagCourant] = [tagCourant]
    
    # Enrichissement au premier degré du dictionnaire avec les synonymes des tags
    for tagCourant in CORPUS_TAG :
        listeSynTagCourant = synAvecAPI(tagCourant)['synonyms']
        for synTagCourant in listeSynTagCourant :
            if synTagCourant in dicoSynTag.keys() :
                if tagCourant not in dicoSynTag[synTagCourant] :
                    dicoSynTag[synTagCourant].append(tagCourant)
            else :
                dicoSynTag[synTagCourant] = [tagCourant]
    
    print(dicoSynTag)
    
    return dicoSynTag


# DÉFINITION DES SOUS-PROGRAMMES
