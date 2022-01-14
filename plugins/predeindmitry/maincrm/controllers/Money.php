<?php namespace PredeinDmitry\MainCRM\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Money Back-end Controller
 */
class Money extends Controller
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

        BackendMenu::setContext('PredeinDmitry.MainCRM', 'maincrm', 'money');
    }
}
