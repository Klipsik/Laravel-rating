<?php

namespace Nagy\LaravelRating\Traits\Like;

use Nagy\LaravelRating\Models\Liking;

trait Likeable
{
    public function likes()
    {
        return $this->morphMany(Liking::class, 'rateable');
    }

    public function likesDislikesSumm()
    {
        return $this->likesCount() - $this->dislikesCount();
    }

    public function likesDislikesCount()
    {
        return $this->likes()->count();
    }

    public function likesCount()
    {
        return $this->likes()->where('value', 1)->count();
    }

    public function dislikesCount()
    {
        return $this->likes()->where('value', 0)->count();
    }
}