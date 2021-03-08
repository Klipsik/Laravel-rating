<?php

namespace Nagy\LaravelRating;

use Illuminate\Database\Eloquent\Relations\Relation;

class LaravelRating
{
    public function rate($user, $rateable, $value)
    {
        if ($this->isRated($user, $rateable)) {
            return $user->ratings()
                        ->where('rateable_id', $rateable->id)
                        ->where('rateable_type', $this->getRateableByClass($rateable))
                        ->update(['value' => $value]);
        }

        return $user->ratings()->create([
            'rateable_id'   => $rateable->id,
            'rateable_type' => $this->getRateableByClass($rateable),
            'value'         => $value
        ]);
    }

    public function vote($user, $voteable, $value)
    {
        if ($this->isVoted($user, $voteable)) {
            return $user->votes()
                        ->where('voteable_id', $voteable->id)
                        ->where('voteable_type', $this->getVoteableByClass($voteable))
                        ->update(['value' => $value]);
        }

        return $user->votes()->create([
            'voteable_id'   => $voteable->id,
            'voteable_type' => $this->getVoteableByClass($voteable),
            'value'         => $value
        ]);
    }

    public function like($user, $likeable, $value)
    {
        if ($this->isLiked($user, $likeable)) {
            return $user->votes()
                        ->where('likeable_id', $likeable->id)
                        ->where('likeable_type', $this->getLikeableByClass($likeable))
                        ->update(['value' => $value]);
        }

        return $user->likes()->create([
            'likeable_id'   => $likeable->id,
            'likeable_type' => $this->getLikeableByClass($likeable),
            'value'         => $value
        ]);
    }

    public function isRated($user, $rateable)
    {
        $rating = $user->ratings()
                        ->where('rateable_id', $rateable->id)
                        ->where('rateable_type', $this->getRateableByClass($rateable))
                        ->first();

        return $rating != null;

    }

    public function isVoted($user, $voteable)
    {
        $voting = $user->votes()
                        ->where('voteable_id', $voteable->id)
                        ->where('voteable_type', $this->getVoteableByClass($voteable))
                        ->first();

        return $voting != null;

    }

    public function isLiked($user, $likeable)
    {
        $liking = $user->likes()
                        ->where('likeable_id', $likeable->id)
                        ->where('likeable_type', $this->getLikeableByClass($likeable))
                        ->first();

        return $liking != null;

    }

    public function getRatingValue($user, $rateable)
    {
        $rating = $user->ratings()
                        ->where('rateable_id', $rateable->id)
                        ->where('rateable_type', $this->getRateableByClass($rateable))
                        ->first();

        return $rating != null ? $rating->value : null;
    }

    public function getVotingValue($user, $voteable)
    {
        $voting = $user->votes()
                        ->where('voteable_id', $voteable->id)
                        ->where('voteable_type', $this->getVoteableByClass($voteable))
                        ->first();

        return $voting != null ? $voting->value : null;
    }

    public function getLikingValue($user, $likeable)
    {
        $liking = $user->likes()
                        ->where('likeable_id', $likeable->id)
                        ->where('likeable_type', $this->getLikeableByClass($likeable))
                        ->first();

        return $liking != null ? $liking->value : null;
    }

    public function resolveRatedItems($items)
    {
        $collection = collect();
        
        foreach ($items as $item) {
            $rateableClass = $this->getRateableByKey($item->rateable_type);
            $collection->push((new $rateableClass)->find($item->rateable_id));
        }

        return $collection;
    }

    public function resolveVotedItems($items)
    {
        $collection = collect();
        
        foreach ($items as $item) {
            $voteableClass = $this->getVoteableByKey($item->voteable_type);
            $collection->push((new $voteableClass)->find($item->voteable_id));
        }

        return $collection;
    }

    public function resolveLikedItems($items)
    {
        $collection = collect();
        
        foreach ($items as $item) {
            $likeableClass = $this->getLikeableByKey($item->likeable_type);
            $collection->push((new $likeableClass)->find($item->likeable_id));
        }

        return $collection;
    }

    private function getRateableByClass($rateable)
    {
        $rateable = get_class($rateable);
        if (in_array($rateable, Relation::$morphMap)) {
            $rateable = array_search($rateable, Relation::$morphMap);
        }

        return $rateable;
    }

    private function getVoteableByClass($voteable)
    {
        $voteable = get_class($voteable);
        if (in_array($voteable, Relation::$morphMap)) {
            $voteable = array_search($voteable, Relation::$morphMap);
        }

        return $voteable;
    }

    private function getLikeableByClass($likeable)
    {
        $likeable = get_class($likeable);
        if (in_array($likeable, Relation::$morphMap)) {
            $likeable = array_search($likeable, Relation::$morphMap);
        }

        return $likeable;
    }

    private function getRateableByKey($rateable)
    {
        if (array_key_exists($rateable, Relation::$morphMap)) {
            $rateable = Relation::$morphMap[$rateable];
        }

        return $rateable;
    }

    private function getVoteableByKey($voteable)
    {
        if (array_key_exists($voteable, Relation::$morphMap)) {
            $voteable = Relation::$morphMap[$voteable];
        }

        return $voteable;
    }

    private function getLikeableByKey($likeable)
    {
        if (array_key_exists($likeable, Relation::$morphMap)) {
            $likeable = Relation::$morphMap[$likeable];
        }

        return $likeable;
    }
}
