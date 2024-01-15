"""
Tri des mots fr
"""

import pandas as pd

def initialisation():
    fic = pd.read_csv(r"motsFr.csv",
                      sep=";",
                      encoding="latin_1")

    res = []
    
    colonneMot = 0
    for iMot in range (0,len(fic)):
        if fic.iloc[iMot,colonneMot] not in res :
            res.append(fic.iloc[iMot,colonneMot])
    return res

listeMotFr = initialisation()

pd.DataFrame(listeMotFr).to_csv("motsFrTries.csv",sep=";",encoding='utf-8', index=False)

def checkAppartenance(listeMots,listeACheck):
    res={}
    for mot in listeMots :
        if mot in listeACheck :
            res[mot] = True
        else :
            res[mot] = False
    return res

listeMotTest = ['chaise','nature','bowling','zoo','ami','famille','amis','chocolatine','pizza','pelote','rugby','zizi','cramptés']

test = checkAppartenance(listeMotTest, listeMotFr)

# Pour vérifier le bon encodage
listeMotsFrFromCsv = pd.read_csv(r"motsFrTries.csv",
                  sep=";",
                  encoding="latin_1")

def saisieVerif():
    global listeMotFr
    saisie = input("Veuillez saisir un mot ou une liste de mot qui vous caractérise : ")
    if ',' in saisie :
        listeMot = saisie.split(',')
        for i in range(0,len(listeMot)) :
            listeMot[i] = listeMot[i].strip()
        # Enlever les espaces vides si jamais
        while('' in listeMot):
            listeMot.remove('')
        res = checkAppartenance(listeMot, listeMotFr)
    elif ';' in saisie :
        listeMot = saisie.split(';')
        for i in range(0,len(listeMot)) :
            listeMot[i] = listeMot[i].strip()
        # Enlever les espaces vides si jamais
        while('' in listeMot):
            listeMot.remove('')
        res = checkAppartenance(listeMot, listeMotFr)
    else :
        listeMot = saisie.split(' ')
        for i in range(0,len(listeMot)) :
            listeMot[i] = listeMot[i].strip()
        # Enlever les espaces vides si jamais
        while('' in listeMot):
            listeMot.remove('')
        # Check appartenance
        res={}
        passer = False
        for i in range (0,len(listeMot)-1) : # Au cas où il y ai des mots composé
            if passer :
                passer = False
                pass
            else :
                if listeMot[i]+" "+listeMot[i+1] in listeMotFr :
                    res[listeMot[i]+" "+listeMot[i+1]] = True
                    passer = True
                elif listeMot[i] in listeMotFr :
                    res[listeMot[i]] = True
                else :
                    res[listeMot[i]] = False
        if listeMot[len(listeMot)-1] in listeMotFr : # vérif du dernier mot
            res[listeMot[len(listeMot)-1]] = True
        else :
            res[listeMot[len(listeMot)-1]] = False
        
    print(listeMot)
    
    return res