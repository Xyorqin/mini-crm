<?php

namespace App\Observers;

use App\Models\Storage;

class StorageObserver
{
    public function updated(Storage $storage)
    {
        if ($storage->quantity == 0) $storage->delete();
    }
}
