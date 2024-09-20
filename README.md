# RESTAPI

**restapi** est une solution PHP conçue pour tout développeur souhaitant une API totalement gratuite, permettant d'effectuer des opérations CRUD (Créer, Lire, Mettre à jour, Supprimer) gratuitement pendant 3 mois.

## Fonctionnalités

- **CRUD complet** : Créez, lisez, mettez à jour et supprimez des enregistrements facilement.
- **Prix** : Profitez de toutes les fonctionnalités gratuitement pendant une période de 3 mois.
- **Facile à utiliser** : Documentation claire et API intuitive pour une intégration rapide.

## Prérequis

- PHP 7.4 ou supérieur
- Serveur web (Apache, Nginx, etc.)
- Base de données JSON files
- Base de données MySQL (pour une version ultérieure)

## Installation

1. Clonez le dépôt :
    ```bash
    git clone https://github.com/codprox/restapi.git
    ```

2. Déplacez le répertoire du projet sur votre serveur :
    ```bash
    cd restapi
    ```

3. Pas de dépendances nécessaires : 

4. Si vous souhaitez apporter vos configurations, éditez le fichier `_wZ526jbTU5Zar6c93ER4_.php` :

## Utilisation

### URL du serveur

- **URL du serveur** : https://restapi.biz
- **Key du serveur** : rqXJ28773mJsau3D8EzzjCT3m4GrKi42YLD33Ab4

### Étape 1 : Créer votre profil

Requête POST : `[URL_SERV]/rqXJ28773mJsau3D8EzzjCT3m4GrKi42YLD33Ab4/profile`

Avec les paramètres minimum suivants :
```json
{
    "login": "armandmouele@gmail.com",
    "password": "123456789",
    "name": "Armand MOUELE",
    "telephone": "077010203"
}
```

À la suite de cette opération de création de profil (ou de compte), vous recevrez votre access_token qui vous permettra de faire toutes vos requêtes

### Étape 2 : Requêtes C.R.U.D.

- **GET /VOTRE_ACCESS_TOKEN/collection** : Récupère toutes les données de la collection.
- **GET /VOTRE_ACCESS_TOKEN/collection/{id}** : Récupère un item de la collection par son ID.
- **POST /VOTRE_ACCESS_TOKEN/collection** : Crée un nouvel item dans la collection.
- **PUT /VOTRE_ACCESS_TOKEN/collection/{id}** : Met à jour un item de la collection par son ID.
- **DELETE /VOTRE_ACCESS_TOKEN/collection/{id}** : Supprime un item de la collection par son ID.


### Exemples de requête

Pour récupérer la liste de toutes les catégories (ou une seule catégorie), envoyez une requête GET à :
``` 
    http://restapi.biz/8a1afb0d-0530-4f38-9441-47e1c093fcfd/categories
    http://restapi.biz/8a1afb0d-0530-4f38-9441-47e1c093fcfd/categories/5?page=1&limit=10
```

Il est également possible de faire des jointures entre table. Exemple : pour la table produits(id,title,categories_id,clients_id), voici une jointure :
``` 
    http://restapi.biz/8a1afb0d-0530-4f38-9441-47e1c093fcfd/produits
    http://restapi.biz/8a1afb0d-0530-4f38-9441-47e1c093fcfd/produits/5?page=1&limit=10&isActive=true&join=categories,clients
```

Pour créer une nouvelle catégorie, envoyez une requête POST à `/categories` avec le corps suivant :
http://restapi.biz/8a1afb0d-0530-4f38-9441-47e1c093fcfd/categories
```json
{
    "title": "Titre de la catégorie",
    "description": "Description de la catégorie"
}
```

Pour mettre à jour une catégorie (et même ajouter librement d'autres colonnes comme du NoSQL), envoyez une requête PUT à `/categories/ID` avec le corps suivant :
```http://restapi.biz/8a1afb0d-0530-4f38-9441-47e1c093fcfd/categories/5
```
```json
{
    "title": "Titre de la catégorie",
    "description": "Description de la catégorie",
    "icone":"home_icon",
    "isActive":true
}
```

Pour supprimer toutes les catégories (ou une seule catégorie), envoyez une requête DELETE à :
``` 
    http://restapi.biz/8a1afb0d-0530-4f38-9441-47e1c093fcfd/categories
    http://restapi.biz/8a1afb0d-0530-4f38-9441-47e1c093fcfd/categories/5
```


Support
Pour toute question ou assistance, veuillez ouvrir une issue sur le dépôt GitHub ou contactez le développeur à armandmoueleprofessionnel@gmail.com

Licence
Ce projet est sous licence MIT. Voir le fichier LICENSE pour plus de détails.