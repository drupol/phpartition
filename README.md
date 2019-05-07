[![Latest Stable Version](https://img.shields.io/packagist/v/drupol/phpartition.svg?style=flat-square)](https://packagist.org/packages/drupol/phpartition)
 [![GitHub stars](https://img.shields.io/github/stars/drupol/phpartition.svg?style=flat-square)](https://packagist.org/packages/drupol/phpartition)
 [![Total Downloads](https://img.shields.io/packagist/dt/drupol/phpartition.svg?style=flat-square)](https://packagist.org/packages/drupol/phpartition)
 [![Build Status](https://img.shields.io/travis/drupol/phpartition/master.svg?style=flat-square)](https://travis-ci.org/drupol/phpartition)
 [![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/drupol/phpartition/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/drupol/phpartition/?branch=master)
 [![License](https://img.shields.io/packagist/l/drupol/phpartition.svg?style=flat-square)](https://packagist.org/packages/drupol/phpartition)

# PHPartition

## Description

In number theory and computer science, the partition problem ([wikipedia](https://en.wikipedia.org/wiki/Partition_problem))
is the task of splitting a set of items into multiple balanced subsets.

This library not only handles dividing a partition in two, but it handles as many numbers of them if needed, where the
goal is to divide a set n objects into a given number subsets, minimizing the difference between the smallest and the
largest subset sums (multi-way).

## Documentation

Implemented algorithms:
* Greedy
* Linear
* Combinations ([custom anytime algorithm](https://en.wikipedia.org/wiki/Anytime_algorithm))

Blog post: [https://not-a-number.io/2019/TODO](https://not-a-number.io/2019/TODO)

## Requirements

* PHP >= 7.1

## Installation

```composer require drupol/phpartition```

## Optional packages

* [drupol/phpermutations](https://github.com/drupol/phpermutations): To use the Anytime algorithm.

## Examples

```php
<?php

include './vendor/autoload.php';


```

## Code quality, tests and benchmarks

Every time changes are introduced into the library, [Travis CI](https://travis-ci.org/drupol/phpartition/builds) run the
tests and the benchmarks.

The library has unit tests written using [PHPUnit](http://www.phpunit.de/) through [Codeception](https://codeception.com/).
Feel free to check them out in the `tests` directory. Run `composer codecept` to trigger the tests.

Before each commit some inspections are executed with [GrumPHP](https://github.com/phpro/grumphp),
run `./vendor/bin/grumphp run` to check manually.

## Contributing

Feel free to contribute to this library by sending Github pull requests. I'm quite reactive :-)

## TODO

- Implement Complete Karmarkar-Karp (CKK) algorithm,
- More documentation.
