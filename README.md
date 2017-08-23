# Redirector
Redirect manager

[![Build Status](https://travis-ci.org/patrykwozinski/redirector.png?branch=master)](https://travis-ci.org/patrykwozinski/redirector)
[![Total Downloads](https://poser.pugx.org/freeq/redirector/downloads?format=flat-square)](https://packagist.org/packages/freeq/redirector)
[![Latest Stable Version](https://poser.pugx.org/freeq/redirector/v/stable?format=flat-square)](https://packagist.org/packages/freeq/redirector)

This package provides you with a simple tool to redirect users. You can easily manage everything.

## Installation

Via Composer

```bash
$ composer require freeq/redirector
```

## Using

Use package everywhere you need. The best way to manage your redirections is to run it in Observer or other event listener. You should store redirections after saving to the database, drop them from store after removing database record. Every redirect object should implement `Redirectable` contract.

### Create manager

Make instance of your redirections manager. It allows you to store/delete/flush/get data.
```php
use Freeq\Redirector\Manager;

$redirect_object = Redirect::findById(1); // must implement Redirectable!

// Using file driver.
$storage = new FileStorage('/path/to/store/them');
$storage->setRedirect($redirect_object);
$manager = new Manager($storage);

// Using redis driver.
$storage = RedisStorage(new Predis\Client());
$storage->setRedirect($redirect_object);
$manager = new Manager($storage);

// Otherwise u can use StorageFactory.
// $type is storage name (file or redis)
// $source is path for FileStorage or Predis Client for RedisStorage
$storage = StorageFactory::build($type, $source);
$storage->setRedirect($redirect_object);
$manager = new Manager($storage);
```

### Manage Redirectable object
Store object
```php
$manager->store();
```

Drop it
```php
$manager->delete();
```

Flush everything
```php
$manager->flush();
```

Start redirection for given route
```php
$manager->forward('my_route');
```

## Classes
* `Freeq\Redirector\Manager` - allows you to manage.
* `Freeq\Redirector\StorageFactory` - is creating concrete class depending of passed 'type' to the manager constructor.
* `Freeq\Redirector\Storages\FileStorage` - driver which allows you to store redirections as mini files.
* `Freeq\Redirector\Storages\RedisStorage` - driver which allows you to store redirections as redis records.

## Redirectable methods
Your object which implements `Freeq\Redirector\Contracts\Redirectable` needs methods:
- `routeFrom()` - which route should be redirected.
- `routeTo()` - where did you want to go by your redirection (eg. https://github.com).
- `statusHttp()` - redirect using specific http statuses (301 or 302).
- `hash()` - hash is string similar to hashed routeFrom() by md5. It's redis key or filename.
- `expireAt()` - returns date to expire your redirection.

## Contributing

Please see [contributing.md](contributing.md) for details.
