<?php

namespace App\Models\Message;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MailCategory extends BaseModel
{

    protected $table = 'mail_categories';


    protected $guarded = [];

//    protected array $manyToManyRelations = ['metrics', 'categories'];

}
