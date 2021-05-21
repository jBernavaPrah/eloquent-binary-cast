# EloquentFS

A filesystem wrapper that use eloquent, inspired by GridFS (Mongo)

### Attention: it's not production ready!

## Install:

```bash
composer install jbernavaprah/eloquent-fs
```

Then create the required tables on database with:
```bash
php artisan migrate
```

This will use the standard laravel migrations, therefore will be also used the default connection set on your project.

## Basic usage:

To use this wrapper, you need to prefix the paths with `efs://`. The path will be used as `id` of the file on database.

```php
touch('efs://file.txt');
file_put_contents('efs://file.txt', "foobar\n");
echo file_get_contents('efs://file.txt'); // "foobar\n"
copy('efs://file.txt', 'efs://other_file.txt');
echo file_get_contents('efs://other_file.txt'); // "foobar\n"
unlink('efs://file.txt');
unlink('efs://other_file.txt');
```

### Use with Eloquent model

You can also use directly the Eloquent Model (or extend it) shipped with EloquentFS.

```php
use JBernavaPrah\EloquentFS\Models\FsFile;

$file = new FsFile(); // It's a Eloquent model...
$file->id = 'file.txt'; // if not provided, will generated randomly 

$file->write("foobar", $append=true); // 6

$file->read($offset =3, $length = 3); // "bar"
$file->read($offset =0, $length = 6); // "foobar"

$file->write("foobar", $append=true); // 6
$file->read(); // foobarfoobar

$file->delete(); // Delete


```

### Standalone:

You need to have the database manager configured.

```php
// configure your DB manager
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;
use JBernavaPrah\EloquentFS\EloquentFSStreamWrapper;

$db = new Manager();
$db->addConnection( [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
    ]);
$db->setAsGlobal();
$db->setEventDispatcher(new Dispatcher(new Container()));
$db->bootEloquent();

// This command will create the migrations table
// and call the required migrations on database/migrations directory.
EloquentFSStreamWrapper::migrate($db, $connection = 'default');

```

For the standalone execution, you need also register the wrapper:

```php
use JBernavaPrah\EloquentFS\EloquentFSStreamWrapper;
EloquentFSStreamWrapper::register();
```

## Deep configuration:

### Different Connection:

If you would to change the connection then on your `AppServiceProvider::register()` method add:

```php
\JBernavaPrah\EloquentFS\EloquentFS::$connection = 'different_connection';
```

### Disable Migrations:

If you would to disable the migrations, the on your `AppServiceProvider::register()` method add:

```php
\JBernavaPrah\EloquentFS\EloquentFS::$runMigrations = False;
```
Now you will be in charge to create and run the required migrations. 
You can see those on `./database/migrations` path.

## How to help:

Do a PR, Do all tests and I will be glad to merge it!

## Missing implementations:

1. The locking file with `flock()`.
2. Need a performance review. A comparison with MongoDB will be super!
3. Use in some production environments :D
4. Need a testing review.
5. `ftruncate()` need to be implemented.
