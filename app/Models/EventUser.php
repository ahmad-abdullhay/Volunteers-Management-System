<?php

namespace App\Models;
interface PreMetric {

    public function getValue ();

}
class EventUser extends BaseModel implements PreMetric
{
    const NOT_SUPERVISOR = 0;
    const SUPERVISOR = 1;

    const REJECTED_STATUS = 0;
    const ACCEPTED_STATUS = 1;
    const PENDING_STATUS = 2;

    protected $table = 'event_user';

    protected $fillable = ['user_id', 'event_id', 'status', 'is_supervisor'];



    public function getValue()
    {
        if ($this->status == EventUser::ACCEPTED_STATUS){

            return $this->is_supervisor;
        }
         else {
             return null;
         }

    }


}
