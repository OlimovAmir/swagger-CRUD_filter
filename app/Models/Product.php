<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $quarted = false;

    protected $fillable = ['name', 'categories','unit','price','quantity'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
