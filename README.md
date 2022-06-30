# Mikko Test
# Introduction
Welcome to my mikko test project. This project is created as a simple way to create a CSV file that the HR departmant can use to find out which dates the salary and the bonuses should be payed. The project has some simple requirements:
- The payout of the salary should be done on the last day of the month, unless:
    * the last working day of the month falls in a weekend. (Saturday, Sunday) In that case the payout should be done the last working day of that month
- The bonuses of every month should be payed on the 15th of the month, unless:
    * the 15th falls in a weekend (Saturday, Sunday). In that case the bonus should be payed the next wednesday

# Setup
## Requirements
- Docker (Desktop) should be installed on your system
## Command Line Interface setup
Clone the project to a directory of your liking on a system

Run the following docker-compose command:
```
$ docker-compose up -d
```

Next: 
```
$ docker-compose exec php-fpm composer install
```

## Dependencies
- Twig templating
- Composer
- Docker

# Usage
## Command Line Interface
Run the following command:
```console
$ docker-compose exec php-fpm php execute.php ParsePayoutCSV {filename} {year}
```
File can be anything you want, it does not have to end with CSV. The script does that itself when it finds it missing. You can also leave {filename}, the script will then ask what the file should be named
When the script finds a file with the same name, it will ask to replace it. Only yes or no are valid answers. I think the question itself explains what it does ;).
The question does not need to be answered, then it will default to yes

The script will also ask which year should be calculated, defaults to the current year when left empty
```
$ docker-compose run --rm  php-fpm php execute.php ParsePayoutCSV
Please enter a filename for the payout file:
test
Please enter the year you want to generate
2000
Given file already exists. Replace? [Y/n]
```

## Web interface
The web interface is a *very* simple webapplication where you can fill out the required data,
Data is the year, and which payout types you want to calculate (Bonus, Salary). Both are required
When submitted the output from the parser is shown in a html table, and a download link allows you to download the generated csv file

The web url can be found at localhost:8080
