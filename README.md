Here is some simple books api base on Symfony and API Platform.
### Steps to run
- Clone this repo ```git clone https://github.com/111crb111/books.git```.
- Install dependencies ```composer install```.
- Configure DB connection in ```.env``` config ```DATABASE_URL=mysql://user:password@127.0.0.1:3306/db_name```. Note: DB creation and run is outside this app, you must run it on you own.
- Run migration to create tables ```php bin/console doctrine:migrations:migrate```.
- Start Symfony test server ```php bin/console server:run```.
- Go to your browser and open http://localhost:8000/api.
- Enjoy cool Swagger generated page and feel free to try out some Books API.
- To run test go to project root in console and execute ```php bin/phpunit```. Warning. Test will purge all current data and generate new test data.
