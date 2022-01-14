<?php namespace PredeinDmitry\MainCRM;

use Backend;
use System\Classes\PluginBase;

/**
 * MainCRM Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'MainCRM',
            'description' => 'CRM System Axmoby',
            'author'      => 'PredeinDmitry',
            'icon'        => 'icon-binoculars'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        
        
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'PredeinDmitry\MainCRM\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {

        return [
            'predeindmitry.maincrm.some_permission.developer' => [
                'tab' => 'MainCRM',
                'label' => 'Доступ к разрабатываемому контенту'
            ],
            'predeindmitry.maincrm.some_permission.manager_statica' => [
                'tab' => 'MainCRM',
                'label' => 'Статистика менеджера'
            ],
            'predeindmitry.maincrm.some_permission' => [
                'tab' => 'MainCRM',
                'label' => 'Доступ к заявкам'
            ],
            'predeindmitry.maincrm.some_permission.exixt' => [
                'tab' => 'MainCRM',
                'label' => 'Расширенный доступ к CRM'
            ],
            'predeindmitry.maincrm.widgets.cost_of_master' => [
                'label' => 'Просмотр личной статистики',
                'tab' => 'Процент мастера',
            ],
            'predeindmitry.maincrm.widgets.cost_of_master_admin' => [
                'label' => 'Просмотр статистики всех мастеров',
                'tab' => 'Процент мастера',
            ],
            'predeindmitry.maincrm.some_permission.Delete' => [
                'label' => 'Удаление контента',
                'tab' => 'MainCRM',
            ],
            'predeindmitry.maincrm.some_permission.AddJob' => [
                'label' => 'Создание заявки',
                'tab' => 'MainCRM',
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {

        return [
            'maincrm' => [
                'label'       => 'CRM',
                'url'         => Backend::url('predeindmitry/maincrm/job'),
                'icon'        => 'icon-binoculars',
                'permissions' => ['predeindmitry.maincrm.*'],
                'order'       => 500,

                'sideMenu'    => [
                    'job'         => [
                        'label'       => 'Заявки',
                        'icon'        => 'icon-suitcase',
                        'url'         => \Backend::url('predeindmitry/maincrm/job'),
                        'permissions' => ['predeindmitry.maincrm.*'],
                        'order'       => 500,
                    ],
                    'devicemodel' => [
                        'label'       => 'Модели',
                        'icon'        => 'icon-mobile',
                        'url'         => \Backend::url('predeindmitry/maincrm/devicemodel'),
                        'permissions' => ['predeindmitry.maincrm.some_permission.exixt'],
                        'order'       => 505,
                    ],
                    'employee' => [
                        'label'       => 'Сотрудники',
                        'icon'        => 'icon-users',
                        'url'         => \Backend::url('predeindmitry/maincrm/employee'),
                        'permissions' => ['predeindmitry.maincrm.some_permission.exixt'],
                        'order'       => 506,
                    ],
                    'customer' => [
                        'label'       => 'Клиенты',
                        'icon'        => 'icon-user',
                        'url'         => \Backend::url('predeindmitry/maincrm/customer'),
                        'permissions' => ['predeindmitry.maincrm.some_permission.exixt'],
                        'order'       => 507,
                    ],
                    'stock'         => [
                        'label'       => 'Склады',
                        'icon'        => 'icon-cubes',
                        'url'         => \Backend::url('predeindmitry/maincrm/stock'),
                        'permissions' => ['predeindmitry.maincrm.some_permission.exixt'],
                        'order'       => 508,
                    ],
                    'logjobcrm'         => [
                        'label'       => 'Логи',
                        'icon'        => 'icon-cubes',
                        'url'         => \Backend::url('predeindmitry/maincrm/logjobcrm'),
                        'permissions' => ['predeindmitry.maincrm.some_permission.exixt'],
                        'order'       => 509,
                    ],
                ]
            ]
        ];
    }
    public function registerListColumnTypes() {
        return [
            'fio' => [$this, 'evalFIOListColumn'],
        ];
    }
    public function evalFIOListColumn($value, $column, $record) {
        $fullNameArray = explode(" ", $value);
        
        $firstName = isset($fullNameArray[0]) == true ? $fullNameArray[0] : "";
        $name = isset($fullNameArray[1]) == true ? $fullNameArray[1] : "";
        $lastName = isset($fullNameArray[2]) == true ? $fullNameArray[2] : "";
        
        $nameirstSimbol = isset($name[0]) == true ? mb_substr($name,0,1,'UTF-8')."."  : "";
        $lastNameirstSimbol = isset($lastName[0]) == true ? mb_substr($lastName,0,1,'UTF-8')."." : "";
        
        return "<div class='fullNameList' data-name='$value'><span>$firstName</span> <span>$nameirstSimbol</span> <span>$lastNameirstSimbol</span></div>";
    
    }
    public function registerReportWidgets()
    {
        return [
         //   'PredeinDmitry\MainCRM\ReportWidgets\CRMWidget' => [
         //        'label'   => 'Количество принятых устройств',
         //       'context' => 'dashboard',
         //    ],
        //     'PredeinDmitry\MainCRM\ReportWidgets\CostOfMaster' => [
        //         'label'   => 'Процент мастера',
        //         'context' => 'dashboard',
        //         'permissions' => [
        //             'predeindmitry.maincrm.widgets.cost_of_master',
        //         ],
        //     ],
        //     'PredeinDmitry\MainCRM\ReportWidgets\WorkCalendar' => [
        //         'label'   => 'Рабочий календарь',
        //         'context' => 'dashboard',
        //     ],
        //     'PredeinDmitry\MainCRM\ReportWidgets\CRMWidgetServiceAndDetails' => [
        //         'label'   => 'Сумма денег за услуги и детали',
        //         'context' => 'dashboard',
        //     ],
        //     'PredeinDmitry\MainCRM\ReportWidgets\CRMWidgetServiceAndDetails2' => [
        //         'label'   => 'Сумма денег за услуги и детали2',
        //         'context' => 'dashboard',
        //     ],
            'PredeinDmitry\MainCRM\ReportWidgets\WorkDoneMaster' => [
                'label'   => 'Статистика мастера',
                'context' => 'dashboard',
            ],
        ];
    }
    public function registerFormWidgets()
    {
        return [
            'PredeinDmitry\MainCRM\FormWidgets\PrintButton' => [
                'label'   => 'predeindmitry_maincrm_print_button',
                'code' => 'printbutton',
            ],
            'PredeinDmitry\MainCRM\FormWidgets\PatternLock' => [
                'label'   => 'predeindmitry_maincrm_pattern_lock',
                'code' => 'patternlock',
            ],
            'PredeinDmitry\MainCRM\FormWidgets\DetailAndWork' => [
                'label'   => 'predeindmitry_maincrm_detail_and_work',
                'code' => 'detailandwork',
            ],
            'PredeinDmitry\MainCRM\FormWidgets\DetailAndWork2' => [
                'label'   => 'predeindmitry_maincrm_detail_and_work2',
                'code' => 'detailandwork2',
            ],
            'PredeinDmitry\MainCRM\FormWidgets\MessageLogFormWidget' => [
                'label'   => 'predeindmitry_maincrm_message_log_form_widget',
                'code' => 'messagelogformwidget',
            ],
            'PredeinDmitry\MainCRM\FormWidgets\CustomDevice' => [
                'label'   => 'predeindmitry_maincrm_custom_device',
                'code' => 'customdevice',
            ],
            'PredeinDmitry\MainCRM\FormWidgets\CustomNameSelected' => [
                'label'   => 'predeindmitry_maincrm_custom_name_selected',
                'code' => 'customnameselected',
            ],
            'PredeinDmitry\MainCRM\FormWidgets\MigrateJobLanding' => [
                'label'   => 'predeindmitry_maincrm_migrate_job_landing',
                'code' => 'migratejoblanding',
            ],
            'PredeinDmitry\MainCRM\FormWidgets\Logging' => [
                'label'   => 'predeindmitry_maincrm_logging',
                'code' => 'logging',
            ],
            'PredeinDmitry\MainCRM\FormWidgets\GarantJob' => [
                'label'   => 'predeindmitry_maincrm_garant_job',
                'code' => 'garantjob',
            ],
            'PredeinDmitry\MainCRM\FormWidgets\DetailAndWorkAndCost' => [
                'label'   => 'predeindmitry_maincrm_detail_and_work_and_cost',
                'code' => 'detailandworkandcost',
            ],
            'PredeinDmitry\MainCRM\FormWidgets\PrintButtonClose' => [
                'label'   => 'predeindmitry_maincrm_dprint_button_close',
                'code' => 'printbuttonclose',
            ],
        ];
    }
}
