# Commute compensation calculator
This is a small CLI example app for an assessment. The commands here after have been tested under WSL / ubuntu, but not on Mac or native Windows.

## Installation
After cloning this repository, run 
```
composer install
```

If you'd like to run the unit test, use this instead:
```
composer install --dev
```

## Usage
This CLI app uses a CSV as input. An example is provided in the repository: input.csv 

```
bin/console app:calculate --inputfile input.csv --outputfile output.csv --year 2025 
```

If you don't provide any options, the application will assume the defaults as given in the example above, so you can also run it like this:
```
bin/console app:calculate 
```
Year will then default to the current year.

## Running tests
Running the tests is as easy as this:
```
bin/phpunit
```

## Used libraries
This app uses the following libraries:
 * Symfony framework
 * Symfony console
 * Symfony filesystem
 * Symfony depencie injection
 * PHPUnit
 * PHP CS Fixer

There are couple of dependencies like the Symfony .env library that come along with a default Symfony framework installation that could possible be stripped out.


