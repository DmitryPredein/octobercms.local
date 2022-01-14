<?php namespace PredeinDmitry\MasterStat\Widgets;

use PredeinDmitry\MainCRM\Models\Employee;
use PredeinDmitry\MainCRM\Models\Job;
use PredeinDmitry\MasterStat\Models\Stat;
use Backend\Classes\WidgetBase;
use BackendAuth;

class MasterStatWidget extends WidgetBase {

    protected $defaultAlias = 'masterstatwidget';

    public function render() {
        $this->prepareVars($arg2 = 0);
        return $this->makePartial('masterstatwidget');
    }
    
    public function prepareVars($arg2) {
        $date = date("Y-m-d H:i:s");
        $userAr = BackendAuth::getUser();
        $this->vars['user'] = $userAr;
        
        $user = "";
        $userId = "";
        
        switch ($arg2) {
            case 0:
                if ($userAr->hasAccess('predeindmitry.masterstat.some_permission.admin')) {
                    $user = "-";
                    $userId = "0";
                }
                else{
                    $user = $userAr["first_name"]." ".$userAr["last_name"];
                    $userId = Employee::where("name", $user)->pluck("id")->first();
                }
                break;
            case 1:
                $user = post('name');
                $userId = Employee::where("name", $user)->pluck("id")->first();
                break;
            case 2:
                $user = post('name');
                $userId = Employee::where("name", $user)->pluck("id")->first();
                
                Stat::where("master_id", $userId)->where("closed_at", null)->update(['closed_at' => $date]);
                Stat::insert([
                    "master_id" => $userId,
                    "percent" => "50",
                    "created_at" => $date,
                ]);
                break;
            case 3:
                $user = post('name');
                $userId = Employee::where("name", $user)->pluck("id")->first();
                $money_penalty = Stat::get()->where("master_id", $userId)->where("closed_at", null)->pluck("money_penalty")->first();
                Stat::where("master_id", $userId)->where("closed_at", null)->update(['money_penalty' => $money_penalty+post('penalty')]);
                break;
            case 4:
                $user = post('name');
                $userId = Employee::where("name", $user)->pluck("id")->first();
                Stat::where("master_id", $userId)->where("closed_at", null)->update(['percent' => post('percent')]);
                break;
        }
        
        $date_close =  Stat::get()->where("master_id", $userId)->where("closed_at", null)->pluck("created_at")->first();
        $percent = Stat::get()->where("master_id", $userId)->where("closed_at", null)->pluck("percent")->first();
        $done_costArray = Job::get()->where("master_id", $userId)->where("updated_at", ">", $date_close)->where("status_job", "Выдан клиенту")->pluck("work_done")->toArray();
        $done_device = Job::get()->where("master_id", $userId)->where("updated_at", ">", $date_close)->where("status_job", "Выдан клиенту")->count();
        $done_cost = 0;
        foreach($done_costArray as $values){
            foreach($values as $value){
                $done_cost += $value["work_done_cost"];
            }
        }
        $done_cost = ($done_cost/100)*$percent;
        $this->vars['masterArray'] = Employee::where("position", "Мастер")->lists("name");
        $this->vars['date_close'] = $date_close;
        $this->vars['name'] = $user;
        $this->vars['percent'] = $percent;
        $this->vars['done_device'] = $done_device;
        $this->vars['done_cost'] = round($done_cost);
        $this->vars['return_device'] = Stat::get()->where("master_id", $userId)->where("closed_at", null)->pluck("return_device")->first();
        $this->vars['return_cost'] = Stat::get()->where("master_id", $userId)->where("closed_at", null)->pluck("return_cost")->first();
        $this->vars['money_penalty'] = Stat::get()->where("master_id", $userId)->where("closed_at", null)->pluck("money_penalty")->first();
        $this->vars['outcome'] = round($this->vars['done_cost']-$this->vars['return_cost']-$this->vars['money_penalty']);
    }
    
    public function onRefresh() {
        $this->prepareVars($arg2 = 1);
    }
    
    public function onCloseStat() {
        $this->prepareVars($arg2 = 2);
    }
    
    public function onDonePenalty() {
        $this->prepareVars($arg2 = 3);
    }
    
    public function onDonePrecent() {
        $this->prepareVars($arg2 = 4);
    }

    protected function loadAssets() {
        $this->addJs('js/masterstatwidget.js');
        $this->addCss('css/masterstatwidget.css');
    }
}
