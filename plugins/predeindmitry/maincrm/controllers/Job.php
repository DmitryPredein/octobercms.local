<?php namespace PredeinDmitry\MainCRM\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use PredeinDmitry\MainCRM\Models\Customer;
use PredeinDmitry\MainCRM\Models\JobLanding;
use PredeinDmitry\MainCRM\Models\LogJobCRM;
use Illuminate\Http\RedirectResponse;
use BackendAuth;

/**
 * Job Back-end Controller
 */
class Job extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
    ];
    public function listInjectRowClass($job, $definition)
    {
        if ($job->status_job == "Принят") {
            if ($job->is_status == "is_soglasovano") {
                return 'successCustom jobPrinat';
            }
            else if ($job->is_status == "is_nedosvonilsya") {
                return 'errorCustom jobPrinat';
            }
            else if ($job->is_status == "is_peresvonit") {
                return 'warningCustom jobPrinat';
            }
            else{
                return 'jobPrinat';
            }
        }
        else if ($job->status_job == "Передан мастеру") {
            if ($job->is_status == "is_soglasovano") {
                return 'successCustom predanMasteru';
            }
            else if ($job->is_status == "is_nedosvonilsya") {
                return 'errorCustom predanMasteru';
            }
            else if ($job->is_status == "is_peresvonit") {
                return 'warningCustom predanMasteru';
            }
            else{
                return 'predanMasteru';
            }
        }
        else if ($job->status_job == "В процессе") {
            if ($job->is_status == "is_soglasovano") {
                return 'successCustom vProcesse';
            }
            else if ($job->is_status == "is_nedosvonilsya") {
                return 'errorCustom vProcesse';
            }
            else if ($job->is_status == "is_peresvonit") {
                return 'warningCustom vProcesse';
            }
            else{
                return 'vProcesse';
            }
        }
        else if ($job->status_job == "Отремонтирован") {
            if ($job->is_status == "is_soglasovano") {
                return 'successCustom workDone';
            }
            else if ($job->is_status == "is_nedosvonilsya") {
                return 'errorCustom workDone';
            }
            else if ($job->is_status == "is_peresvonit") {
                return 'warningCustom workDone';
            }
            else{
                return 'workDone';
            }
        }
        else if ($job->status_job == "Ожидает запчасть") {
            if ($job->is_status == "is_soglasovano") {
                return 'successCustom oschidaetSapchast';
            }
            else if ($job->is_status == "is_nedosvonilsya") {
                return 'errorCustom oschidaetSapchast';
            }
            else if ($job->is_status == "is_peresvonit") {
                return 'warningCustom oschidaetSapchast';
            }
            else{
                return 'oschidaetSapchast';
            }
        }
        else if ($job->status_job == "Выдан клиенту") {
            if ($job->is_status == "is_soglasovano") {
                return 'successCustom sucessJob';
            }
            else if ($job->is_status == "is_nedosvonilsya") {
                return 'errorCustom sucessJob';
            }
            else if ($job->is_status == "is_peresvonit") {
                return 'warningCustom sucessJob';
            }
            else{
                return 'sucessJob';
            }
        }
        else if ($job->status_job == "Выдан без ремонта") {
            if ($job->is_status == "is_soglasovano") {
                return 'successCustom notRemont';
            }
            else if ($job->is_status == "is_nedosvonilsya") {
                return 'errorCustom notRemont';
            }
            else if ($job->is_status == "is_peresvonit") {
                return 'warningCustom notRemont';
            }
            else{
                return 'notRemont';
            }
        }
    }


    public $formConfig = 'config_form.yaml';
    public $listConfig = [
        'job' => 'config_job_list.yaml',
    ];

    public function __construct()
    {
        parent::__construct();

        $StatisticaManager = new \PredeinDmitry\MainCRM\Widgets\StatisticaManager($this);
        $StatisticaManager->alias = 'statisticamanager';
        $StatisticaManager->bindToController();

        $StatisticaMaster = new \PredeinDmitry\MainCRM\Widgets\StatisticaMaster($this);
        $StatisticaMaster->alias = 'statisticamaster';
        $StatisticaMaster->bindToController();

        BackendMenu::setContext('PredeinDmitry.MainCRM', 'maincrm', 'job');
    }
}
