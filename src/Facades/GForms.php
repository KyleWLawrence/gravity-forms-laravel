<?php

namespace KyleWLawrence\GForms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \GForms\Api\HttpClient
 */
class GForms extends Facade
{
    /**
     * Return facade accessor.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'GForms';
    }
}
