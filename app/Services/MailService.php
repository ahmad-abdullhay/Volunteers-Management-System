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
        if (isset($payload['users'])){

            $users = $payload['users'];

            unset($payload['users']);


            $mail =  $this->repository->create($payload);


            return new SharedMessage(__('success.store', ['model' => $this->modelName]),
                $mail,
                true,
                null,
                200
            );
        }


        return parent::store($payload);
    }

}
