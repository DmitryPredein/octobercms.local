<?php namespace PredeinDmitry\MainCRM\FormWidgets;

use Backend\Classes\FormWidgetBase;
use PredeinDmitry\MainCRM\Models\Employee;
use PredeinDmitry\MainCRM\Models\MessageLog;
use PredeinDmitry\MainCRM\Models\Job;
use PredeinDmitry\MainCRM\Models\LogJobCRM;
use BackendAuth;
/**
 * MessageLogFormWidget Form Widget
 */
class MessageLogFormWidget extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'predeindmitry_maincrm_message_log_form_widget';

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
        return $this->makePartial('messagelogformwidget');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $message_idParse = explode(",", $this->model->message_id);
        $messageResult = collect([]);
        if($this->model->message_id){
            foreach($message_idParse as $value){
                $messageResult->push([MessageLog::get()->where('id', $value)->pluck('employee')->first(), MessageLog::get()->where('id', $value)->pluck('message')->first(), MessageLog::get()->where('id', $value)->pluck('created_at')->first()]);
            };
        }
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
        $this->vars['message'] = $messageResult;
        $this->vars['user'] = BackendAuth::getUser();
        $this->vars['asd'] = $this->model->message_id;
    }
    public function onAddMessage()
    {
        if(post('message')){
            $messageAdd = post('message');
            $valueParse = explode(":::", $messageAdd);
            $user = BackendAuth::getUser();
            if($messageAdd != null && count($valueParse) == 2){
                $MessageLogId = MessageLog::insertGetId([
                    'id' => NULL,
                    'employee' => $valueParse[0],
                    'message' => $valueParse[1],
                    'created_at' => date("Y-m-d H:i:s")
                ]);
                Job::where("id", $this->model->id)->update([
                    "message_id" => $this->model->message_id.",".$MessageLogId,
                ]);
                LogJobCRM::insert([
                    "job_id" => $this->model->id,
                    "logging" => $user["last_name"]." ".$user["first_name"]." написал(а) сообщения в чат",
                    "created_at" => date("Y-m-d H:i:s"),
                ]);
            }
        }
        $this->prepareVars();
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/messagelogformwidget.css', 'PredeinDmitry.MainCRM');
        $this->addJs('js/messagelogformwidget.js', 'PredeinDmitry.MainCRM');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return \Backend\Classes\FormField::NO_SAVE_DATA;
    }
}
