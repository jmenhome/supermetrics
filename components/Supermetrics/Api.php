<?php

namespace Supermetrics;

use Curl\Http;

/**
 * Class Api
 *
 * Provides methods to get token & posts
 */
class Api extends Http
{
    public $client_id;
    public $email;
    public $name;

    public $url = 'https://api.supermetrics.com';

    public $token;

    /**
     * @return mixed
     * @throws ApiWrongResponseException
     * @throws \Curl\CurlTimeoutException
     */
    public function register()
    {
        $response = $this->request(
            self::POST,
            $this->url.'/assignment/register',
            [
                'client_id' => $this->client_id,
                'email' => $this->email,
                'name' => $this->name
            ]
        );

        if (!isset($response['data']['sl_token']))
            throw new ApiWrongResponseException('There is no token in response: '.var_export($response, true));

        $this->token = $response['data']['sl_token'];

        return $this->token;
    }

    /**
     * @param int $page Default 1
     * @return Post[]
     * @throws ApiWrongResponseException
     * @throws \Curl\CurlTimeoutException
     */
    public function posts($page = 1) {

        $response = $this->request(
            self::GET,
            $this->url.'/assignment/posts',
            [
                'sl_token' => $this->token,
                'page' => $page,
            ]
        );

        if (isset($response['error']['message']))
            throw new ApiInvalidTokenException($response['error']['message'].': '.var_export($response, true));
        elseif (!isset($response['data']['posts']) || !is_array($response['data']['posts']))
            throw new ApiWrongResponseException('There is no posts in response: '.var_export($response, true));

        $posts = [];

        foreach ($response['data']['posts'] as $post) {
            $posts[] = new Post($post);
        }

        return $posts;
    }
}