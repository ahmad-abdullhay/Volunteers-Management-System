<?php

namespace App\Models\Message;

use App\Models\Admin;
use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MailCategoriesRoles extends BaseModel
{



    protected $table = 'MailCategoriesRoles';


    protected $guarded = [];


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'role_id');
    }

    public function category()
    {
        return $this->belongsTo(MailCategory::class, 'mail_category_id');
    }
}
