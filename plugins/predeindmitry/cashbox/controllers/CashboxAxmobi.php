<?php namespace PredeinDmitry\Cashbox\Controllers;

use BackendMenu;
use \PredeinDmitry\Cashbox\Widgets\ManageCashbox;
use Backend\Classes\Controller;

/**
 * Cashbox Axmobi Back-end Controller
 */
class CashboxAxmobi extends Controller
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
        
        $CashboxWidget = new ManageCashbox($this);
        $CashboxWidget->alias = 'managecashbox';
        $CashboxWidget->bindToController();

        BackendMenu::setContext('PredeinDmitry.Cashbox', 'cashbox', 'cashboxaxmobi');
    }
}
