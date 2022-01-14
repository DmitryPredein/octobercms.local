<?php namespace PredeinDmitry\MainCRM\Widgets;

use Backend\Classes\WidgetBase;
use PredeinDmitry\MainCRM\Models\Job;
use PredeinDmitry\MainCRM\Models\Customer;
use PredeinDmitry\MainCRM\Models\Employee;
use PredeinDmitry\MainCRM\Models\Stock;
use BackendAuth;

class StatisticaMaster extends WidgetBase {

    protected $defaultAlias = 'statisticamaster';

    public function render() {
        $this->prepareVars();
        return $this->makePartial('statisticamaster');
    }
    
    public function prepareVars() {
        $userAr = BackendAuth::getUser();
        $user = $userAr["first_name"]." ".$userAr["last_name"];
        
        $userId = Employee::where("name", $user)->pluck("id")->first();
        
        $this->vars['JobLanding'] = Job::where('status_job', 'Не обработана')->count();
        
        $this->vars['JobCloseGarant'] = Job::where("master_id", $userId)->where("is_warranty", "Гарантийный")->count();
        
        $this->vars['Job'] = Job::where("master_id", $userId)->where('status_job', 'Отремонтирован')->count();
        
        $this->vars['JobCreateCount'] = Job::where("master_id", $userId)->where('status_job', '!=', 'Не обработана')->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d H:i:s')])->count();
        
        $this->vars['JobCloseCount'] = Job::where("master_id", $userId)->whereIn('status_job', ['Выдан клиенту', 'Выдан без ремонта'])->whereBetween('is_check_conditions', [date('Y-m-d 00:00:00'), date('Y-m-d H:i:s')])->count();
        
        $TreeDayCencel = date("Y-m-d H:i:s", mktime(date('H'), date('i'), date('s'), date('m'), date('d') - 3, date('Y')));
        $this->vars['JobOnRemont'] = Job::where("master_id", $userId)->whereIn('status_job', ['Передан мастеру', 'В процессе'])->where('is_check_conditions', '<', $TreeDayCencel)->count();
        
        $this->vars['JobOnDone'] = Job::where("master_id", $userId)->where('status_job', 'Отремонтирован')->where('is_check_conditions', '<', $TreeDayCencel)->count();
        
        $this->vars['JobTotal'] = Job::where("master_id", $userId)->whereIn('status_job', ['Передан мастеру', 'В процессе', 'Принят', 'Отремонтирован', 'Ожидает запчасть'])->count();
        
        $this->vars['JobFreeMaster'] = Job::where("master_id", null)->whereIn('status_job', ['Принят', 'Не обработана'])->count();
        
        $this->vars['JobMyax'] = Job::where('status_job', 'Не обработана')->where('type_job', 'myax.ru')->count();
    }
    
    
    public function onStaticFilter()
    {
        $this->vars["nameFilter"] = post("nameFilter");
        $FilterJob = post("FilterJob");
        $TreeDayCencel = date("Y-m-d H:i:s", mktime(date('H'), date('i'), date('s'), date('m'), date('d') - 3, date('Y')));
        $user = BackendAuth::getUser();
        $userRole = "superuser";
        $userName = $user["first_name"]." ".$user["last_name"];
        $userId = Employee::where("name", $userName)->pluck("id")->first();
        
        switch ($FilterJob) {
            case 'JobCloseGarant':
                $FilterJob = Job::where("is_warranty", "Гарантийный")->where("master_id", $userId)->get()->toArray();
                $this->vars['FilterJob'] = $FilterJob;
                break;
            case 'Job':         
                $FilterJob = Job::where('status_job', 'Отремонтирован')->where("master_id", $userId)->get()->toArray();
                $this->vars['FilterJob'] = $FilterJob;
                break;
            case 'JobLanding':
                $FilterJob = Job::where('status_job', 'Не обработана')->get()->toArray();
                $this->vars['FilterJob'] = $FilterJob;
                break;
            case 'JobTotal': 
                $FilterJob = Job::whereIn('status_job', ['Передан мастеру', 'В процессе', 'Принят', 'Отремонтирован', 'Ожидает запчасть'])->where("master_id", $userId)->get()->toArray();
                $this->vars['FilterJob'] = $FilterJob;
                break;
            case 'JobCreateCount':
                $FilterJob = Job::where('status_job', '!=', 'Не обработана')->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d H:i:s')])->where("master_id", $userId)->get()->toArray();
                $this->vars['FilterJob'] = $FilterJob;
                break;
            case 'JobCloseCount':
                $FilterJob = Job::whereIn('status_job', ['Выдан клиенту', 'Выдан без ремонта'])->whereBetween('is_check_conditions', [date('Y-m-d 00:00:00'), date('Y-m-d H:i:s')])->where("master_id", $userId)->get()->toArray();
                $this->vars['FilterJob'] = $FilterJob;
                break;
            case 'JobFreeRemont':
                $FilterJob = Job::whereNull('master_id')->whereIn('status_job', ['Принят', 'Не обработана'])->get()->toArray();
                $this->vars['FilterJob'] = $FilterJob;
                break;
            case 'JobOnRemont':
                $FilterJob = Job::whereIn('status_job', ['Передан мастеру', 'В процессе'])->where('is_check_conditions', '<', $TreeDayCencel)->where("master_id", $userId)->get()->toArray();
                $this->vars['FilterJob'] = $FilterJob;
                break;
            case 'JobOnDone':
                $FilterJob = Job::where('status_job', 'Отремонтирован')->where('is_check_conditions', '<', $TreeDayCencel)->where("master_id", $userId)->get()->toArray();
                $this->vars['FilterJob'] = $FilterJob;
                break;
            case 'JobMyax':
                $FilterJob = Job::where('status_job', 'Не обработана')->where('type_job', 'myax.ru')->get()->toArray();
                $this->vars['FilterJob'] = $FilterJob;
                break;
        }
        
        return $this->makePartial('staticfilter');
    }

    protected function loadAssets() {
        $this->addJs('js/statisticamaster.js');
        $this->addCss('css/statisticamaster.css');
    }
}
