<?php

namespace App\Repositories\Eloquent;

use App\Models\Badge;
use App\Models\BadgeUser;

class BadgeRepository extends BaseRepository
{
    /**
     * BaseRepository constructor.
     *
     * @param Badge $model
     */
    public function __construct(Badge $model)
    {
        parent::__construct($model);
    }

    public function addBadgeToUser(array $payload){
        return BadgeUser::create($payload);
    }
    public function getUserBadge ($user_id,$badge_id)
    {
        return BadgeUser::where('badge_id', $badge_id)->where('user_id',$user_id)->first();
    }
    public function automaticallyGiveBadgeToUser($user_id,$badge_id,$note){
        $badgeUser = new BadgeUser;
        $badgeUser->badge_id = $badge_id;
        $badgeUser->note = $note;
        $badgeUser->user_id = $user_id;
        $badgeUser->save();

    }
}
