<?php
namespace Modules\Media\ServiceManager;

use Modules\Media\ServiceManager\Storage;
use Modules\Media\ServiceManager\StorageContract;

class Image
{
    /** @var Storage */ 
    protected $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @return StorageContract
     */
    public function create(array $forms)
    {
        return $this->storage->provider()->create($forms);
    } 

    /**
     * @return StorageContract
     */
    public function update(int $mediaId, array $forms)
    {
        return $this->storage->provider()->update($mediaId, $forms);
    }

    /**
     * @return StorageContract
     */
    public function delete(int $mediaId)
    {
        return $this->storage->provider()->delete($mediaId);
    } 
}