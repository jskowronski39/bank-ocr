# bank-ocr

## About

Applications that solves problem described in BankOCR kata.
See:
* https://codingdojo.org/kata/BankOCR/


## Requirements
* PHP 7.4+
* Composer 2


## How to set up and run


### 1. Using local PHP environment


#### Install PHP dependencies
```shell
composer install
```


#### Run use case #1
```shell
php bin/console app:ocr:run tests/data/usecase1 --output-file-path=usecase1_output.log --formatter=default
```


#### Run use case #2 and #3
```shell
php bin/console app:ocr:run tests/data/usecase3 --output-file-path=usecase3_output.log --formatter=status
```


#### Run use case #4
```shell
php bin/console app:ocr:run tests/data/usecase4 --output-file-path=usecase4_output.log --formatter=ambiguous
```
