<?php namespace PredeinDmitry\MainCRM\FormWidgets;

use Backend;
use Backend\Classes\FormWidgetBase;
use PredeinDmitry\MainCRM\Models\Job;
use PredeinDmitry\Cashbox\Models\CashboxHistory;
use PredeinDmitry\Cashbox\Models\CashboxAxmobi;
use PredeinDmitry\MainCRM\Models\Employee;
use PredeinDmitry\MainCRM\Models\LogJobCRM;
use BackendAuth;

/**
 * GarantJob Form Widget
 */
class GarantJob extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'predeindmitry_maincrm_garant_job';

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
        return $this->makePartial('garantjob');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        //$this->vars['name'] = $this->formField->getName();
        //$this->vars['value'] = $this->getLoadValue();
        //$this->vars['model'] = $this->model;
        $this->vars['check_garant'] = $this->model->check_garant;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/garantjob.css', 'PredeinDmitry.MainCRM');
        $this->addJs('js/garantjob.js', 'PredeinDmitry.MainCRM');
    }
    
    public function onOpenGarantJob()
    {
        $nameCheckJobGarant = Job::where("is_warranty", "Гарантийный")->where("name_id", $this->model->name!=null?$this->model->name->id:null);
        $nameCheckJobGarantCount = $nameCheckJobGarant->count();
        $nameCheckJobGarantId = $nameCheckJobGarant->pluck("id")->last();
        
        $this->vars["checkGarantAgaint"] = $nameCheckJobGarantCount==0?null:"Клиент ".$this->model->name->name." уже оставлял заявку по гарантии № ";
        $this->vars["nameCheckJobGarantId"] = $nameCheckJobGarantId;
        return $this->makePartial('note');
    }
    public function onGarantJob()
    {
        $userBD = BackendAuth::getUser();
        
        switch ($this->model->payment_method) {
            case "Безналичный":
                CashboxHistory::insert([
                    'user' => $userBD["last_name"]." ".$userBD["first_name"],
                    'komment' => 'Возврат по заявке №'.$this->model->id,
                    'return_beznal' => $this->model->cost,
                    'stock' => $this->model->stock->stock,
                    'created_at' => date("Y-m-d H:i:s")
                 ]);
                $cahs = CashboxAxmobi::get()->where("stock", $this->model->stock->stock)->pluck('cahs')->first();
                $beznal = CashboxAxmobi::get()->where("stock", $this->model->stock->stock)->pluck('beznal')->first();
                CashboxAxmobi::where("stock", $this->model->stock->stock)->update([
                            'cahs' => $cahs-$this->model->cost,
                            'beznal' => $beznal-$this->model->cost
                        ]);
                unset($cahs);
                unset($beznal);
                break;
            case "Наличные":
                CashboxHistory::insert([
                    'user' => $userBD["last_name"]." ".$userBD["first_name"],
                    'komment' => 'Возврат по заявке №'.$this->model->id,
                    'return_nal' => $this->model->cost,
                    'stock' => $this->model->stock->stock,
                    'created_at' => date("Y-m-d H:i:s")
                 ]);
                $cahs = CashboxAxmobi::get()->where("stock", $this->model->stock->stock)->pluck('cahs')->first();
                $nal = CashboxAxmobi::get()->where("stock", $this->model->stock->stock)->pluck('nal')->first();
                CashboxAxmobi::where("stock", $this->model->stock->stock)->update([
                            'cahs' => $cahs-$this->model->cost,
                            'nal' => $nal-$this->model->cost
                        ]);
                unset($cahs);
                unset($nal);
                break;
            case "Смешаное":
                $array = explode(":::", $this->model->costpayMethod);
                CashboxHistory::insert([
                    'user' => $userBD["last_name"]." ".$userBD["first_name"],
                    'komment' => 'Возврат по заявке №'.$this->model->id,
                    'return_beznal' => $array[1],
                    'return_nal' => $array[0],
                    'stock' => $this->model->stock->stock,
                    'created_at' => date("Y-m-d H:i:s")
                 ]);
                $cahs = CashboxAxmobi::get()->where("stock", $this->model->stock->stock)->pluck('cahs')->first();
                $nal = CashboxAxmobi::get()->where("stock", $this->model->stock->stock)->pluck('nal')->first();
                $beznal = CashboxAxmobi::get()->where("stock", $this->model->stock->stock)->pluck('beznal')->first();
                CashboxAxmobi::where("stock", $this->model->stock->stock)->update([
                            'cahs' => $cahs-$array[0]-$array[1],
                            'nal' => $nal-$array[0],
                            'beznal' => $beznal-$array[1]
                        ]);
                unset($cahs);
                unset($beznal);
                unset($nal);
                unset($array);
                break;
        }
        
        $task = Job::all()->where('id', $this->model->id)->first();
    
        $newTask = $task->replicate();
        $newTask->is_warranty = "Гарантийный";
        $newTask->check_garant = $this->model->id;
        $newTask->used_detail = null;
        $newTask->work_done = null;
        $newTask->cost = 0;
        $newTask->status_job = "Принят";
        $newTask->descriptions = post('garantnote');
        $newTask->notehzzahcem = null;
        $newTask->discount_work = 0;
        $newTask->discount_details = 0;
        $newTask->save();
        $taskId = $newTask->id;
            
            
        Job::where('id', $this->model->id)->update(['check_garant' => $taskId]);
            
        LogJobCRM::insert([
            "job_id" => $taskId,
            "logging" => "Менеджер ".$userBD["last_name"]." ".$userBD["first_name"]." открыл гарантийную заявку по заказу №".$this->model->id,
            "created_at" => date("Y-m-d H:i:s")
        ]);
        
        return Backend::redirect('predeindmitry/maincrm/job');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return \Backend\Classes\FormField::NO_SAVE_DATA;
    }
}
