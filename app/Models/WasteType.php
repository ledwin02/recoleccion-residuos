<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description','category'];

    public function collectionRequests()
    {
        return $this->hasMany(CollectionRequest::class);
    }
}
