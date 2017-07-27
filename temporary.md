# Bootmodal

If you want to install this package please use the following instruction since I still haven't submitted it to Laravel as of yet.

## Installation

### Composer
```sh
"require": {
    "torgheh/bootmodal": "v0.1.0"
}
```
Add the follwing section to the `composer.json` the same level as `require`
```sh
"repositories": [
    {
        "type": "package",
        "package": {
            "name": "torgheh/bootmodal",
            "version": "dev-master",
            "source": {
                "url": "https://github.com/torgheh/bootmodal.git",
                "type": "git",
                "reference": "master"
            },
            "autoload": {
                "psr-0" : {
                    "Torgheh\\Bootmodal" : "src"
                }
            }
        }
    }
],
```
Then run the `composer update`.
### Laravel configuration

Add the Bootmodal service provider to the `providers` array in `app/cofig/app.php`:
```php
	'Torgheh\Bootmodal\BootmodalServiceProvider'
```

Next under the `aliases` array in  `app/cofig/app.php`, you may add the Modal facade.
```php
	'Modal'  => 'Torgheh\Bootmodal\Facades\Modal',

```
Finally to move the package Javascript asset to the public folder run the follwoing command.

```sh
php artisan asset:publish torgheh/bootmodal
```
The Javascript plugin must be added to the front-end layout.1
```html
<script src="{{asset('torgheh/bootmodal/bootmodal.min.js')}}" ></script>
```
