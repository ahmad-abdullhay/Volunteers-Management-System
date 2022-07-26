<?php

namespace App\Services;

use App\Models\EventUser;
use App\Models\Metric;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VolunteeringCenterService
{
    protected MetricService $metricService;

    public function __construct(MetricService $metricService)
    {
        $this->metricService =$metricService;
    }

public function getEventUserStats ()
    {
        $userId = Auth::id();
        $events = EventUser::where ("user_id",$userId)->where ('status',1)->orderBy('created_at')->get();
        $startDate = User::where ('id',$userId)->get()->first();
        $eventsIdsList = [];
        foreach ($events as $event) {
            array_push($eventsIdsList,$event->event_id);
        }
        return [
            "startDate"=>$startDate->created_at,
            "bestFriend" =>$this-> getBestFriend($eventsIdsList,$userId),
            "categories" =>$this-> getEventsCategory($eventsIdsList),
            "genders" =>$this-> getVolunteersGender($eventsIdsList,$userId),
            "all"=>$this->getAllEventCountByMonth($userId),
            "supervisor"=>$this-> getSupervisedEventCountByMonth($userId),
            "not"=>$this-> getVolunteeredEventCountByMonth($userId),
            "events"=>$events,
            "hours" => $this->getVolunteeringHours($userId),
            ];
    }

    public function getAllEventCountByMonth ($userId)
    {
        return DB::table('event_user')->
        selectRaw('COUNT(*) as count, YEAR(updated_at) year, MONTH(updated_at) month')
            ->where ("user_id",$userId)->where ('status',1)->orderBy('created_at')
            ->groupBy('year', 'month')->get();
    }

    public function getSupervisedEventCountByMonth ($userId)
    {
      return EventUser::selectRaw('COUNT(*) as count, YEAR(updated_at) year, MONTH(updated_at) month')
            ->where ("user_id",$userId)->where ('status',1)->where('is_supervisor',1)->orderBy('created_at')
            ->groupBy('year', 'month')
            ->get();
    }

    public function getVolunteeredEventCountByMonth ($userId)
    {
       return EventUser::selectRaw('COUNT(*) as count, YEAR(updated_at) year, MONTH(updated_at) month')
            ->where ("user_id",$userId)->where ('status',1)->where('is_supervisor',0)->orderBy('created_at')
            ->groupBy('year', 'month')
            ->get();
    }

    public function getVolunteeringHours ($userId)
    {
     return $this->metricService->getAllEventMetricWithDates(1,$userId);
    }
    public function getBestFriend ($eventsIdsList,$userId)
    {
     $bestFriend =   DB::table('event_user')->
        selectRaw('user_id,count(*) as count')->whereIn ('event_id',$eventsIdsList)->where ('status',1)
            ->where('user_id','!=',$userId)->groupBy("user_id")->orderBy('count','Desc')->first();
      return
          ["user"=>User::where ('id',$bestFriend->user_id)->first(),
              "count" => $bestFriend->count];
    }

    public function getEventsCategory ($eventsIdsList)
    {
      return   DB::table('event_category')->
        selectRaw('categories.name,count(*) as count')
          ->join('categories', 'categories.id', '=', 'event_category.category_id')
          ->whereIn ('event_id',$eventsIdsList)
          ->groupBy("categories.name")->get();
    }
    public function getVolunteersGender ($eventsIdsList,$userId)
    {
        return   DB::table('event_user')->
        selectRaw('gender,count(*) as count')
            ->join('users', 'users.id', '=', 'event_user.user_id')
            ->whereIn ('event_id',$eventsIdsList)
            ->where ('status',1) ->where('user_id','!=',$userId)
            ->groupBy("gender") ->get();

    }
}


