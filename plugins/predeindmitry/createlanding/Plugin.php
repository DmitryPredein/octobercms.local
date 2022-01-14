<?php namespace PredeinDmitry\CreateLanding;

use Backend;
use System\Classes\PluginBase;

/**
 * CreateLanding Plugin Information File
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
            'name'        => 'CreateLanding',
            'description' => 'Плагин для создание лэндингов',
            'author'      => 'PredeinDmitry',
            'icon'        => 'icon-leaf'
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
            'PredeinDmitry\CreateLanding\Components\MyComponent' => 'myComponent',
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
            'predeindmitry.createlanding.some_permission' => [
                'tab' => 'CreateLanding',
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
            'createlanding' => [
                'label'       => 'CreateLanding',
                'url'         => Backend::url('predeindmitry/createlanding/landing'),
                'icon'        => 'icon-leaf',
                'permissions' => ['predeindmitry.createlanding.*'],
                'order'       => 500,
            ],
        ];
    }
    public function registerFormWidgets()
    {
        return [
            'PredeinDmitry\CreateLanding\FormWidgets\Demonstracia' => [
                'label'   => 'predeindmitry_createlanding_demonstracia',
                'code' => 'demonstracia',
            ],
        ];
    }
}
