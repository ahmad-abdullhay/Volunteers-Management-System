<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Message\MailCategoriesRoles;
use App\Models\Message\MailCategory;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Eloquent\MailCategoryRepository;
use App\Services\Shared\BaseService;

class MailCategoryService extends BaseService
{
    protected string $modelName = "MailCategory";
    protected $repository;
    public function __construct(MailCategoryRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

    public function getUserFromRoleInCategory($category_id){
        $categories = MailCategoriesRoles::query()->where('mail_category_id',$category_id)->where('type',"=","receive")->get();
        $roles = $categories->pluck("roles");
        $admins = [];
        $users = [];
        foreach ($roles as $role){
                if("users" == $role->guard_name){
                    array_push($users,User::role($role->name)->select('name','id')->get());

                }
            if("admins" == $role->guard_name){
                    array_push($admins,Admin::role($role->name)->select('name','id')->where("status",1)->get());

            }

        }


        return ["users" => $users , "admins" => $admins];
    }



}
