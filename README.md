
## How to use the project

Note: this is just a simple documentation to help you get started with the project. It can be improved with way more information if had more time.

1. Install the project
```
./vendor/bin/sail up -d
./vendor/bin/sail php artisan migrate

Note: If you have sail installed just use `sail` instead of `./vendor/bin/sail`
```

2. Run the tests
```
./vendor/bin/sail test
```

3. Project is already running, you can access it at `http://localhost`
   1. You can access the API using postman for example. The following endpoints are available:
```
GET  /api/fund-managers -> list all fund managers ( paginated )
POST /api/fund-managers -> create a new fund manager
GET  /api/fund-managers/{id} -> get details of a fund manager
PUT  /api/fund-managers/{id} -> update a fund manager

GET  /api/companies -> list all companies ( paginated )
POST /api/companies -> create a new company
GET  /api/companies/{id} -> get details of a company
PUT  /api/companies/{id} -> update a company

GET  /api/funds -> list all funds ( paginated )
POST /api/funds -> create a new fund
GET  /api/funds/duplicates -> get potential duplicates
GET  /api/funds/{id} -> get details of a fund
PUT  /api/funds/{id} -> update a fund
```
