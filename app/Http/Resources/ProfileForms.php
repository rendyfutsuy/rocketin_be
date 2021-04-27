<?php

namespace App\Http\Resources;

use App\Http\Resources\Form\Form;
use Illuminate\Support\Facades\Config;

class ProfileForms extends Form
{
    /** @var array */
    protected $parameters = [];

    /**
     * @param  array $parameters
     * @return void
     */
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     *
     * @return array
     */
    public function render()
    {
        $meta =  $this->getMeta();

        return [
            'birthday' => [
                'meta' => $meta,
            ],

            'full_name' => [
                'meta' => $meta,
            ],

            'username' => [
                'username' => $this->get('username', auth()->user()->username),
            ],

            'phone' => [
                'phone' => $this->get('phone', auth()->user()->phone),
            ],

            'gender' => [
                'meta' => $meta,
            ],

            'profile_lang' => [
                'meta' => $meta,
            ],

            'nationality' => [
                'meta' => $meta,
            ],
        ];
    }

    protected function getMeta(): array
    {
        $meta = Config::get('profile.meta');
        $results = [];
        $profile = auth()->user()->profile;
        
        foreach ($meta as $data) {
            if ($this->hasKey($data) || property_exists((object) $profile->meta, $data)) {
                $results[$data] = $this->get($data, $profile->$data);
            }
        }
        
        return $results;
    }
}
