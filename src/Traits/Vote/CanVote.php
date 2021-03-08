<?php

namespace Nagy\LaravelRating\Traits\Vote;

use LaravelRating;
use Nagy\LaravelRating\Models\Voting;

trait CanVote
{
    public function votes()
    {
        return $this->morphMany(Voting::class, 'model');
    }

    public function upVote($model)
    {
        return LaravelRating::vote($this, $model, 1);
    }

    public function downVote($model)
    {
        return LaravelRating::vote($this, $model, 0);
    }

    public function isVoted($model)
    {
        return LaravelRating::isVoted($this, $model);
    }

    public function upVoted()
    {
        $upVoted = $this->votes()->where('value', 1)->get();

        return LaravelRating::resolveVotedItems($upVoted);
    }

    public function downVoted()
    {
        $downVoted = $this->votes()->where('value', 0)->get();

        return LaravelRating::resolveVotedItems($downVoted);
    }

    public function voted()
    {
        return LaravelRating::resolveVotedItems($this->votes);
    }
}