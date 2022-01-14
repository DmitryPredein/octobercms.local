<?php namespace PredeinDmitry\MainCRM\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Log Job C R M Back-end Controller
 */
class LogJobCRM extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('PredeinDmitry.MainCRM', 'maincrm', 'logjobcrm');
    }
}
