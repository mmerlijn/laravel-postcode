# Laravel Postcode

### Installation

##### Install package

```
composer require mmerlijn/laravel-postcode
```

##### Optional Publish config file (for customisation)

```
php artisan vendor:publish --provider="mmerlijn\LaravelPostcodeServiceProvider" --tag="config"

database_connection_name => default: mysql_postcode
postcode_table_name => default: postcode_nl
postcode_table_not_found =>default: postcode_not_found

route.prefix    => default: postcode
route.middleware => default: ['web']
```

### Usage

Postcode request

```php
POST: ../postcode/getAddress {city:...,building:...}

//Required: city and building
```

Response

```php
//on success example
status:200
data:{
    "postcode": "1187LS"
    "nr": "3 a"
    "building_nr": "3"
    "building_addition": "a"
    "street": "Westwijkplein"
    "city": "Amstelveen"
    "province": "Noord-Holland"
    "lat": "52.281458330925"
    "long": "4.8261185828603"
    "success": true
    "error": null
}
//on not found failure example
status:200
data:{
    "postcode": "1187LS"
    "nr": "3 a"
    "building_nr": "3"
    "building_addition": "a"
    "street": ""
    "city": ""
    "province": ""
    "lat": ""
    "long": ""
    "success": false
    "error": 'Postcode not found'
}
//on invalid request
status:422
Usual laravel validation errors
```

### Usefull methods

Scopes

```php
$p = Postcode::getAddress($city,$building)->first();
```

Static methods

```php
$c = Postcode::getCity($postcode); //returns name of city or empty string

$c = Postcode::getCityCoordinates($city); // return array ['lat'=>...,'long'=>...]
$c = Postcode::getPostcodeCoordinates($postcode); // return array ['lat'=>...,'long'=>...]
$c = Postcode::getCoordinates(postcode/city);  // return array ['lat'=>...,'long'=>...]
```