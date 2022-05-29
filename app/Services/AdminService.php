<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Eloquent\AdminRepository;
use App\Services\Shared\BaseService;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class AdminService extends BaseService
{
    protected string $modelName = "Admin";
    protected $repository;
    public function __construct(AdminRepository $repository)
    {

        $this->repository = $repository;
        parent::__construct($repository);
    }

    public function getMailCategories(){
        $user_id = Admin::query()->with("roles")->get()->where("id",Auth::id())->first();
//        $ss = Role::query()->with("model_has_roles")->where("id",1)->get()->first();
        return $user_id;


    }

}
