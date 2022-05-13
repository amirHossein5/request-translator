Translates intended items of request.

## Prerequisites

- php 8
- laravel ```^8.0|^9.0```


## Installation

For installing package:

```php
composer require amir-hossein5/request-translator
```

For registering middlewares in your project:

```php
php artisan translator:install
```

Finally you may create translation file:

```php
php artisan make:translation-file
```

Pass a path , or by default a file in ```lang``` folder, and name ```en_request_translation.php```, depens to locale, will be create.


## Usage

Use middleware, and pass intended fields: 

```php
->middleware('translate:mobile,cash,amount');
``` 

It will translates them from file ```en_request_translation```(en can be your locale, f.g fa_request_translation).

Also it accepts "dot" notation:

```php
->middleware('translate:user.*,products.desk.price,products.*.price');
``` 


## Change Translation File

Pass the path of file which is located in lang folder: 

```php
->middleware('translate_from:fa/digits_translation.php', 'translate: ....');
``` 


## Templates

Templates can be for defineing a group of fields:

```php
use AmirHossein5\RequestTranslator\Facades\Translator;

Translator::for('userDigits', [
    'cash', 'phone'
]);
```

```php
->middleware('translate:userDigits,amount');
```

Each can have custom file path:

```php
use AmirHossein5\RequestTranslator\Facades\Translator;

Translator::for('userDigits', [
    'cash' => 'fa/cash_translation.php', 
    'phone'
]);
```

The priority of using translation files: 

 - In template
 - In translate_from middleware
 - Default path(```LOCALE_request_translation```)



## License
[MIT license](https://opensource.org/licenses/MIT)
