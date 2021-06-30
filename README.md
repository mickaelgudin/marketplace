# Marketplace - avec plusieurs base de données

[![Watch the video](https://user-images.githubusercontent.com/39730173/123625648-4003cf80-d810-11eb-9075-31b89945c125.mp4)](https://user-images.githubusercontent.com/39730173/123625648-4003cf80-d810-11eb-9075-31b89945c125.mp4)

## Le technos et leur configuration dans le projet
- Redis : en utilisant les fonctionnalités de cache du Framework CodeIgniter (au niveau de app/Config/Cache.php Predis est configuré comme handler de cache)
- Elasticsearch : en faisant des appels api via javascript (pour les Views panier.php et catalogue.php)
- Mongodb : avec une instance locale, en utilisant le Controller Mongodb.php (en se basant sur le code sur repo : https://github.com/intekhabrizvi/codeigniter-mongodb-library)

## Lancement du projet
- git pull du projet (si le zip est téléchargé merci de bien nommer le dossier marketplace)
- Dans le répétoire elastic search de votre machine, allez dans config/elasticsearch.yml et ajouter les config suivantes : 
```
http.cors.enabled : true
http.cors.allow-origin: "*"
http.cors.allow-methods: OPTIONS, HEAD, GET, POST, PUT, DELETE
http.cors.allow-headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers
http.cors.allow-credentials: true
```
- le driver mongodb doit être installé au niveau de wamp
- le projet doit être dans le répertoire www de wamp
- Exécuter la commande suivante à la racine du projet : `composer install`
- Lancer les bases de données (soit manuellement soit en utilisant le script launch-database.bat *à condition de modifier les chemins dans le fichier*)
- Exécuter les requêtes pour mongodb (**les commandes mongodb sont dans le fichier ajout_des_collections.txt**)
- Exécuter les requêtes pour elasticsearch via postman (**les requetes http sont dans le fichier elasticSearch.txt**)
- Dans la console redis-cli taper `CONFIG SET requirepass password`
- Dans la consle redis-cli taper `AUTH password`
- Dans un navigateur(chrome de préférence pour le js implétementé) aller sur la page d'accueil : http://localhost/marketplace/public/
- Vous pouvez vous connecter avec l'utilisateur par défault(créer dans mongodb)
```
Email : test@test.fr
mot de passe : test 
```
- Vous pouvez créer un compte et vous connecter avec

## L'utilisation des bases de données
- Les appels http avec javascript permettent d'afficher les données d'elastic search sans rafraichir la page, de plus plusieurs rêquetes peuvent être effectuées (recherche d'un nom, filtre sur un intervalle de prix, tri par nom et prix croissant ou décroissant)
![Alt text](/screenshots/catalogue.png?raw=true)
- Elastic search permet de vérifier si la quantité désirée est suffisante par le client quand il clique sur + pour un produit dans le panier (un appel http est fait en js si tout se passe bien php ajoute la quantité désirée, sinon une erreur est affichée à l'utilisateur)
![Alt text](/screenshots/quantite_insuffisante.png?raw=true)
- Lorsqu'on clique sur le bouton Commander dans le panier, on traduit le panier présent dans Redis en Commande et Ligne de commande dans MongoDb en faisant une gestion des cas d'erreurs
- Redis est central il permet d'accèder à l'utilisateur connecté (pour l'associer à une commande), ou pour l'afficher dans le menu

## Gestion d'erreur
- Le maximum de cas d'erreur est géré au niveau php(une nouvelle commande n'a pas inséré dans mongodb, utilisateur pas connecté essayant d'accèder au(x): catalogue, commandes ou panier)
- Au niveau javascript pour le catalogue, on fait en sorte que l'utilisateur ne puisse pas entrer une quantité supérieure au stock (via des vérifications d'entrées de clavier...)

## Le modèle de données
![Alt text](/screenshots/data_model.jpeg?raw=true)


