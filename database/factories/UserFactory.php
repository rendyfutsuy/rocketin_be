<?php

namespace Database\Factories;

use Carbon\Carbon;
use Database\Factories;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Modules\Auth\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'last_online' => Carbon::now(),
            'remember_token' => random_str(10),
            'banned_at' => null,
        ];
    }

    /**
     * user is still not activated
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function needActivation()
    {
        return $this->state([
            'activation_code' => 123456,
            'email_verified_at' => null,
            'last_online' => null,
            'remember_token' => null,
        ]);
    }

    /**
     * user is activated
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function activated()
    {
        return $this->state([
            'activation_code' => null,
            'email_verified_at' => Carbon::now(),
        ]);
    }

    /**
     * user became admin
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function admin()
    {
        return $this->state([
            'level' => User::ADMIN,
            'activation_code' => null,
            'email_verified_at' => Carbon::now(),
        ]);
    }

    /**
     * user became editor
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function editor()
    {
        return $this->state([
            'level' => User::EDITOR,
            'activation_code' => null,
            'email_verified_at' => Carbon::now(),
        ]);
    }


    /**
     * user is banned
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function banned()
    {
        return $this->state([
            'banned_at' => Carbon::now(),
        ]);
    }
}