<?php

namespace App\Services;

use App\Common\SharedMessage;
use App\Models\EventUser;
use App\Models\Message\Mail;
use App\Repositories\Eloquent\MailCategoryRepository;
use App\Repositories\Eloquent\MailRepository;
use App\Services\Shared\BaseService;

class MailService extends BaseService
{
    protected string $modelName = "Mail";
    protected $repository;
    public function __construct(MailRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }


    public function store($payload): SharedMessage
    {

        if( isset($payload['admins'])){
            $admins = $payload['admins'];
            unset($payload['admins']);

        }
        if (isset($payload['users'])) {

            $users = $payload['users'];

            unset($payload['users']);
        }


            $mail =  $this->repository->create($payload);

            $this->repository->attachUsersToMail(
                $mail,
                $users,
                $admins
            );

            return new SharedMessage(__('success.store', ['model' => $this->modelName]),
                $mail,
                true,
                null,
                200
            );


//        return parent::store($payload);
    }

    public function getByAdminIdWithCategoryId($category_id){
        $mails = $this->repository->getByAdminIdWithCategoryId($category_id);
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $mails,
            true,
            null,
            200);
    }
    public function AdminMessageUnread($category_id){
        return $this->repository->AdminMessageUnread($category_id);
    }

    public function getByUserIdWithCategoryId($category_id){
        $mails = $this->repository->getByUserIdWithCategoryId($category_id);
        return new SharedMessage(__('success.store', ['model' => $this->modelName]),
            $mails,
            true,
            null,
            200);
    }

    public function UserMessageUnread($category_id){
        return $this->repository->UserMessageUnread($category_id);
    }

}
