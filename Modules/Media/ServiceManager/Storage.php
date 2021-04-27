<?php
namespace Modules\Media\ServiceManager;

use Illuminate\Support\Facades\Config;
use Modules\Media\Exceptions\ProviderException;
use Modules\Media\ServiceManager\Contracts\StorageContract;

class Storage
{
    protected $providers = [
        'local' => Providers\LocalProvider::class,
        'wp' => Providers\WordpressProvider::class,
    ];
   
    /**
     * @param  string||null $provider
     */
    public function provider($provider = null): StorageContract
    {
        $provider = $provider ?? Config::get('media.provider');
        try {
            return app()->make($this->providers[$provider]);
        } catch (\Throwable $th) {
            throw new ProviderException(__('media::provider.fail'));
        }
    }
}