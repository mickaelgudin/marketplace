# Marketplace - with several NoSQL databases

## The project NoSQL databases and their implementation
- Redis : local instance, caching features from the Framework CodeIgniter (in the app/Config/Cache.php file, Predis is configured as a cache handler)
- Elasticsearch : local instance, and api calls in javascript (for the views panier.php and catalogue.php)
- Mongodb : local instance, using the controller Mongodb.php (based on this repo : https://github.com/intekhabrizvi/codeigniter-mongodb-library)

## Launching the project
- git pull (if you dowload the zip file, please make sure that the folder is called marketplace)
- In the elasticsearch folder in your computuer, go to config/elasticsearch.yml and add the followings configs(if not present) : 
```
http.cors.enabled : true
http.cors.allow-origin: "*"
http.cors.allow-methods: OPTIONS, HEAD, GET, POST, PUT, DELETE
http.cors.allow-headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers
http.cors.allow-credentials: true
```
- the mongodb driver needs to be installed in wamp(or equivalent)
- the project should be put in the www folder of wamp(or equivalent)
- execture the following commmand : `composer install`
- start all databases (either manually or using the script launch-database.bat *provided that you change the url in the .bat file*)
- Execute the mongodb commands (**see the file ajout_des_collections.txt**)
- Execute the elasticsearch api request via postman(or other) (**see the file elasticSearch.txt**)
- In the console redis-cli enter `CONFIG SET requirepass password`
- In the console redis-cli enter `AUTH password`
- In your web browser(chrome is the only fully supported) go to the home page : http://localhost/marketplace/public/
- You can log in using already existing users(created via mongodb commands)
```
Email : test@test.fr
password : test 
```
- You can also create a new account and log in

## The databases and their uses
- The api calls to elastic search via javascript allow us to display data without refreshing the page. The catalogue search engine can perform several filters at once(search by name, search by price interval, and ordering).
![Alt text](/screenshots/catalogue.png?raw=true)
- Elastic search allow to check if the requested quantity is consistent with stock(when clicking + button on of product in the cart), if not an error is displayed.
![Alt text](/screenshots/quantite_insuffisante.png?raw=true)
- When clicking in the "Commander"(order) button in the cart, we translate the cart stored in Redis into Commande(order) and Ligne(order lines) to MongoDb with errors handling.
- Mongodb is where persistent data are stored(order, order lines, users)

## Error handling
- Most errors are handle in the server side(refuse access to guest users in some pages : catalogue, cart, orders...)
- For the catalgoue(in javascript), the user cannot enter a quantity exceeding the current stock for the product

## Data model
![Alt text](/screenshots/data_model.jpeg?raw=true)


