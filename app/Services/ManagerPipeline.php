<?php

namespace App\Services;

use RuntimeException;
use Illuminate\Support\Str;
use App\Http\Resources\Form\Form;
use App\Builders\Contracts\BuilderContract;
use Illuminate\Contracts\Container\Container as Laravel;

abstract class ManagerPipeline extends Form
{
    /** @var Laravel|null */
    protected $laravel;

    /** @var array<BuilderContract>|BuilderContract|array<string>|string */
    protected $builders;

    /** @var mixed */
    protected $returnValue = null;

    /** @var array */
    protected $parameters;

    public function __construct(Laravel $laravel = null)
    {
        $this->laravel = $laravel;
    }

    /**
     * @param  array<BuilderContract>|BuilderContract|array<string>|string $builders
     * @return self
     */
    public function with($builders)
    {
        $this->builders = $builders;
        return $this;
    }

    /**
     * @param  array $parameters
    */
    public function commit($parameters = []): self
    {
        $this->parameters = $parameters;

        $this->applyBuilders();

        return $this;
    }

    /** Initialize all builder that registered in $builders */
    protected function applyBuilders(): void
    {
        if (! $this->builders) {
            return;
        }

        if (! is_array($this->builders)) {
            $this->returnValue = $this->parsedBuilder($this->builders)
                ->set($this->parameters)
                ->apply()
                ->withReturn();
            return;
        }
        
        if (count($this->builders) == 1) {
            $this->returnValue = $this->parsedBuilder($this->builders['0'])
                ->set($this->parameters)
                ->apply()
                ->withReturn();
            return;
        }
        
        foreach ($this->builders as $builder) {
            $builder = $this->parsedBuilder($builder);
            if (array_key_exists($builder->getName(), $this->parameters)) {
                $builder->set($this->parameters[$builder->getName()])
                    ->apply();
            }
        }
    }

    /**
     * auto solved when user enter namespace rather than object
     *
     * @param  string|BuilderContract $builders
     * @return mixed
     */
    protected function parsedBuilder($builders)
    {
        if (is_object($builders)) {
            return $builders;
        }

        if (!class_exists($builders)) {
            return $builders;
        }

        return $this->resolveBuilderClass($builders);
    }

    /**
     * change class to string to Builder Object
     * 
     * @param  class-string $builder
     * @return mixed
     */
    protected function resolveBuilderClass($builder)
    {
        $constructor = (new \ReflectionClass($builder))->getConstructor();

        if (!$constructor) {
            return $builder;
        }

        // Kelas filter memiliki constructor.
        // Lakukan map parameter dengan request.
        // Kemudian resolve kelasnya dari container Laravel.
        $parameters = $this->mapParameters($constructor->getParameters());

        return $this->getLaravel()->make($builder, $parameters);
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
     * return manager's values
     *
     * @return mixed
    */
    public function withReturn()
    {
        return $this->returnValue;
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