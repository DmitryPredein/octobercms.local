<?php namespace PredeinDmitry\MainCRM\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * ManagerForm Form Widget
 */
class ManagerForm extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'predeindmitry_maincrm_manager_form';

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
        return $this->makePartial('managerform');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/managerform.css', 'PredeinDmitry.MainCRM');
        $this->addJs('js/managerform.js', 'PredeinDmitry.MainCRM');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
