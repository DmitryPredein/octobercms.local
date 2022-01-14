<?php namespace PredeinDmitry\MainCRM\Widgets;

use Backend\Classes\WidgetBase;
use PredeinDmitry\MainCRM\Models\JobLanding;
use PredeinDmitry\MainCRM\Models\JobCloseDoneRemont;
use PredeinDmitry\MainCRM\Models\JobCloseNotRemont;
use PredeinDmitry\MainCRM\Models\JobCloseGarant;
use PredeinDmitry\MainCRM\Models\Job;
use PredeinDmitry\MainCRM\Models\Customer;
use PredeinDmitry\MainCRM\Models\Employee;
use PredeinDmitry\MainCRM\Models\Stock;

class StatisticaManager extends WidgetBase {

    protected $defaultAlias = 'statisticamanager';

    public function render() {
        $this->prepareVars();
        return $this->makePartial('statisticamanager');
    }
    
    public function prepareVars() {
        $this->vars['JobLanding'] = Job::where('status_job', 'Не обработана')->count();
        
        $this->vars['JobCloseGarant'] = Job::where("is_warranty", "Гарантийный")->count();
        
        $this->vars['Job'] = Job::where('status_job', 'Отремонтирован')->count();
        
        $this->vars['JobCreateCount'] = Job::where('status_job', '!=', 'Не обработана')->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d H:i:s')])->count();
        
        $this->vars['JobCloseCount'] = Job::whereIn('status_job', ['Выдан клиенту', 'Выдан без ремонта'])->whereBetween('is_check_conditions', [date('Y-m-d 00:00:00'), date('Y-m-d H:i:s')])->count();
        
        $TreeDayCencel = date("Y-m-d H:i:s", mktime(date('H'), date('i'), date('s'), date('m'), date('d') - 3, date('Y')));
        $this->vars['JobOnRemont'] = Job::whereIn('status_job', ['Передан мастеру', 'В процессе'])->where('is_check_conditions', '<', $TreeDayCencel)->count();
        
        $this->vars['JobOnDone'] = Job::where('status_job', 'Отремонтирован')->where('is_check_conditions', '<', $TreeDayCencel)->count();
        
        $this->vars['JobTotal'] = Job::whereIn('status_job', ['Передан мастеру', 'В процессе', 'Принят', 'Отремонтирован', 'Ожидает запчасть'])->count();
        
        $this->vars['JobMyax'] = Job::where('status_job', 'Не обработана')->where('type_job', 'myax.ru')->count();
    }
    
    public function onStaticFilter()
    {
        $this->vars["nameFilter"] = post("nameFilter");
        $FilterJob = post("FilterJob");
        $TreeDayCencel = date("Y-m-d H:i:s", mktime(date('H'), date('i'), date('s'), date('m'), date('d') - 3, date('Y')));
        
        switch ($FilterJob) {
            case 'JobCloseGarant':
                $FilterJob = Job::where("is_warranty", "Гарантийный")->get()->toArray();
                $this->vars['FilterJob'] = $FilterJob;
                break;
            case 'Job':
                $FilterJob = Job::where("status_job", "Отремонтирован")->get()->toArray();
                $this->vars['FilterJob'] = $FilterJob;
                break;
            case 'JobLanding':
                $FilterJob = Job::where('status_job', 'Не обработана')->get()->toArray();
                $this->vars['FilterJob'] = $FilterJob;
                break;
            case 'JobTotal':
                $FilterJob = Job::whereIn('status_job', ['Передан мастеру', 'В процессе', 'Принят', 'Отремонтирован', 'Ожидает запчасть'])->get()->toArray();
                $this->vars['FilterJob'] = $FilterJob;
                break;
            case 'JobCreateCount':
                $FilterJob = Job::where('status_job', '!=', 'Не обработана')->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d H:i:s')])->get()->toArray();
                $this->vars['FilterJob'] = $FilterJob;
                break;
            case 'JobCloseCount':
                $FilterJob = Job::whereIn('status_job', ['Выдан клиенту', 'Выдан без ремонта'])->whereBetween('is_check_conditions', [date('Y-m-d 00:00:00'), date('Y-m-d H:i:s')])->get()->toArray();
                $this->vars['FilterJob'] = $FilterJob;
                break;
            case 'JobOnRemont':
                $FilterJob = Job::whereIn('status_job', ['Передан мастеру', 'В процессе'])->where('is_check_conditions', '<', $TreeDayCencel)->get()->toArray();
                $this->vars['FilterJob'] = $FilterJob;
                break;
            case 'JobOnDone':
                $FilterJob = Job::where('status_job', 'Отремонтирован')->where('is_check_conditions', '<', $TreeDayCencel)->get()->toArray();
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
        $this->addJs('js/statisticamanager.js');
        $this->addCss('css/statisticamanager.css');
    }
}
