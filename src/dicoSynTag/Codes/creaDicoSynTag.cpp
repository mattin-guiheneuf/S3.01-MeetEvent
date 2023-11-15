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

// DÉCLARATION DES SOUS-PROGRAMMES
/**
 * @brief 
 * 
 */
void ajoutTagToDico();


// PROGRAMME PRINCIPAL
/**
 * @brief Le programme principal créant le dictionnaire dicoSynTag
 * 
 * @return int 0
 */
int main(){

    // VARIABLES
    DicoSynonymesTags dicoSynTag;
    std::list<Tag>::iterator iterateurTag = CORPUS_TAG.begin();

    // TRAITEMENTS
    // Ajout des tags au dicoSynTag
    for_each(CORPUS_TAG.begin(),CORPUS_TAG.end(),ajoutTagToDico);
    


    return 0;
}

// DÉFINITION DES SOUS-PROGRAMMES