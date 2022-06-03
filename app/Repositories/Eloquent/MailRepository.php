<?php

namespace App\Repositories\Eloquent;

use App\Models\Message\Mail;
use App\Models\Message\MailAdmin;
use App\Models\Message\MailUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MailRepository extends BaseRepository
{
    /**
     * BaseRepository constructor.
     *
     * @param Mail $model
     */
    public function __construct(Mail $model)
    {
        parent::__construct($model);
    }

    public function attachUsersToMail($mail, $users,$admins)
    {

        $mail->users()->attach($users);
        $mail->admins()->attach($admins);

        $mail->save();
    }

    public function attachAdminsToMail($mail, $admins)
    {

        $mail->admin()->attach($admins);
        $mail->save();
    }

    public function getByAdminIdWithCategoryId($category_id){
        $mails = Mail::query()->whereHas("admins", function ($query){
            $query->where('admin_id', Auth::id());
        })->where("mail_category_id",$category_id)->get();

        $mails_id = $mails->map(function ($mail){return $mail->id;});
        MailAdmin::query()->whereIn('mail_id',$mails_id)->where("admin_id",Auth::id())->update(array('is_read'=>1));
        return $mails;
    }

    public function AdminMessageUnread($category_id){
        return Mail::query()->whereHas("admins", function ($query){
            $query->where('admin_id', Auth::id());
            $query->where("is_read","=","0");
        })->where("mail_category_id",$category_id)->get()->count();
    }

    public function getByUserIdWithCategoryId($category_id){
        $mails = Mail::query()->whereHas("users", function ($query){
            $query->where('user_id', Auth::id());
        })->where("mail_category_id",$category_id)->get();


        $mails_id = $mails->map(function ($mail){return $mail->id;});
        MailUser::query()->whereIn('mail_id',$mails_id)->update(array('is_read'=>1));
        return $mails;
    }

    public function UserMessageUnread($category_id){
        return Mail::query()->whereHas("users", function ($query){
            $query->where('user_id', Auth::id());
            $query->where("is_read","=","0");
        })->where("mail_category_id",$category_id)->get()->count();
    }

}
