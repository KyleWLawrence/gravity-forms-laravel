# Laravel GForms

This package provides integration with the GForms API. It supports creating forms, retrieving and updating entries, sending notifications, etc.

The package simply provides a `GForms` facade that acts as a wrapper to the [kylewlawrence/gravity-forms-api-client-php](https://github.com/kylewlawrence/gravity-forms-api-client-php) package.

**NB:** Currently only supports bearer token-based authentication.

## Installation

You can install this package via Composer using:

```bash
composer require kylewlawrence/gravity-forms-laravel
```

The Facade is automatically installed with the alias `GForms`

## Configuration

To publish the config file to `app/config/gravity-forms-laravel.php` run:

```bash
php artisan vendor:publish --provider="KyleWLawrence\GForms\Providers\GFormsServiceProvider"
```

Set your configuration using **environment variables**, either in your `.env` file or on your server's control panel:

- `GF_USERNAME`

The API username. You can create one in your Gravity Forms Settings

- `GF_PASSWORD`

The API password.

- `GF_DOMAIN`

The domain and path of the website with Gravity Forms. Only the domain and path, not the protocol should be passed. forms.example.com should be passed for https://forms.example.com

- `GF_DRIVER` _(Optional)_

Set this to `null` or `log` to prevent calling the GForms API directly from your environment.

## Contributing

If you have any questions/problems/request with the SDK (the GFormsService class), please go to the [GForms PHP SDK repository](https://github.com/KyleWLawrence/gravity-forms-api-client-php) with those requests. Pull Requests for the Laravel wrapper are always welcome here. I'll catch-up and develop the contribution guidelines soon. For the meantime, just open and issue or create a pull request.

## Usage

### Facade

The `GForms` facade acts as a wrapper for an instance of the `GForms\API\Client` class. Any methods available on this class ([documentation here](https://github.com/kylewlawrence/gravity-forms-api-client-php#usage)) are available through the facade. for example:

```php
// Get all forms
$forms = $client->forms()->getAll();
print_r($forms);

// Create a new form
$newForm = $client->forms()->create([
    'title' => 'Blah Blah',                          
    'fields' => [
        {
            'id' : '1',
            'label' : 'My Text',
            'type' : 'text'
        },
        {
            'id' : '2',
            'label' : 'More Text',
            'type' : 'text'
        }
    ],
]);
print_r($newForm);

// Delete a form
$client->forms()->delete(12345);
```

### Dependency injection

If you'd prefer not to use the facade, you can skip adding the alias to `config/app.php` and instead inject `KyleWLawrence\GForms\Services\GFormsService` into your class. You can then use all of the same methods on this object as you would on the facade.

```php
<?php

use KyleWLawrence\GForms\Services\GFormsService;

class MyClass {

    public function __construct(GFormsService $gforms_service) {
        $this->gforms_service = $gforms_service;
    }

    public function getSite() {
        $this->gforms_service->site()->get(12345);
    }

}
```

## Copyright and license

Copyright 2023-present KyleWLawrence

Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.
