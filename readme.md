## Moldova Open Contracting Data Visualisation Platform

This is the data visualisation portal of the tenders/contracts data from Moldova PPA eTenders System. The system is built using php based Laravel framework and MongoDb. The data are pulled from eTenders system, transformed to the OCDS standard and presented the visualisation to display the data in meaningful manner.

### Run
The app can be run following th e steps below:

* Clone the repository
* Install the application dependencies using command: composer install
* Copy .env.example to .env and update your the database configurations
* Give read/write permission to the storage folder using chmod -R 777 storage
* Serve application using php artisan serve (append --port PORT_NUMBER to run in different port other than 8000)
* Access localhost:8000

### Framework

The application is written in PHP based on the Laravel framework V5.2.

### License

The Platform is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

### TODO

* Need to provide the test seed data for the installation