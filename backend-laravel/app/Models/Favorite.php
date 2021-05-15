<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'uid', 'rid'
    ];

    public $timestamps = false;
}
