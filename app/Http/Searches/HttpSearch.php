<?php

namespace App\Http\Searches;

use RuntimeException;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\Form\Form;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Contracts\Container\Container as Laravel;

abstract class HttpSearch extends Form
{
    /** @var array */
    protected $parameters = [];

    /** @var Pipeline */
    protected $pipeline;

    /** @var Laravel|null */
    protected $laravel;

    /** @var Request */
    protected $request;

    /** @var array */
    protected $filters = [];

    /**
     * Undocumented function
     *
     * @param  Pipeline $pipeline
     * @param  Laravel|null  $laravel
     * @param  Request $request
     * @return void
     */
    public function __construct(Pipeline $pipeline, Request $request, Laravel $laravel = null)
    {
        $this->pipeline = $pipeline;
        $this->request = $request;
        $this->laravel = $laravel;
    }

    /**
     * Search using pipeline.
     *
     * @param  mixed  ...$params
     * @return mixed
     */
    public function apply(...$params)
    {
        if (! empty($params)) {
            $this->parameters = $params['0'];
        } elseif (! empty($this->request )) {
            $this->parameters = $this->request->all();
        }

        if (! method_exists($this, 'passable')) {
            throw new RuntimeException("passable method not exists.");
        }

        $result = $this->pipeline->send($this->{'passable'}(...$params))
            ->through($this->parsedFilters())
            ->thenReturn();

        return $this->thenReturn($result) ?? $result;
    }

    protected function filters(): array
    {
        return $this->filters;
    }

    /**
     * @param  mixed  $result
     * @return mixed
     */
    protected function thenReturn($result)
    {
        return;
    }

    protected function parsedFilters(): array
    {
        $filters = collect($this->filters())->map(function ($filter) {
            // kalau sudah berbentuk object kita tidak perlu melakukan apapun.
            if (is_object($filter)) {
                return $filter;
            }

            // Kalau kelas filter tidak ada kita serahkan resolusinya ke Laravel.
            if (!class_exists($filter)) {
                return $filter;
            }

            return $this->resolveFilterClass($filter);
        });

        return $filters->all();
    }

    /**
     * @param  class-string $filter
     * @return mixed
     */
    protected function resolveFilterClass($filter)
    {
        $constructor = (new \ReflectionClass($filter))->getConstructor();

        // Kalau kelas filter tidak memiliki constructor kita tidak perlu mapping parameters.
        if (!$constructor) {
            return $filter;
        }

        // Kelas filter memiliki constructor.
        // Lakukan map parameter dengan request.
        // Kemudian resolve kelasnya dari container Laravel.
        $parameters = $this->mapParameters($constructor->getParameters());

        return $this->getLaravel()->make($filter, $parameters);
    }

    /**
     * @param  \ReflectionParameter[]  $params
     * @return array
     */
    protected function mapParameters(array $params): array
    {
        $mappedParams = [];

        foreach ($params as $param) {
            $key = $param->name;

            $input = $this->get($key) ?? $this->get(Str::snake($key));

            if ($input || $param->allowsNull()) {
                $mappedParams[$param->name] = $input;
            }
        }

        return $mappedParams;
    }

    /**
     * Get the Laravel container instance.
     *
     * @return Laravel
     *
     * @throws RuntimeException
     */
    protected function getLaravel()
    {
        if (! $this->laravel) {
            throw new RuntimeException('Laravel container instance has not been passed to the HttpSearch.');
        }

        return $this->laravel;
    }
}
