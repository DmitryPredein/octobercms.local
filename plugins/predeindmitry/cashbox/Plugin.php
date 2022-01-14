<?php namespace PredeinDmitry\Cashbox;

use Backend;
use System\Classes\PluginBase;

/**
 * Cashbox Plugin Information File
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
            'name'        => 'Cashbox',
            'description' => 'Система учёта денег',
            'author'      => 'PredeinDmitry',
            'icon'        => 'icon-money'
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
            'PredeinDmitry\Cashbox\Components\MyComponent' => 'myComponent',
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
            'predeindmitry.cashbox.some_permission' => [
                'tab' => 'Cashbox',
                'label' => 'Some permission'
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
            'cashbox' => [
                'label'       => 'Касса',
                'url'         => Backend::url('predeindmitry/cashbox/cashboxaxmobi'),
                'icon'        => 'icon-money',
                'permissions' => ['predeindmitry.cashbox.*'],
                'order'       => 500,
                'sideMenu'    => [
                    'cashboxaxmobi'         => [
                        'label'       => 'Касса',
                        'icon'        => 'icon-money',
                        'url'         => \Backend::url('predeindmitry/cashbox/cashboxaxmobi'),
                        'permissions' => ['predeindmitry.cashbox.*'],
                        'order'       => 500,
                    ],
                ],
            ],
        ];
    }
}
