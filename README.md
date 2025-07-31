### Original README below.

### What has happened here?
With the deprecation of Composer 1, and with the proposed Docker image, could not make it run at all, so decided to go for a 
complete new php8.4-based installation, with nginx and PHP serving the app, MongoDB as database -Because I had the image 
ready for that, not because of any specific techie reason-. With that said, you can run the services just using `docker-compose up [-d]`
And you will be ready to go on `http://localhost (port 80, make sure you don't have any other service listening that port)`.

### Load original data from the json file:
`docker-compose exec app php ../bin/console app:load-data ../request.json`

This will call a Symfony command (`src/Infrastructure/CLI/Symfony/Command/LoadDataFromFileCommand.php`) that is an adapter
over the working command/handler. This handler is decoupled from the CLI and framework.

### How things are setup here:
I have used a DDD + CQRS approach, as many simple API's can be defined as a series of queries and commands.

So, in short:

`src/Infrastructure/CQRS`: Here you will find the wrapper around the Symfony Command/Message bus.

`src/Application/Command`: Here you will find the commands and handlers that write/modify data.

`src/Application/Query`: Here you will find the queries that read data.

On the Domain layer, you can see three folders:

`Exception`: Contains the domain exceptions thrown by the app.

`Model`: The data model here. As a quality of life feature, I have added a factory to build the models based on the defined input.

  `fruit & vegetable`: the data model, extending from a parent class `veggie`

`Persistence`: The persistence interface definition.

And last but not least, the Infrastructure layer:

`CLI` and `CQRS` we have already described.

`http`: Contains the HTTP part of the framework and app. All http handlers should be here.

`Repository`: The actual layer between the app and the database. Can be any type of repository as long as it implements the

Domain `Persistence` interfaces.

## API DOCS
GET all veggies:

`GET /api/veggies` -> can be filtered out with query params `?type=[fruit|vegetable]`

GET all vegetables

`GET /api/vegetables`

GET all fruits

`GET /api/fruits`

Add a veggie:

`POST /api/veggies`
Body:

```json
{
  "id":"integer",
  "name": "string",
  "quantity": "integer",
  "unit": "g|kg"
}
```

## Running tests:
There are not as many tests as I would have liked, but the two I added will show different approaches to test things that may 
not seem testeable or may require too much effort to cover all cases. You will find them at `tests` folder.

`docker-compose exec app  php ../vendor/phpunit/phpunit/phpunit -c ../phpunit.xml.dist` -> will run all tests existing on the project.

----

# Original Readme

# 🍎🥕 Fruits and Vegetables

## 🎯 Goal
We want to build a service which will take a `request.json` and:
* Process the file and create two separate collections for `Fruits` and `Vegetables`
* Each collection has methods like `add()`, `remove()`, `list()`;
* Units have to be stored as grams;
* Store the collections in a storage engine of your choice. (e.g. Database, In-memory)
* Provide an API endpoint to query the collections. As a bonus, this endpoint can accept filters to be applied to the returning collection.
* Provide another API endpoint to add new items to the collections (i.e., your storage engine).
* As a bonus you might:
  * consider giving an option to decide which units are returned (kilograms/grams);
  * how to implement `search()` method collections;
  * use latest version of Symfony's to embed your logic 

### ✔️ How can I check if my code is working?
You have two ways of moving on:
* You call the Service from PHPUnit test like it's done in dummy test (just run `bin/phpunit` from the console)

or

* You create a Controller which will be calling the service with a json payload

## 💡 Hints before you start working on it
* Keep KISS, DRY, YAGNI, SOLID principles in mind
* We value a clean domain model, without unnecessary code duplication or complexity
* Think about how you will handle input validation
* Follow generally-accepted good practices, such as no logic in controllers, information hiding (see the first hint).
* Timebox your work - we expect that you would spend between 3 and 4 hours.
* Your code should be tested
* We don't care how you handle data persistence, no bonus points for having a complex method

## When you are finished
* Please upload your code to a public git repository (i.e. GitHub, Gitlab)

> Warning, the next docker image is no longer available.
## 🐳 Docker image
Optional. Just here if you want to run it isolated.

### 📥 Pulling image
```bash
docker pull tturkowski/fruits-and-vegetables
```

### 🧱 Building image
```bash
docker build -t tturkowski/fruits-and-vegetables -f docker/Dockerfile .
```

### 🏃‍♂️ Running container
```bash
docker run -it -w/app -v$(pwd):/app tturkowski/fruits-and-vegetables sh 
```

### 🛂 Running tests
```bash
docker run -it -w/app -v$(pwd):/app tturkowski/fruits-and-vegetables bin/phpunit
```

### ⌨️ Run development server
```bash
docker run -it -w/app -v$(pwd):/app -p8080:8080 tturkowski/fruits-and-vegetables php -S 0.0.0.0:8080 -t /app/public
# Open http://127.0.0.1:8080 in your browser
```
