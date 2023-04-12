<?php

namespace KyleWLawrence\GForms\Services;

use BadMethodCallException;
use Config;
use InvalidArgumentException;
use KyleWLawrence\GForms\Api\HttpClient;

class GFormsService
{
    /**
     * Get auth parameters from config, fail if any are missing.
     * Instantiate API client and set auth bearer token.
     *
     * @throws Exception
     */
    public function __construct(
        public $client = (object) [],
        private string $domain = '',
        private string $username = '',
        private string $password = '',
    ) {
        $this->username = config('gravity-forms-laravel.username');
        $this->password = config('gravity-forms-laravel.password');
        $this->domain = config('gravity-forms-laravel.domain');

        if (! $this->username || ! $this->password || ! $this->domain) {
            throw new InvalidArgumentException('Please set GF_USERNAME GF_PASSWORD & GF_DOMAIN environment variables.');
        }

        $this->client = new HttpClient($this->domain);
        $this->client->setAuth('basic', ['username' => $this->username, 'password' => $this->password]);
    }

    /**
     * Pass any method calls onto $this->client
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (is_callable([$this->client, $method])) {
            return call_user_func_array([$this->client, $method], $args);
        } else {
            throw new BadMethodCallException("Method $method does not exist");
        }
    }

    /**
     * Pass any property calls onto $this->client
     *
     * @return mixed
     */
    public function __get($property)
    {
        if (property_exists($this->client, $property)) {
            return $this->client->{$property};
        } else {
            throw new BadMethodCallException("Property $property does not exist");
        }
    }
}
