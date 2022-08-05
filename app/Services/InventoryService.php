<?php

namespace App\Services;

use App\Common\SharedMessage;
use App\Models\Inventory;
use App\Models\TraitsUser;
use App\Repositories\Eloquent\InventoryRepository;
use App\Services\Shared\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryService extends BaseService
{
    protected TraitsService $traitsService;
    public function __construct(InventoryRepository $repository, TraitsService $traitsService)
    {
        $this->traitsService = $traitsService;
        parent::__construct($repository);
    }

    public function getAll(): SharedMessage
    {
        return new SharedMessage(__('success.list', ['model' => 'Permission']),
            $this->repository->getAll(),
            true,
            null,
            200
        );
    }
    public function setTraits (Inventory $inventory,$payload)
    {
        switch ($inventory->shortcut){
            case 'vfi':
                $this->doVFI($inventory,$payload);
                break;
            case 'hex':
                $this->doHEX($inventory,$payload);
                break;

        }

    }
    public function doVFI (Inventory $inventory,$payload)
    {
        $careerTrait = $payload[0]['answer']+$payload[9]['answer']+$payload[14]['answer']
            +$payload[20]['answer']+$payload[27]['answer'];
        $careerTraitPercentage = round(($careerTrait / 35)*100);
        $this->traitsService->assignTraitToUser ($inventory->traits[3],$careerTraitPercentage,Auth::id());

        $socialTrait = $payload[1]['answer']+$payload[3]['answer']+$payload[5]['answer']
            +$payload[16]['answer']+$payload[22]['answer'];
        $socialTraitPercentage = round(($socialTrait / 35)*100);
        $this->traitsService->assignTraitToUser ($inventory->traits[4],$socialTraitPercentage,Auth::id());

        $valueTrait = $payload[2]['answer']+$payload[7]['answer']+$payload[15]['answer']
            +$payload[18]['answer']+$payload[21]['answer'];
        $valueTraitPercentage = round(($valueTrait / 35)*100);
        $this->traitsService->assignTraitToUser ($inventory->traits[0],$valueTraitPercentage,Auth::id());

        $understandTrait = $payload[11]['answer']+$payload[13]['answer']+$payload[17]['answer']
            +$payload[24]['answer']+$payload[29]['answer'];;
        $understandTraitPercentage = round(($understandTrait / 35)*100);
        $this->traitsService->assignTraitToUser ($inventory->traits[1],$understandTraitPercentage,Auth::id());

        $enhanceTrait = $payload[4]['answer']+$payload[12]['answer']+$payload[25]['answer']
            +$payload[26]['answer']+$payload[28]['answer'];
        $enhanceTraitPercentage = round(($enhanceTrait / 35)*100);
        $this->traitsService->assignTraitToUser ($inventory->traits[2],$enhanceTraitPercentage,Auth::id());

        $protectTrait = $payload[6]['answer']+$payload[8]['answer']+$payload[10]['answer']
            +$payload[19]['answer']+$payload[23]['answer'];
        $protectTraitPercentage = round(($protectTrait / 35)*100);
        $this->traitsService->assignTraitToUser ($inventory->traits[5],$protectTraitPercentage,Auth::id());
    }

    public function doHEX (Inventory $inventory,$payload)
    {
        $valueHumility = $payload[5]['answer'] +(6-$payload[29]['answer']) +$payload[53]['answer']
            +(6-$payload[11]['answer'])+  +$payload[35]['answer']+(6-$payload[59]['answer'])
            +$payload[17]['answer'] +(6-$payload[41]['answer'])
            +(6-$payload[23]['answer']) +(6-$payload[47]['answer']);
        $valueHumilityPercentage =round(($valueHumility / 50)*100);
        $this->traitsService->assignTraitToUser ($inventory->traits[0],$valueHumilityPercentage,Auth::id());

        $valueEmotionality = $payload[4]['answer'] +($payload[28]['answer']) +(6-$payload[52]['answer'])
            +($payload[10]['answer'])+  +(1-$payload[34]['answer'])
            +$payload[16]['answer'] +(6-$payload[40]['answer'])
            +($payload[22]['answer']) +($payload[46]['answer'])+(6-$payload[58]['answer']);
        $EmotionalityPercentage = round(($valueEmotionality / 50)*100);
        $this->traitsService->assignTraitToUser ($inventory->traits[1],$EmotionalityPercentage,Auth::id());

        $Extroversion = $payload[3]['answer'] +(6-$payload[27]['answer']) +(6-$payload[51]['answer'])
            +(6-$payload[9]['answer'])+  +$payload[33]['answer']+($payload[57]['answer'])
            +$payload[15]['answer'] +($payload[39]['answer'])
            +($payload[21]['answer']) +(6-$payload[45]['answer']);
        $extroversionPercentage = round(($Extroversion / 50)*100);
        $this->traitsService->assignTraitToUser ($inventory->traits[2],$extroversionPercentage,Auth::id());

        $agreeableness = $payload[2]['answer'] +($payload[26]['answer']) +(6-$payload[8]['answer'])
            +($payload[32]['answer'])+  +$payload[50]['answer']+(6-$payload[14]['answer'])
            +$payload[38]['answer'] +(6-$payload[56]['answer'])
            +(6-$payload[20]['answer']) +($payload[44]['answer']);
        $agreeablenessPercentage = round(($agreeableness / 50)*100);
        $this->traitsService->assignTraitToUser ($inventory->traits[3],$agreeablenessPercentage,Auth::id());

        $Conscientiousness = ($payload[1]['answer']) +(6-$payload[25]['answer']) +($payload[7]['answer'])
            +(6-$payload[31]['answer'])+  +$payload[49]['answer']+(6-$payload[13]['answer'])
            +$payload[37]['answer'] +(6-$payload[55]['answer'])
            +(6-$payload[19]['answer']) +(6-$payload[43]['answer']);
        $ConscientiousnessPercentage = round(($Conscientiousness / 50)*100);
        $this->traitsService->assignTraitToUser ($inventory->traits[4],$ConscientiousnessPercentage,Auth::id());

        $Openness = (6-$payload[0]['answer']) +($payload[24]['answer']) +($payload[6]['answer'])
            +(6-$payload[30]['answer'])+  +(6-$payload[48]['answer'])+($payload[12]['answer'])
            +$payload[36]['answer'] +(6-$payload[54]['answer'])
                +(6-$payload[18]['answer']) +($payload[42]['answer']);
        $OpennessPercentage = round(($Openness / 50)*100);
        $this->traitsService->assignTraitToUser ($inventory->traits[5],$OpennessPercentage,Auth::id());
    }

    public function getTraitsStats (Inventory $inventory)
    {
        $traits = $inventory->traits;
        $traitsWithValues  = [];

        foreach ($traits as $trait)
        {
            $traitRows = TraitsUser::where ('trait_id',$trait->id)->get();
            $values =[];
            foreach ($traitRows as $row){
                array_push($values,$row->value);
            }
            array_push($traitsWithValues,["name"=>$trait->name,"values"=>$values]);
        }
        return ["traits"=>$traitsWithValues];

    }
}
