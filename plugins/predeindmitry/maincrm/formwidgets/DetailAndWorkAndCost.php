<?php namespace PredeinDmitry\MainCRM\FormWidgets;

use Backend;
use Backend\Classes\FormWidgetBase;
use PredeinDmitry\MainCRM\Models\JobCloseGarant;
use PredeinDmitry\MainCRM\Models\Job;
use PredeinDmitry\MainCRM\Models\Employee;
use PredeinDmitry\MainCRM\Models\LogJobCRM;
use BackendAuth;

/**
 * GarantJob Form Widget
 */
class DetailAndWorkAndCost extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'predeindmitry_maincrm_detail_and_work_and_cost';

    /**
     * @inheritDoc
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('detailandworkandcost');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        if($this->model->is_warranty == "Гарантийный"){
            $this->vars['status_job'] = $this->model->status_job;
            $this->vars['is_warranty'] = $this->model->is_warranty;
            $check_garant = $this->model->check_garant;
            $this->vars['check_garant'] = $check_garant;
            $this->vars['work_done'] = Job::get()->where("id", $this->model->check_garant)->pluck("work_done")->toArray();
            $this->vars['used_detail'] = Job::get()->where("id", $this->model->check_garant)->pluck("used_detail")->toArray();
            $this->vars['cost'] = Job::get()->where("id", $this->model->check_garant)->pluck("cost")->first();
            
            $this->vars['work_done2'] = $this->model->work_done;
            $this->vars['used_detail2'] = $this->model->used_detail;
        }
        else{
            $this->vars['is_warranty'] = $this->model->is_warranty;
            $this->vars['status_job'] = $this->model->status_job;
            $this->vars['work_done'] = $this->model->work_done;
            $this->vars['used_detail'] = $this->model->used_detail;
            $this->vars['status_job'] = $this->model->status_job;
        }
        
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/detailandworkandcost.css', 'PredeinDmitry.MainCRM');
        $this->addJs('js/detailandworkandcost.js', 'PredeinDmitry.MainCRM');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return \Backend\Classes\FormField::NO_SAVE_DATA;
    }
}
