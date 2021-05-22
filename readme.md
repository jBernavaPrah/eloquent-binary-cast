# Eloquent Binary Cast
The Eloquent Binary Cast.

When using the PostgreSQL dialectic, Eloquent treat the "bytea" column in the same manner as blob/text column. But this is incorrect on PostgreSQL. The value needs to be cast before pushed to the database.

If you are not using Postgresql, you don't need this cast class.


See those issues:
- https://github.com/laravel/framework/issues/10847
- https://laracasts.com/discuss/channels/eloquent/eloquent-does-not-deal-with-binary-information-correctly-in-postgresql
- https://stackoverflow.com/questions/11329323/laravel-using-a-postgre-bytea-blob-field

## Prerequisites:
- PostgreSQL 9.0 or later.
- Eloquent 8 or later.

## Install: 
```bash
composer require jbernavaprah/eloquent-binary-cast
```

## Use:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use JBernavaPrah\EloquentBinaryCast\BinaryCast;

class User extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'binary_data' => BinaryCast::class,
    ];
}
```
See https://laravel.com/docs/8.x/eloquent-mutators#custom-casts for more details.

## Tests:
```bash
composer test
```

## Authors
* **Jure Bernava Prah** - *Initial work* - [JBernavaPrah](https://github.com/JBernavaPrah)