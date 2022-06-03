<?php

namespace App\Models\Message;

use App\Models\Admin;
use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Mail extends BaseModel
{



    protected $table = 'mails';

//    public string|null $relatedToCurrentUser = 'admin_id' | 'user_id';



    protected $guarded = [];


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(MailCategory::class, 'mail_category_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function admins()
    {
        return $this->belongsToMany(Admin::class);
    }




//    protected array $manyToManyRelations = ['metrics', 'categories'];

}
