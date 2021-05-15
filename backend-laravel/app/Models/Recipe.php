<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'author', 'authorid', 'title', 'url', 'description', 'ingredients', 'preparationMode', 'category'
    ];

    public $timestamps = false;
}
