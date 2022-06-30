<?php

namespace App\Services;

use App\Common\SharedMessage;
use App\Models\Level;
use App\Models\Metric\Leaderboard;
use App\Models\Metric\MetricQuery;
use App\Models\User;
use App\Repositories\Eloquent\LeaderboardRepository;
use App\Repositories\Eloquent\LevelRepository;
use App\Services\Shared\BaseService;

class LeaderboardService extends BaseService
{
    protected string $modelName = "Leaderboard";
    private MetricQueryService $metricQueryService;
    private MetricService $metricService;
    public function __construct(LeaderboardRepository $repository,MetricQueryService $metricQueryService, MetricService $metricService)
    {
        $this->metricQueryService = $metricQueryService;
        $this->metricService = $metricService;

        parent::__construct($repository);
    }
    public function allTablesWithVolunteers ()
    {
        $leaderboardsList = Leaderboard::get();
        $tablesList = [];
        $usersList = User::get ();
        foreach ($leaderboardsList as $leaderboard)
        {
            $leaderboard->volunteers = $this->tableVolunteers($leaderboard,$usersList);
            array_push($tablesList,$leaderboard);
        }
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $tablesList,
            true,
            null,
            200
        );
    }
    public function tableVolunteers (Leaderboard $leaderboard,$usersList)
    {
        $query = $leaderboard->metricQuery;
        $usersDataList = [];
        foreach ($usersList as $key=>$user)
        {

            $userData = $this->metricService->allEventOperation($query,$user);

            if ($userData == null) $userData = 0;
            array_push($usersDataList,["value"=>$userData,"user" => $user,"key"=>$key]);
        }
        $result = [];
        for ($i = 0; $i < $leaderboard->table_size; $i++) {
           $data = $this->maxData($usersDataList);
           if ($data == null)
               return
                   $result;


           array_push($result,$data);
            unset($usersDataList[$data["key"]]);
          // dd($data);
        }

        return $result;


    }
    public function maxData ($usersDataList)
    {
        if (count($usersDataList) == 0 )
            return null;
        $max = reset($usersDataList);
        foreach ($usersDataList as $userData)
        {
            if ($max["value"] < $userData["value"])
                $max = $userData;
        }
        return $max;
    }
    public function newTable ($payload)
    {
      $query =  $this->metricQueryService->newLeaderboardMetricQuery($payload['metric_queries']);
        return  $this->repository->newTable($payload,$query);
    }

}
