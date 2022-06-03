<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Message\MailCategoriesRoles;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Eloquent\AdminRepository;
use App\Services\Shared\BaseService;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;

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
        $admin = Admin::query()->with("roles")->where("id",Auth::id())->first();
        $role_ids= $admin->roles->pluck("id");
        $category = MailCategoriesRoles::query()->whereIn("role_id",$role_ids)->where('type',"=",'sender')->get();
        return $category;
    }

}
