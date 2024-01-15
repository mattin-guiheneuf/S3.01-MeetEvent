/**
 * @file creaDicoSynTag.cpp
 * @author Clément MOURGUE
 * @brief Code respectant l'algorithme de création du dictionnaire dicoSynTag
 * @version 1.0
 * @date 2023-11-15
 * 
 */

// INCLUSIONS
#include <iostream>
using namespace std;

#include <string>
#include <list>
#include <map>
#include <algorithm>

// TYPES
/**
 * @brief Une chaîne de caractères correspondant à un synonyme.
 * 
 */
typedef string Synonyme;

/**
 * @brief Une chaîne de caractères correspondant à un tag.
 * 
 */
typedef string Tag;

/**
 * @brief Un dictionnaire associant un Synonyme à un liste de tags.
 * 
 */
typedef map<Synonyme,list<Tag>> DicoSynonymesTags;

// VARIABLES GLOBALES
/**
 * @brief Le corpus de tag définit par l'équipe. Il sera une constante une fois définie.
 * 
 */
/* const */ list<Tag> CORPUS_TAG;

/**
 * @brief Le dictionnaire associant des synonymes de tags avec leur tag.
 * 
 */
DicoSynonymesTags dicoSynTag;

// DÉCLARATION DES SOUS-PROGRAMMES
/**
 * @brief Ajoute le tag fourni en argument au dictionnaire dicoSynTag de manière symétrique { tag : tag ;}
 * 
 * @param [in] t le tag à ajouter
 * 
 */
void ajoutSymTagToDicoSynTag(Tag t);

/**
 * @brief Renvoie la liste des synonymes du mot fourni en argument
 * 
 * @param [in] mot 
 * @return list<string>
 */
list<string> synAvecAPI(string mot);


// PROGRAMME PRINCIPAL
/**
 * @brief Le programme principal créant le dictionnaire dicoSynTag
 * 
 * @return int = 0
 */
int main(){

    // VARIABLES
    /**
     * @brief L'iterateur permettant de manipuler le corpus de tag
     * 
     */
    std::list<Tag>::iterator iterateurTag = CORPUS_TAG.begin();

    // TRAITEMENTS
    // Ajout des tags au dicoSynTag pour qu'ils soient également détectés
    for_each(CORPUS_TAG.begin(),CORPUS_TAG.end(),ajoutSymTagToDicoSynTag);
    
    // Enrichissement au premier degré du dictionnaire avec les synonymes des tags


    return 0;
}

// DÉFINITION DES SOUS-PROGRAMMES
void ajoutSymTagToDico(Tag t)
{
    DicoSynonymesTags::mapped_type attribut;
    attribut.push_back(t);
    DicoSynonymesTags::key_type cle = t;
    dicoSynTag.insert({cle,attribut});
}