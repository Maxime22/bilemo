# bilemo

Prérequis :
- composer : https://getcomposer.org/doc/00-intro.md
- serveur local fonctionnel permettant de se connecter à une base de donnée (WAMP/MAMP/LAMP avec php, mysql et phpmyadmin ou tout autre configuration similaire)

Pour installer le projet :
- Cloner le projet sur votre repository
- Aller sur le répertoire du projet nouvellement créé et faire : composer update
- Remplir les données DATABASE_URL dans .env.local et .env.test.local (si les fichiers n’existent pas => les créer à la racine du projet (au même niveau que le .env), exemple : DATABASE_URL=mysql://username:password@localhost:3306/databasename (mettre un autre nom de database dans .env.test.local si vous voulez faire des tests)
- Créer la base de donnée : php bin/console doctrine:database:create 
- Faire les migrations pour mettre à jour le schéma de la base de donnée : php bin/console doctrine:migrations:migrate
- Charger les fixtures : php bin/console doctrine:fixtures:load

Lancer l’application :
- Dans un terminal : symfony serve (si vous avez la commande symfony), autrement faire php bin/console server:start
- RDV sur http://127.0.0.1:8000/api dans votre navigateur

Si jamais vous voulez regarder si les tests fonctionnent :
- Créer une base de donnée de test :php bin/console doctrine:database:create --env=test
- Mettre à jour le schéma de la base de donnée de test : php bin/console doctrine:schema:update --env=test --force
- Charger les fixtures dans la base de donnée de test : php bin/console doctrine:fixtures:load --env=test
- Lancer les tests php bin/phpunit

--------------------------------------------------------------------------------------

Prerequisites:
- composer: https://getcomposer.org/doc/00-intro.md
- functional local server allowing connection to a database (WAMP/MAMP/LAMP with php, mysql and phpmyadmin or any other similar configuration)

To install the project:
- Clone the project on your repository
- Go to the directory of the newly created project and do: compose update
- Fill in the DATABASE_URL data in .env.local and .env.test.local (if the files do not exist => create them at the root of the project (at the same level as the .env), example: DATABASE_URL=mysql://username:password@localhost:3306/databasename (put another database name in .env.test.local if you want to do tests)
- Create the database: php bin/console doctrine:database:create
- Perform the migrations to update the database schema: php bin/console doctrine:migrations:migrate
- Load fixtures: php bin/console doctrine:fixtures:load

Launch the application :
- In a terminal: symfony serve (if you have the symfony command), otherwise do: php bin/console server:start
- Go to http://127.0.0.1:8000/api in your web browser

If you ever want to see if the tests are working:
- Create a test database: php bin/console doctrine:database:create --env=test
- Update the test database schema: php bin/console doctrine:schema:update --env=test --force
- Load the fixtures in the test database: php bin/console doctrine:fixtures:load --env=test
- Run the tests : php bin/phpunit
