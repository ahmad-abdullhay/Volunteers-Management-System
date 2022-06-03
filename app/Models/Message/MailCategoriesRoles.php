<?php

namespace App\Models\Message;

use App\Models\Admin;
use App\Models\BaseModel;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MailCategoriesRoles extends BaseModel
{



    protected $table = 'mail_categories_roles';


    protected $guarded = [];


    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function category()
    {
        return $this->belongsTo(MailCategory::class, 'mail_category_id');
    }
}
