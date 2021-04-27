<?php

namespace Modules\Wordpress\ServiceManager;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Auth\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Modules\Wordpress\ServiceManager\Authentication;

class Wordpress
{
    /** @var Authentication */
    protected $auth;

    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param  string||null $token
     * @param  string||null $url     
     * @param  array $params
     * 
     * @return array
     */
    public function uploadMedia($url = null, array $forms, $token = null)
    {
        if ($url == null) {
            $url = $this->baseUrl() . '/wp/v2/media';
        }

        $photoFilePath = fopen($forms['file']->path(), 'r');
        $uploadedName = Carbon::now()->format('YmdHis'). '-' .$forms['file']->getClientOriginalName();

        unset($forms['file']);

        $response = Http::withHeaders($this->auth->provider()->getHeaders($token))
            ->attach(
                'file',
                $photoFilePath,
                $uploadedName
            )->post($url, $forms);

        return json_decode($response);
    }

    /**
     * @param  string||null $token
     * @param  integer||null $mediaId
     * @param  array $params
     * 
     * @return array
     */
    public function updateMedia($mediaId, array $forms, $token = null)
    {
        $url = $this->baseUrl() . '/wp/v2/media/'.$mediaId;

        if (Arr::get($forms, 'file')) {
            return $this->uploadMedia(
                $url,
                $forms,
                $token,
            );
        }
        
        $response = Http::withHeaders($this->auth->provider()->getHeaders($token))
            ->post($url, $forms);

        return json_decode($response);
    }

    /**
     * @param  string||null $token
     * @param  integer||null $mediaId
     * 
     * @return array
     */
    public function deleteMedia($mediaId, $token = null)
    {   
        $url = $this->baseUrl() . '/wp/v2/media/'.$mediaId.'?force=true';

        $response = Http::withHeaders($this->auth->provider()->getHeaders($token))
            ->delete($url);
        
        return json_decode($response);
    }

    /**
     * @param  string||null $url
     * @param  array $params
     * 
     * @return array
     */
    public function request(string $method, $url = null, $params = [], $token = null)
    {
        if ($method == 'post') {
            $response = Http::withHeaders($this->auth->provider()->getHeaders($token))
                ->post($url, $params);
        } elseif ($method == 'delete') {
            $response = Http::withHeaders($this->auth->provider()->getHeaders($token))
                ->delete($url);
        } else {
            $response = Http::withHeaders($this->auth->provider()->getHeaders($token))
                ->get($url, $params);
        }

        return json_decode($response);
    }

    /**
     * @param  integer $wpId
     * @param  array||null $params
     * 
     * @return array
     */
    public function requestPosts($wpId, $params = [])
    {
        return $this->request(
            'get',
            $this->baseUrl() . '/wp/v2/posts?author='. $wpId,
            $params,
        );
    }

    /**
     * 
     * @return array
     */
    public function requestRegistration($registrationForm = [])
    {
        return $this->request(
            'post',
            $this->baseUrl() . '/wp/v2/users',
            $registrationForm,
        );
    }

    /**
     * @param  array $postForm
     * @param  string||null $token
     * 
     * @return array
     */
    public function requestCreatePost($token, $postForm = [])
    {
        return $this->request(
            'post',
            $this->baseUrl() . '/wp/v2/posts',
            $postForm,
            $token
        );
    }

    /**
     * @param  array $postForm
     * @param  integer $postId
     * @param  string $token
     * 
     * @return array
     */
    public function requestUpdatePost($postId, $token, $postForm = [])
    {
        return $this->request(
            'post',
            $this->baseUrl() . '/wp/v2/posts/'.$postId,
            $postForm,
            $token
        );
    }

    /**
     * @param  integer $postId
     * @param  string $token
     * 
     * @return array
     */
    public function requestDeletePost($postId, $token)
    {
        return $this->request(
            'delete',
            $this->baseUrl() . '/wp/v2/posts/'.$postId,
            [],
            $token
        );
    }

    /**
     * Wordpress EndPoint's Base Url.
     */
    public function baseUrl(): string
    {
        return Config::get('wordpress.wp_url');
    }

    /**
     * @param  array $parameters
     * 
     * @return array
     */
    public function categories($parameters = [])
    {
        return $this->request('get', $this->baseUrl(). '/wp/v2/categories', $parameters);
    }

    /**
     * @param  array $parameters
     * 
     * @return array
     */
    public function tags($parameters = [])
    {
        return $this->request('get', $this->baseUrl(). '/wp/v2/tags', $parameters);
    }
}
