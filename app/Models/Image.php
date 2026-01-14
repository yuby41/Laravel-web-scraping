<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'url',
                
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
