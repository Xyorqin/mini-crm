<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends ParentModel
{
    use HasFactory;

    public function products()
    {
        return $this->hasMany(BatchProduct::class);
    }
}
