<?php

namespace App\Models\Message;

use App\Models\Admin;
use App\Models\BaseModel;
use Illuminate\Support\Facades\Auth;

class Mail extends BaseModel
{

    protected $table = 'mail';

    public string|null $relatedToCurrentUser = 'admin_id';



    protected $guarded = [];


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function category()
    {
        return $this->belongsTo(MailCategory::class, 'mail_category_id');
    }
//    protected array $manyToManyRelations = ['metrics', 'categories'];

}
