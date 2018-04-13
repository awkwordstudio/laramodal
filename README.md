# Laravel Bootstrap Modal

Laramodal provides an easy interface to use Bootstrap modals in laravel

## Installation

### Composer
```sh
"require": {
    "awkwordstudio/laramodal": "v0.1.0"
}
```
Then run the `composer update`.
### Laravel configuration

Add the Laramodal service provider to the `providers` array in `app/cofig/app.php`:
```php
	'Awkwordstudio\Laramodal\LaramodalServiceProvider::class,'
```

Next under the `aliases` array in  `app/cofig/app.php`, you may add the Modal facade.
```php
	'Modal'  => 'Awkwordstudio\Laramodal\Facades\Modal',

```
Finally to move the package Javascript asset to the public folder run the following command.

```sh
php artisan asset:publish Awkwordstudio/Laramodal

```
## Frontend

```html
<script src="{{asset('packages/torgheh/bootmodal/laramodal.js')}}" ></script>
```

## Backend

#### View 
The view should extend the default `Laramodal::layout`.There are three sections in a Bootstrap modal that can be extended:
`modal-body` and `modal-footer` or using `modal-content` you can replace the entire modal content.

views/dialogs/login.blade.php
```php
@extends('laramodal::layout')
@section('modal-content')
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" >Login</h4>
	</div>

	<form id="login-form" action="{{url('login')}}" method="post" data-toggle="bootmodal">
		<div class="modal-body">
			<ul id="errors">
				@foreach($errors->all() as $error )
					<li>{{$error}}</li>
				@endforeach
			</ul>

			<label class="control-label">
			Email: <input type="text" class="form-control" name="email" value="{{\Input::old('email')}}">
			</label>

			<label class="control-label">
			Password: <input type="password" class="form-control" name="password">
			</label>
		</div>
		<div class="modal-footer text-right" >
			<input type="submit" class="btn btn-default" value="login">
		</div>

	</form>
@stop
```

#### Controller Function

controllers/AuthController.php

```php
<?php
use Modal;
class AuthController extends BaseController
{
	public function showLoginDialog()
	{
		$foo = '';
		return Modal::make('dialogs.login', compact('foo'));
	}
}
```	

#### Routes
```php
Route::get('login', 'AuthController@showLoginDialog');
```	
#### Launching your modal

```html
<a href="#" data-action="{{url('login')}}" data-toggle="laramodal">Login</a>
```

### Redirect

In some cases you might want to go from an Ajax response to a normal redirect, for instance after a successful sign in. 
```php
return Modal::redirect($url);
```

### Options
Some of the Bootstrap modal options are adjustable through the Modal object:
- size:	size of the dialog (normal, lg or sm)
- animation: modal animation
- dismiss: dismiss button

### Data attributes
You can bind two types of events to your HTML elements that will trigger the Bootmodal, click and submit.

#### Click:
```html
<a href="#" data-action="{{url('login')}}" data-toggle="laramodal">Login</a>
```
This will create and show a modal dialog directed through `data-action` attributes.

#### Sumbit:

```html
<form action="{{url('login')}} method="post" data-toggle="laramodal">
```
This will send an Ajax post request to the `action` attribute.

Two data attributes are necessary, `data-toggle="laramodal"` and `data-action` for buttons.

### JavaScript

You can also enable laramodal through Javascript for forms and buttons.
```js
$('#login-button').laramodal();
$('#login-form').laramodal();
```

### Options
There are only two options available, the modal container which is the HTML `body` and Ajax cache option which is `false`, both by default.

```js
$('#edit-button').laramodal({ container: $('#modal-container') });
$('#tos-button').laramodal({ cache: true });
```