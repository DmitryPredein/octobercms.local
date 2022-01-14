<?php namespace PredeinDmitry\MainCRM\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * PatternLock Form Widget
 */
class PatternLock extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'predeindmitry_maincrm_pattern_lock';

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
        return $this->makePartial('patternlock');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['patternlock'] = $this->model->patternlock;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/patternlock.css', 'PredeinDmitry.MainCRM');
        $this->addJs('js/patternlock.js', 'PredeinDmitry.MainCRM');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
