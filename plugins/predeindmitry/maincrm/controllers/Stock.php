<?php namespace PredeinDmitry\MainCRM\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Stock Back-end Controller
 */
class Stock extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('PredeinDmitry.MainCRM', 'maincrm', 'stock');
    }
}
