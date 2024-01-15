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