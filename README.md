## PHPartition
[![Build Status](https://travis-ci.org/drupol/phpartition.svg?branch=master)](https://travis-ci.org/drupol/phpartition) [![Code Coverage](https://scrutinizer-ci.com/g/drupol/phpartition/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/drupol/phpartition/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/drupol/phpartition/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/drupol/phpartition/?branch=master) [![Dependency Status](https://www.versioneye.com/user/projects/58551f4d4d6466004c28cc8f/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/58551f4d4d6466004c28cc8f)

In number theory and computer science, the partition problem is the task of deciding whether a given multiset of items can be partitioned into multiple balanced subsets.

## Requirements

* PHP >= 5.6,
* (optional) [PHPUnit](https://phpunit.de/) to run tests.

## Examples

```php
<?php

include "./vendor/autoload.php";

$data = array(1, 5, 5, 11, 6, 7, 9, 3);

$greedy = new \drupol\phpartition\Algorithm\Greedy();
$greedy->setData($data);
$greedy->setSize(3);
$result = $greedy->getResult();

// $result is:
/*
 * Array
   (
       [0] => Array
           (
               [0] => 9
               [1] => 5
               [2] => 1
           )
   
       [1] => Array
           (
               [0] => 7
               [1] => 6
               [2] => 3
           )
   
       [2] => Array
           (
               [0] => 11
               [1] => 5
           )
   )
 */

$simple = new \drupol\phpartition\Algorithm\Simple();
$simple->setData($data);
$simple->setSize(3);
$result = $simple->getResult();

// $result is:
/*
 * Array
(
    [0] => Array
        (
            [0] => 5
            [1] => 11
        )

    [1] => Array
        (
            [0] => 1
            [1] => 7
            [2] => 3
        )

    [2] => Array
        (
            [0] => 5
            [1] => 6
            [2] => 9
        )
)
 */
```
You may also pass objects or array but then, you'll have to define how to access their value.

```php
<?php

include "./vendor/autoload.php";

$data = array(
  array(
    'item' => 'anything A',
    'weight' => 1,
  ),
  array(
    'item' => 'anything B',
    'weight' => 2,
  ),
  array(
    'item' => 'anything C',
    'weight' => 3,
  ),
  array(
    'item' => 'anything D',
    'weight' => 4,
  ),
);

$greedy = new \drupol\phpartition\Algorithm\Greedy();
$greedy->setData($data);
$greedy->setSize(2);
$greedy->setItemAccessCallback(function($item) {
  return $item['weight'];
});
$result = $greedy->getResult();

// $result is
/*
 * Array
   (
       [0] => Array
           (
               [0] => Array
                   (
                       [item] => anything C
                       [weight] => 3
                   )
   
               [1] => Array
                   (
                       [item] => anything B
                       [weight] => 2
                   )
   
           )
   
       [1] => Array
           (
               [0] => Array
                   (
                       [item] => anything D
                       [weight] => 4
                   )
   
               [1] => Array
                   (
                       [item] => anything A
                       [weight] => 1
                   )
   
           )
   
   )
 */
```

It's also possible to mix the type of object to partition.

## TODO

- Implement Complete Karmarkar-Karp (CKK) algorithm,
- Documentation.

