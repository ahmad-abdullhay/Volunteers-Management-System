<?php

namespace App\Repositories\Eloquent;

use App\Models\Traits;
use App\Models\TraitsUser;

class TraitsRepository extends BaseRepository
{
    /**
     * BaseRepository constructor.
     *
     * @param Traits $model
     */
    public function __construct(Traits $model)
    {
        parent::__construct($model);
    }
    public function assignTraitToUser (Traits $traits,int $value,int $userId)
    {
       $traitUser =  new TraitsUser;
       $traitUser->trait_id = $traits->id;
        $traitUser->value = $value;
        $traitUser->user_id = $userId;
        $traitUser->save();

    }
    public function getAverage ()
    {
        TraitsUser::avg('value')->groupBy('trait_id')->get();
    }
}
