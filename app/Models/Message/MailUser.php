<?php

namespace App\Models\Message;

use App\Models\BaseModel;
use App\Models\User;

class MailUser extends BaseModel
{

    protected $table = 'mail_user';


    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mail()
    {
        return $this->belongsTo(Mail::class, 'mail_id');
    }
//    protected array $manyToManyRelations = ['metrics', 'categories'];

}
