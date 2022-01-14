<?php namespace PredeinDmitry\MasterStat\Controllers;

use BackendMenu;
use \PredeinDmitry\MasterStat\Widgets\MasterStatWidget;
use Backend\Classes\Controller;
use PredeinDmitry\MainCRM\Models\Employee;
use BackendAuth;

/**
 * Stat Back-end Controller
 */
class Stat extends Controller
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
    
    public function listExtendQuery($query)
    {
        $userAr = BackendAuth::getUser();
        $userId = "";
        if (!($userAr->hasAccess('predeindmitry.masterstat.some_permission.admin'))) {
            $user = $userAr["first_name"]." ".$userAr["last_name"];
            $userId = Employee::where("name", $user)->pluck("id")->first();
            $query->where("master_id", $userId);
        }
        
    }
    public function __construct()
    {
        parent::__construct();
        
        $StatWidget = new MasterStatWidget($this);
        $StatWidget->alias = 'masterstatwidget';
        $StatWidget->bindToController();

        BackendMenu::setContext('PredeinDmitry.MasterStat', 'masterstat', 'stat');
    }
    
    
}
