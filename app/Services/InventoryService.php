<?php

namespace App\Services;

use App\Common\SharedMessage;
use App\Models\Inventory;
use App\Repositories\Eloquent\InventoryRepository;
use App\Services\Shared\BaseService;
use Illuminate\Support\Facades\Auth;

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
//            case '1':
//
//                break;
        }

    }
    public function doVFI (Inventory $inventory,$payload)
    {
//                $myfile = fopen("inven.txt", "w") or die("Unable to open file!");
//                $myJSON=json_encode($payload[0]['answer']);
//                fwrite($myfile, $myJSON);
//                fclose($myfile);
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
}
