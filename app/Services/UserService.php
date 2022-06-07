<?php

namespace App\Services;

use App\Common\SharedMessage;
use App\Models\Admin;
use App\Models\JoinRequest;
use App\Models\Message\MailCategoriesRoles;
use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use App\Services\Shared\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    protected string $modelName = "User";
    protected $repository;
    public function __construct(UserRepository $repository)
    {

        $this->repository = $repository;
        parent::__construct($repository);
    }

    public function activateVolunteer(User $user)
    {
        $isActivated = $this->repository->activateVolunteer($user);

        if ($isActivated){
            $user->joinRequest->status = JoinRequest::STATUS_ACCEPTED;
            $user->joinRequest->save();
        }


        return new SharedMessage(__('success.update', ['model' => $this->modelName]),
            true,
            true,
            null,
            200
        );
    }

    public function ChangeVolunteerJoinEventStatus(array $payload)
    {
        return new SharedMessage(__('success.join-status-update'),
            $this->repository->changeVolunteersJoinEventStatus($payload),
            true,
            null,
            200
        );
    }

    public function joinEvent(array $payload)
    {
        return new SharedMessage(__('success.join-status-update'),
            $this->repository->joinEvent($payload),
            true,
            null,
            200
        );
    }

    public function searchByName($key)
    {
        return new SharedMessage(__('success.join-status-update'),
            $this->repository->searchByName($key),
            true,
            null,
            200
        );
    }

    public function getMailCategories(){
        $user = User::query()->with("roles")->where("id",Auth::id())->first();
        $role_ids= $user->roles->pluck("id");
        $category = MailCategoriesRoles::query()->whereIn("role_id",$role_ids)->where('type',"=",'sender')->get();
        return $category;
    }



}
