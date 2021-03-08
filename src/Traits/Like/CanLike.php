<?php

namespace Nagy\LaravelRating\Traits\Like;

use LaravelRating;
use Nagy\LaravelRating\Models\Liking;

trait CanLike
{
    public function likes()
    {
        return $this->morphMany(Liking::class, 'model');
    }

    public function like($model)
    {
        return LaravelRating::like($this, $model, 1);
    }

    public function dislike($model)
    {
        return LaravelRating::like($this, $model, 0);
    }

    public function isLiked($model)
    {
        return LaravelRating::isLiked($this, $model);
    }

    public function liked()
    {
        $collection = collect();

        $liked = $this->likes()->where('value', 1)->get();
        
        return LaravelRating::resolveLikedItems($liked);
    }

    public function disliked()
    {        
        $disliked = $this->likes()->where('value', 0)->get();
        
        return LaravelRating::resolveLikedItems($disliked);
    }

    public function likedDisliked()
    {
        return LaravelRating::resolveLikedItems($this->likes);
    }
}