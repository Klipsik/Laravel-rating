<?php

namespace Nagy\LaravelRating\Models;

use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    protected $guarded = [];

    protected $table = 'votings';

    public function model()
    {
        return $this->morphTo();
    }

    public function voteable()
    {
        return $this->morphTo();
    }
}