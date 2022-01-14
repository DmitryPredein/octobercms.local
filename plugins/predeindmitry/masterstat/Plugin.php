<?php namespace PredeinDmitry\MasterStat;

use Backend;
use System\Classes\PluginBase;
use BackendAuth;

/**
 * MasterStat Plugin Information File
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
            'name'        => 'Статистика мастеров',
            'description' => 'Просмотр и изменение статистики для мастеров',
            'author'      => 'PredeinDmitry',
            'icon'        => 'icon-address-card'
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
    
    public $require = ['PredeinDmitry.MainCRM'];

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
            'PredeinDmitry\MasterStat\Components\MyComponent' => 'myComponent',
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
            'predeindmitry.masterstat.some_permission.master' => [
                'tab' => 'Статистика мастера',
                'label' => 'Клиентский доступ к статистике мастера'
            ],
            'predeindmitry.masterstat.some_permission.admin' => [
                'tab' => 'Статистика мастера',
                'label' => 'Административный доступ к статистике мастера'
            ]
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
            'masterstat' => [
                'label'       => 'Статистика',
                'url'         => Backend::url('predeindmitry/masterstat/stat'),
                'icon'        => 'icon-address-card',
                'permissions' => ['predeindmitry.masterstat.some_permission.master'],
                'order'       => 500,
                'sideMenu' => [
                    'stat' => [
                        'label'       => 'Статистика',
                        'url'         => Backend::url('predeindmitry/masterstat/stat'),
                        'icon'        => 'icon-user-circle-o',
                        'permissions' => ['predeindmitry.masterstat.some_permission.master'],
                        'order'       => 500,
                    ],
                ]
            ],
        ];
    }
}
