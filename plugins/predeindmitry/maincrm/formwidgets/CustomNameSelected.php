<?php namespace PredeinDmitry\MainCRM\FormWidgets;

use Backend\Classes\FormWidgetBase;
use PredeinDmitry\MainCRM\Models\Customer;
use PredeinDmitry\MainCRM\Models\LogJobCRM;
use BackendAuth;

/**
 * CustomNameSelected Form Widget
 */
class CustomNameSelected extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'predeindmitry_maincrm_custom_name_selected';

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
        return $this->makePartial('customnameselected');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
        $this->vars['customer'] = Customer::get();
        $this->vars['context'] = $this->formField->context;
        $this->vars['readOnly'] = $this->formField->readOnly;
        if($this->formField->context == "update"){
            $this->vars['telCustomer'] = Customer::where("id", $this->model->name_id)->pluck("tel")->first();
            $this->vars['nameCustomer'] = Customer::where("id", $this->model->name_id)->pluck("name")->first();
        }
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/customnameselected.css', 'PredeinDmitry.MainCRM');
        $this->addJs('js/customnameselected.js', 'PredeinDmitry.MainCRM');
        $this->addJs('js/jquery.maskedinput.min.js', 'PredeinDmitry.MainCRM');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
            if($value != null){
                $valueParseCustomer = explode(":::", $value);
                if($valueParseCustomer[0] == "custom"){
                    $id = Customer::insertGetId(["id" => null, "name" => $valueParseCustomer[2].' '.$valueParseCustomer[3].' '.$valueParseCustomer[4], "tel" => $valueParseCustomer[1], "address" => null, "mail" => null, "created_at" => date("Y-m-d H:i:s"), "updated_at" => date("Y-m-d H:i:s")]);
                    return $id;
                }
                else if($valueParseCustomer[0] == "update"){
                    $userAr = BackendAuth::getUser();
                    $user = $userAr["last_name"]." ".$userAr["first_name"];
                    
                    $nameBD = Customer::where('id', $valueParseCustomer[1])->pluck("name")->first();
                    $telBD = Customer::where('id', $valueParseCustomer[1])->pluck("tel")->first();
                    
                    $id = Customer::where('id', $valueParseCustomer[1])->update(["name" => $valueParseCustomer[2], "tel" => $valueParseCustomer[3], "updated_at" => date("Y-m-d H:i:s")]);
                    
                    if($nameBD != $valueParseCustomer[2]){
                         LogJobCRM::insert([
                            "job_id" => $this->model->id,
                            "logging" => $user." изменил(а) ФИО клиента <br />До: ".$nameBD."<br />После: ".$valueParseCustomer[2]."<br />",
                            "created_at" => date("Y-m-d H:i:s"),
                        ]);
                    }
                    if($telBD != $valueParseCustomer[3]){
                         LogJobCRM::insert([
                            "job_id" => $this->model->id,
                            "logging" => $user." изменил(а) Номер клиента <br />До: ".$telBD."<br />После: ".$valueParseCustomer[3]."<br />",
                            "created_at" => date("Y-m-d H:i:s"),
                        ]);
                    }
                    
                    return $valueParseCustomer[1];
                }
                else if($valueParseCustomer[0] == "select"){
                    return $valueParseCustomer[1];
                }
                else{
                    return $valueParseCustomer[0];
                }
            }
            else{
                return null;
            }
    }
}
