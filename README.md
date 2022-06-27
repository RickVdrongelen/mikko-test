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

# Usage
## Command Line Interface
Run the following command:
```console
docker-compose run --rm php-fpm parsePayoutCSV.php {filename}
```
File can be anything you want, it does not have to end with CSV. The script does that itself when it finds it missing. You can also leave {filename}, the script will then ask what the file should be named
When the script finds a file with the same name, it will ask to replace it. Only yes or no are valid answers. I think the question itself explains what it does ;).
The question does not need to be answered, then it will default to yes
```
$ docker-compose run --rm  php-fpm php parsePayoutCSV.php
Please enter a filename for the payout file:
test
Given file already exists. Replace? [Y/n]
Y
```

