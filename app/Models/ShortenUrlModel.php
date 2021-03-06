<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortenUrlModel extends Model
{
    use HasFactory;

    protected $table='shorten_urls';
    protected $guarded = ['id'];

    public $timestamps = false;
}
