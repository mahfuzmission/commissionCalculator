# Commission Calculator

A project that parses transactions from a csv file and calculates commission fees.

## Requirements

`* composer `

`* php version : 7.1.13 `

## Installation

Clone repository and install dependencies via composer.

     composer install  
## Notes
 
I have used `src/Config/CommissionConfig` as a config file.
So Before running the Unit test cases turn `is_production` to false.
If it is true the `Exchange Rates Api` will be called and value might not match thus test case will fail. 

And one more thing as I don't have any private key for the `Exchange Rates Api`, the monthly limit is 250 times call, so it will be better to have `is_production` set to false to have avoid exceptions. 

## Demo

     php script.php input.csv

## Tests

Install dev dependencies via composer and run tests.

     bin/phpunit tests
