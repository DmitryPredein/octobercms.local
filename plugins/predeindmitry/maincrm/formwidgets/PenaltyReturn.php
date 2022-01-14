<?php namespace PredeinDmitry\MainCRM\FormWidgets;

use Backend;
use Backend\Classes\FormWidgetBase;
use PredeinDmitry\MainCRM\Models\Job;
use PredeinDmitry\MasterStat\Models\Stat;
use BackendAuth;


class PenaltyReturn extends FormWidgetBase
{
    public function init()
    {
    }

    public function render()
    {
        $this->vars["info"] = Job::where("id", $this->model->id)->pluck("info")->first()!=NULL?true:false;
        $this->vars["checkGarant"] = Job::where("id", $this->model->id)->pluck("check_garant")->first()!=NULL?true:false;
        
        return $this->makePartial('penaltyreturn');
    }

    public function prepareVars()
    {
        
    }

    public function loadAssets()
    {
        $this->addCss('css/penaltyreturn.css', 'PredeinDmitry.MainCRM');
        $this->addJs('js/penaltyreturn.js', 'PredeinDmitry.MainCRM');
    }

    public function onPenaltyReturnPart1()
    {
        $percent = Stat::get()->where("master_id", $this->model->master->id)->where("closed_at", null)->pluck("percent")->first();
        $this->vars['master'] = $this->model->master->name;
        $work_done_cost = 0;
        foreach($this->model->work_done as $value){
            $work_done_cost += $value["work_done_cost"];
        }
        $this->vars['work_done_cost'] = $work_done_cost/100*$percent;
        
        return $this->makePartial('penaltyreturn_part1');
    }
    public function onPenaltyReturnPart2()
    {
        $returnCost = Stat::where("master_id", $this->model->master->id)->where("closed_at", null)->pluck("return_cost")->first();
        $returnValue = Stat::where("master_id", $this->model->master->id)->where("closed_at", null)->pluck("return_device")->first();
        
        Stat::where("master_id", $this->model->master->id)
            ->where("closed_at", null)
            ->update([
                'return_cost' => $returnCost+post('costPenalty'),
                'return_device' => $returnValue+1
            ]);
            
        Job::where("id", $this->model->id)
            ->update([
                'info' => "true",
            ]);
        
        return $this->makePartial('penaltyreturn_part2');
    }
    public function onPenaltyReturnPart3()
    {
        $used_detail = $this->model->used_detail;
        $this->vars['used_detail'] = $used_detail;

        return $this->makePartial('penaltyreturn_part3');
    }
    public function onPenaltyReturnPartFinal()
    {
        $returnCost = Stat::where("master_id", $this->model->master->id)->where("closed_at", null)->pluck("return_cost")->first();
        
        Stat::where("master_id", $this->model->master->id)
            ->where("closed_at", null)
            ->update([
                'return_cost' => $returnCost+post('cost'),
            ]);
            
        return Backend::redirect('predeindmitry/maincrm/job');
    }

    public function getSaveValue($value)
    {
        return \Backend\Classes\FormField::NO_SAVE_DATA;
    }
}
