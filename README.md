# [Sunny PHP-ADO](http://ado.sunnyface.com/)

[PHP-Ado framework](http://ado.sunnyface.com/) is a very simple PHP framework made for fast PHP proccessing and development, ADO + Basic Helper Classes to get you going on a development fast.
The finality its to make our life easier and be able to develop faster.

## Getting Started

To use this framewrok, choose one of the following options to get started:
* Download the latest release on ado.sunnyface.com
* Fork this repository on GitHub

## The "S.class.php"

Like all the frameworks we have to call something to load the rest of the classes, in this case "Session".

We can call the Session with no need of authentification in the form of:
```php
$s = new Session(false);
```
of we can block a script with the need of being authentificated user by Session
```php
$s = new Session();
```
if you want to see what session has just do a 
```php
printR($s);
```
## The "A.class.php"

"Access" its the class thats pulls all the /lib/models/ classes in the directory and creates an object of each class in the way of an object class.



## Configuration Steps

- Update /lib/config.inc.php for the database name user, password.
- Update the RootPath and the pathSteps to match your hosting root folder in order to autoload the model classes.
- Prepare your database models in /lib/models/  - this is the base database model classes, will create the tables if necesary and if it found the method.

## CRUD - create - update
```php
$user = new User();     // Creates a new user object
or
$user = $a->user->get(1); // Gets user with id = 1
$user->name = "John";
$user->email = "john@email.com";
$a->user->save($user);    // CREATE the user or UPDATE if the ID >0
```
##  CRUD - Select - search

$a its the main CRUD class it contains the model clasess, this way, using the ADO we can do a simple select with the following function:
```php
$books = $a->books->select($where, $order);
$books = $a->books->select("manufacturer='Vintage'","creation_date ASC")
```
To perform a loop in the record we can do this simple with the following:
```php
if ($books && $books->nr()>0){
  while($books->fetch($book)){
    echo $book->id . "\r";
    echo $book->name . "\r";
  }
}
```
## Bugs and Issues

Have a bug or an issue with this framework? [Open a new issue](https://github.com/kikoseijo/sunny-php-ado/issues) here on GitHub or leave a comment on the [ contact page at Sunnyface.com](http://sunnyface.com/).

## Creator

Sunny PHP-ADO was created by and is maintained by **Kiko Seijo**, Managing Parter at [Sunnyface.com](http://www.sunnyface.com/).


## Copyright and License

Copyright 2011-2015 Sunnyface.com. Code released under the [Apache 2.0](https://github.com/kikoseijo/sunny-php-ado/blob/master/LICENSE) license.
