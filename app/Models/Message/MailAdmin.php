<?php

namespace App\Models\Message;

use App\Models\Admin;
use App\Models\BaseModel;

class MailAdmin extends BaseModel
{

    protected $table = 'admin_mail';


    protected $guarded = [];


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function mail()
    {
        return $this->belongsTo(Mail::class, 'mail_id');
    }

}
