<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends ParentModel
{
    use HasFactory;

    public function batches()
    {
        return $this->hasMany(BatchProduct::class, 'product_id', 'product_id');
    }
}
