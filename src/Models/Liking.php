<?php

namespace Nagy\LaravelRating\Models;

use Illuminate\Database\Eloquent\Model;

class Liking extends Model
{
    protected $guarded = [];

    protected $table = 'likings';

    public function model()
    {
        return $this->morphTo();
    }

    public function likeable()
    {
        return $this->morphTo();
    }
}