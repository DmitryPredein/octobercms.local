<?php namespace PredeinDmitry\MainCRM\FormWidgets;

use Backend\Classes\FormWidgetBase;
use PredeinDmitry\MainCRM\Models\LogJobCRM;
/**
 * Logging Form Widget
 */
class Logging extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'predeindmitry_maincrm_logging';

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
        return $this->makePartial('logging');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $model_id = $this->model->id;
        $this->vars['loggingArray'] = LogJobCRM::all()->where('job_id', $model_id)->toArray();
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/logging.css', 'PredeinDmitry.MainCRM');
        $this->addJs('js/logging.js', 'PredeinDmitry.MainCRM');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
