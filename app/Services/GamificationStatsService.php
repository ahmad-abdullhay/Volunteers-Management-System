<?php

namespace App\Services;

use App\Models\BadgeUser;
use App\Models\EventUser;
use App\Models\Metric\UserPoint;
use App\Models\Metric\UserTotalPoints;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GamificationStatsService
{
    public function getGamificationStats ()
    {
        $userId = Auth::id();
        $startDate = User::where ('id',$userId)->get()->first();
        return [
            "startDate"=>$startDate->created_at,
            "allPoints"=>$this->getPointsStats($userId),
            "pointRules"=>$this->getPointsRulesStats($userId),
            "allBadges"=>$this->getBadgesStats($userId),
            "badgeRanking" => $this->getBadgesRanking($userId),
            "pointsRanking" =>$this->getPointsRanking($userId),
        ];

    }

    private function getPointsStats ($userId)
    {
        return UserPoint::selectRaw ('points,created_at')-> where ("user_id",$userId)->get();
    }
    private function getPointsRulesStats ($userId)
    {
           return DB::table('users_points')
               ->selectRaw ('sum(points) as points,notes')-> where ("user_id",$userId)->groupBy('notes')->get();
    }
    private function getPointsRanking ($userId)
    {
        $ranked = DB::table('users_total_points')
            ->selectRaw ('*,ROW_NUMBER() OVER (order by total_points desc) AS rank')->get();
        $userRank = $ranked->where("user_id",$userId)->first();
        return ((count($ranked) -$userRank->rank)/(count($ranked)-1))*100;


    }

    private function getBadgesStats ($userId)
    {
        return BadgeUser::selectRaw ('created_at')-> where ("user_id",$userId)->get();
    }

    private function getBadgesRanking ($userId)
    {
        $ranked = DB::table('badge_user')->
        selectRaw('COUNT(*) as count,user_id,ROW_NUMBER() OVER (order by count desc) AS rank')
            ->groupBy("user_id")->get();
        $userRank = $ranked->where("user_id",$userId)->first();
       return  ((count($ranked) -$userRank->rank)/(count(User::get())-1))*100;
    }
}
