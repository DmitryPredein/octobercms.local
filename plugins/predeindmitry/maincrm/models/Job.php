<?php namespace PredeinDmitry\MainCRM\Models;

use Model;
use PredeinDmitry\MainCRM\Models\Detail;
use PredeinDmitry\MainCRM\Models\Customer;
use PredeinDmitry\MainCRM\Models\Devicemodel;
use PredeinDmitry\MainCRM\Models\Service;
use PredeinDmitry\MainCRM\Models\Employee;
use PredeinDmitry\MainCRM\Models\Stock;
use PredeinDmitry\MainCRM\Models\LogJobCRM;
use PredeinDmitry\MainCRM\Models\JobCloseDoneRemont;
use BackendAuth;

/**
 * job Model
 */
class Job extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'predeindmitry_maincrm_jobs';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'name_id' => 'required',

        'discount_work' => ['regex:/(^(\d{1,2}|100)[%]?$)|(^[0-9]+$)/'],
        'discount_details' => ['regex:/(^(\d{1,2}|100)[%]?$)|(^[0-9]+$)/'],

        'work_done.*.work_done_label' => 'required',
        'work_done.*.work_done_cost' => 'required|numeric|min:0',

        'used_detail.*.used_detail_label' => 'required',
        'used_detail.*.used_detail_cost' => 'required|numeric|min:0',
    ];
    public $customMessages = [
        'name_id.required' => 'Введите имя и телефон клиента',
        'work_done.*.work_done_cost.numeric' => 'Некорректная цена работы',
        'work_done.*.work_done_cost.min' => 'Цена работы должна быть положительная',
        'work_done.*.work_done_cost.required' => 'Введите цену работы',
        'work_done.*.work_done_label.required' => 'Введите наименование работы',

        'used_detail.*.used_detail_cost.numeric' => 'Некорректная цена запчасти',
        'used_detail.*.used_detail_cost.min' => 'Цена запчасти должна быть положительная',
        'used_detail.*.used_detail_cost.required' => 'Введите цену запчасти',
        'used_detail.*.used_detail_label.required' => 'Введите наименование запчасти',
    ];

    public function getTypeDeviceOptions()
    {
        return Devicemodel::all()->lists('type_device');
    }
    public function getManagerOptions()
    {
        $user = BackendAuth::getUser();
        $chekcUser = Employee::all()->where("name",  $user["first_name"]." ".$user["last_name"])->first();
        if ($chekcUser != null) {
          $managerArray = $chekcUser->toArray();
          return [$managerArray["id"] => $managerArray["name"]];
        }
        else{
          return ["12" => "Не выбран"];
        }
    }
    public function managerOptionsUpdate() {
        if($this->manager != null){
            return[$this->manager->id => $this->manager->name];
        }
        else{
            $user = BackendAuth::getUser();
            $chekcUser = Employee::all()->where("name",  $user["first_name"]." ".$user["last_name"])->first();
            if ($chekcUser != null) {
              $managerArray = $chekcUser->toArray();
              return [$managerArray["id"] => $managerArray["name"]];
            }
            else{
              return ["12" => "Не выбран"];
            }
        }
    }
    public function getBrandDeviceOptions()
    {
        if(Devicemodel::all()->contains('type_device', $this->type_device)){
            if(Devicemodel::all()->where('type_device', $this->type_device)->lists('brand_device') != null){
                return Devicemodel::all()->where('type_device', $this->type_device)->lists('brand_device');
            }
            else{
                return ['' => 'Неизвестно'];
            }
        }
        else{
            return ['' => 'Неизвестно'];
        }

    }
    public function getDevicemodelOptions()
    {
        if(Devicemodel::all()->contains('brand_device', $this->brand_device) && Devicemodel::all()->contains('type_device', $this->type_device)){

            if(Devicemodel::all()->where('type_device', $this->type_device)->where('brand_device', $this->brand_device)->lists('devicemodel') != null){

                return Devicemodel::all()->where('type_device', $this->type_device)->where('brand_device', $this->brand_device)->lists('devicemodel');

            }
            else{
                return ['' => 'Неизвестно'];
            }

        }
        else{
            return ['' => 'Неизвестно'];
        }
    }
    public function getMasterFilterOptions()
    {
        return Employee::get()->where('position', 'Мастер')->lists('name');
    }
    public function getManagerFilterOptions()
    {
        return Employee::get()->where('position', 'Менеджер')->where('name', '!=', 'Не выбран')->lists('name');
    }
    public function getCostAttribute($value)
    {
        if($this->work_done != null || $this->used_detail != null){
            if(is_array($this->work_done) && is_array($this->used_detail)){
                $sum = 0;

                for($i = 0; $i < count($this->work_done); $i++){

                    if(is_numeric($this->work_done[$i]['work_done_cost'])){

                        if(substr($this->discount_work, -1) == "%" && $this->discount_work != null){
                            $str = intval(substr($this->discount_work,0,-1));
                            $sum += $this->work_done[$i]['work_done_cost']-($this->work_done[$i]['work_done_cost']/100)*$str;
                        }
                        else{
                            $sum += $this->work_done[$i]['work_done_cost'];
                        }

                    }

                }
                for($i = 0; $i < count($this->used_detail); $i++){

                    if(is_numeric($this->used_detail[$i]['used_detail_cost'])){

                        if(substr($this->discount_details, -1) == "%" && $this->discount_details != null){
                            $str = intval(substr($this->discount_details,0,-1));
                            $sum += $this->used_detail[$i]['used_detail_cost']-($this->used_detail[$i]['used_detail_cost']/100)*$str;
                        }
                        else{
                            $sum += $this->used_detail[$i]['used_detail_cost'];
                        }
                    }
                }

                if(substr($this->discount_work, -1) != "%" && $this->discount_work != null){
                    $sum -= $this->discount_work;
                }
                if(substr($this->discount_details, -1) != "%" && $this->discount_details != null){
                    $sum -= $this->discount_details;
                }
                return ceil($sum);
            }
        }
        else{
            return 0;
        }
    }

    public function getDiscountWorkFullcostAttribute($value)
    {
        if($this->work_done != null){
            if(is_array($this->work_done)){
                $sum = 0;

                for($i = 0; $i < count($this->work_done); $i++){

                    if(is_numeric($this->work_done[$i]['work_done_cost'])){

                        if(substr($this->discount_work, -1) == "%" && $this->discount_work != null){
                            $str = intval(substr($this->discount_work,0,-1));
                            $sum += $this->work_done[$i]['work_done_cost']-($this->work_done[$i]['work_done_cost']/100)*$str;
                        }
                        else{
                            $sum += $this->work_done[$i]['work_done_cost'];
                        }

                    }

                }

                if(substr($this->discount_work, -1) != "%" && $this->discount_work != null){
                    $sum -= $this->discount_work;
                }

                return $sum;
            }
        }
        else{
            return 0;
        }
    }
    public function getDiscountDetailsFullcostAttribute($value)
    {
        if($this->used_detail != null){
            if(is_array($this->used_detail)){
                $sum = 0;

                for($i = 0; $i < count($this->used_detail); $i++){

                    if(is_numeric($this->used_detail[$i]['used_detail_cost'])){

                        if(substr($this->discount_details, -1) == "%" && $this->discount_details != null){
                            $str = intval(substr($this->discount_details,0,-1));
                            $sum += $this->used_detail[$i]['used_detail_cost']-($this->used_detail[$i]['used_detail_cost']/100)*$str;
                        }
                        else{
                            $sum += $this->used_detail[$i]['used_detail_cost'];
                        }
                    }
                }

                if(substr($this->discount_details, -1) != "%" && $this->discount_details != null){
                    $sum -= $this->discount_details;
                }
                return $sum;
            }
        }
        else{
            return 0;
        }
    }

    public function getStatusJobOptions($value)
    {
        if ($this->master != null) {
            return ['Передан мастеру' => 'Передан мастеру', 'В процессе' => 'В процессе', 'Отремонтирован' => 'Отремонтирован', 'Ожидает запчасть' => 'Ожидает запчасть'];
        }
        else {
            return ['Принят' => 'Принят'];
        }
    }
    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [
        'work_done',
        'used_detail'
    ];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    public function afterCreate()
    {
        $userAr = BackendAuth::getUser();
        $user = $userAr["last_name"]." ".$userAr["first_name"];



        LogJobCRM::insert([
            [
                "job_id" => $this->id,
                "logging" => $user." создал(а) заявку №".$this->id,
                "created_at" => date("Y-m-d H:i:s"),
            ],
            [
                "job_id" => $this->id,
                "logging" => $user." указал(а) склад: ".$this->stock->stock,
                "created_at" => date("Y-m-d H:i:s"),
            ],
            [
                "job_id" => $this->id,
                "logging" => $this->orientir_cost==NULL?$user." при создании заявки не указал(а) ориентировочную стоимость":$user." указал(а) ориентировочную стоимость: ".$this->orientir_cost,
                "created_at" => date("Y-m-d H:i:s"),
            ],
            [
                "job_id" => $this->id,
                "logging" => $this->pinkod=='нет'?$user." при создании заявки не указал(а) пароль":$user." указал(а) пароль: ".$this->pinkod,
                "created_at" => date("Y-m-d H:i:s"),
            ]
        ]);

        
        
        if($this->patternlock != "0"){
            $password_grafAr = str_split($this->patternlock);
            $password_graf = implode('-', $password_grafAr);
            LogJobCRM::insert([
                "job_id" => $this->id,
                "logging" => $user." указал(а) графический ключ: ".$password_graf,
                "created_at" => date("Y-m-d H:i:s"),
            ]);
            unset($password_grafAr, $password_graf);
        }
        else{
            LogJobCRM::insert([
                "job_id" => $this->id,
                "logging" => $user." при создании заявки не указал(а) графический ключ",
                "created_at" => date("Y-m-d H:i:s"),
            ]);
        }
        if($this->discount_work != "0"){
            LogJobCRM::insert([
                "job_id" => $this->id,
                "logging" => $user." указал(а) скидку на работу: ".$this->discount_work,
                "created_at" => date("Y-m-d H:i:s"),
            ]);
        }
        if($this->discount_details != "0"){
            LogJobCRM::insert([
                "job_id" => $this->id,
                "logging" => $user." указал(а) скидку на детали ".$this->discount_details,
                "created_at" => date("Y-m-d H:i:s"),
            ]);
        }


        if($this->status_job != NULL){
            switch ($this->status_job) {
                case "Передан мастеру":
                    Job::where("id", $this->id)->update(['is_check_conditions' => date("Y-m-d H:i:s")]);
                    break;
                case "Выдан без ремонта":
                    Job::where("id", $this->id)->update(['is_check_conditions' => date("Y-m-d H:i:s")]);
                    break;
                case "В процессе":
                    Job::where("id", $this->id)->update(['is_check_conditions' => date("Y-m-d H:i:s")]);
                    break;
                case "Отремонтирован":
                    Job::where("id", $this->id)->update(['is_check_conditions' => date("Y-m-d H:i:s")]);
                    break;
                case "Выдан клиенту":
                    Job::where("id", $this->id)->update(['is_check_conditions' => date("Y-m-d H:i:s")]);
                    break;
            }
        }
    }



    public function beforeSave()
    {
        if(!(Devicemodel::all()->contains('devicemodel', $this->devicemodel))){
            Devicemodel::insert(['id' => null, 'type_device' => $this->type_device, 'brand_device' => $this->brand_device, 'devicemodel'=> $this->devicemodel, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")]);
        }
    }


    public function beforeUpdate()
    {
        $userAr = BackendAuth::getUser();
        $user = $userAr["last_name"]." ".$userAr["first_name"];
        $JobArray = Job::where("id", $this->id)->first()->toArray();

        if($JobArray["status_job"] == "Выдан без ремонта"){
            return;
        }

        if($JobArray["is_warranty"] == "Не гарантийный"){
            if($this->type_job != $JobArray["type_job"]){
                LogJobCRM::insert([
                    "job_id" => $this->id,
                    "logging" => $user." обновил(а) источник заявки: ".$this->type_job,
                    "created_at" => date("Y-m-d H:i:s")
                ]);
            }
            if($this->imei != $JobArray["imei"]){
                LogJobCRM::insert([
                    "job_id" => $this->id,
                    "logging" => $user." обновил(а) IMEI: ".$this->imei,
                    "created_at" => date("Y-m-d H:i:s")
                ]);
            }
        }

        if($this->used_detail != NULL && $this->used_detail != []){
            if($this->used_detail != $JobArray["used_detail"]){
                $used_detail = "";
                foreach($this->used_detail as $value){
                    $used_detail = $used_detail."|".$value['used_detail_label'].":".$value['used_detail_cost']."|";
                }
                LogJobCRM::insert([
                    "job_id" => $this->id,
                    "logging" => $user." обновил(а) детали ".$used_detail,
                    "created_at" => date("Y-m-d H:i:s"),
                ]);
            }
        }
        if($this->patternlock != NULL && $this->patternlock != [] && $this->patternlock != "0"){
            if($this->patternlock != $JobArray["patternlock"]){
                $password_grafAr = str_split($this->patternlock);
                $password_graf = implode('-', $password_grafAr);
                LogJobCRM::insert([
                    "job_id" => $this->id,
                    "logging" => $user." указал(а) графический ключ: ".$password_graf,
                    "created_at" => date("Y-m-d H:i:s"),
                ]);
                unset($password_grafAr, $password_graf);
            }
        }
    }

    public function beforeDelete()
    {
        //LogJobCRM::where('job_id', $this->id)->delete();
        $userAr = BackendAuth::getUser();
        $user = $userAr["last_name"]." ".$userAr["first_name"];

        LogJobCRM::insert([
            "job_id" => $this->id,
            "logging" => $user." удалил заявку ",
            "created_at" => date("Y-m-d H:i:s"),
        ]);
    }


    public function scopeMasterFilter($query, $types)
    {
        foreach ($types as $type) {
            switch ($type) {
                case '0':
                    $query = $query->where('master_id', "8");
                    break;
                case '1':
                    $query = $query->where('master_id', "9");
                    break;
            }
        }
        return $query;
    }
    public function scopeManagerFilter($query, $types)
    {
        foreach ($types as $type) {
            switch ($type) {
                case '0':
                    $query = $query->where('manager_id', "10");
                    break;
                case '1':
                    $query = $query->where('manager_id', "11");
                    break;
            }
        }
        return $query;
    }

    public function scopeOpenJobToday($query, $types)
    {
        $user = BackendAuth::getUser();
        $userRole = "superuser";
        if($user["role"] != null){
            $userRole = $user["role"]->attributes["name"];
        }

        if ($types == '1') {
           if($userRole == "Мастер"){
                $userName = $user["first_name"]." ".$user["last_name"];
                $userId = Employee::where("name", $userName)->pluck("id")->first();
                $query = $query->where('status_job', '!=', 'Не обработана')->where("master_id", $userId)->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d H:i:s')]);
            }
            else{
                $query = $query->where('status_job', '!=', 'Не обработана')->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d H:i:s')]);
            }
        }
        return $query;
    }
    public function scopeOpenJobGarant($query, $types)
    {
        $user = BackendAuth::getUser();
        $userRole = "superuser";
        if($user["role"] != null){
            $userRole = $user["role"]->attributes["name"];
        }

        if ($types == '1') {
           if($userRole == "Мастер"){
                $userName = $user["first_name"]." ".$user["last_name"];
                $userId = Employee::where("name", $userName)->pluck("id")->first();
                $query = $query->where('is_warranty', 'Гарантийный')->where("master_id", $userId);
            }
            else{
                $query = $query->where('is_warranty', 'Гарантийный');
            }
        }
        return $query;
    }
    public function scopeOverdueJobInMaster($query, $types)
    {
        $user = BackendAuth::getUser();
        $userRole = "superuser";
        if($user["role"] != null){
            $userRole = $user["role"]->attributes["name"];
        }

        if ($types == '1') {
           if($userRole == "Мастер"){
                $userName = $user["first_name"]." ".$user["last_name"];
                $userId = Employee::where("name", $userName)->pluck("id")->first();
                $TreeDayCencel = date("Y-m-d H:i:s", mktime(date('H'), date('i'), date('s'), date('m'), date('d') - 3, date('Y')));
                $query = $query->whereIn('status_job', ['Передан мастеру', 'В процессе'])->where("master_id", $userId)->where('is_check_conditions', '<', $TreeDayCencel);
            }
            else{
                $TreeDayCencel = date("Y-m-d H:i:s", mktime(date('H'), date('i'), date('s'), date('m'), date('d') - 3, date('Y')));
                $query = $query->whereIn('status_job', ['Передан мастеру', 'В процессе'])->where('is_check_conditions', '<', $TreeDayCencel);
            }
        }
        return $query;
    }
    public function scopeOverdueJobDoneWork($query, $types)
    {
        $user = BackendAuth::getUser();
        $userRole = "superuser";
        if($user["role"] != null){
            $userRole = $user["role"]->attributes["name"];
        }

        if ($types == '1') {
           if($userRole == "Мастер"){
                $userName = $user["first_name"]." ".$user["last_name"];
                $userId = Employee::where("name", $userName)->pluck("id")->first();
                $TreeDayCencel = date("Y-m-d H:i:s", mktime(date('H'), date('i'), date('s'), date('m'), date('d') - 3, date('Y')));
                $query = $query->where('status_job', 'Отремонтирован')->where("master_id", $userId)->where('is_check_conditions', '<', $TreeDayCencel);
            }
            else{
                $TreeDayCencel = date("Y-m-d H:i:s", mktime(date('H'), date('i'), date('s'), date('m'), date('d') - 3, date('Y')));
                $query = $query->where('status_job', 'Отремонтирован')->where('is_check_conditions', '<', $TreeDayCencel);
            }
        }
        return $query;
    }
    public function scopeOpenJobLanding($query, $types)
    {
      if ($types == '1') {
        $query = $query->where('status_job', 'Не обработана');
      }
      return $query;
    }
    public function scopeDoneJob($query, $types)
    {
        $user = BackendAuth::getUser();
        $userRole = "superuser";
        if($user["role"] != null){
            $userRole = $user["role"]->attributes["name"];
        }

        if ($types == '1') {
           if($userRole == "Мастер"){
                $userName = $user["first_name"]." ".$user["last_name"];
                $userId = Employee::where("name", $userName)->pluck("id")->first();
                $query = $query->where('status_job', 'Отремонтирован')->where("master_id", $userId);
            }
            else{
                $query = $query->where('status_job', 'Отремонтирован');
            }
        }
        return $query;
    }
    public function scopeAllJob($query, $types)
    {
        $user = BackendAuth::getUser();
        $userRole = "superuser";
        if($user["role"] != null){
            $userRole = $user["role"]->attributes["name"];
        }

        if ($types == '1') {
           if($userRole == "Мастер"){
                $userName = $user["first_name"]." ".$user["last_name"];
                $userId = Employee::where("name", $userName)->pluck("id")->first();
                $query = $query->whereIn('status_job', ['Передан мастеру', 'В процессе', 'Принят', 'Ожидает запчасть'])->where("master_id", $userId);
            }
            else{
                $query = $query->whereIn('status_job', ['Не обработана', 'Передан мастеру', 'В процессе', 'Принят', 'Ожидает запчасть']);
            }
        }
        return $query;
    }

    public function scopeCloseJobToday($query, $types)
    {
        $user = BackendAuth::getUser();
        $userRole = "superuser";
        if($user["role"] != null){
            $userRole = $user["role"]->attributes["name"];
        }

        if ($types == '1') {
           if($userRole == "Мастер"){
                $userName = $user["first_name"]." ".$user["last_name"];
                $userId = Employee::where("name", $userName)->pluck("id")->first();
                $query = $query->whereIn('status_job', ['Выдан клиенту', 'Выдан без ремонта'])->where("master_id", $userId)->whereBetween('is_check_conditions', [date('Y-m-d 00:00:00'), date('Y-m-d H:i:s')]);
            }
            else{
                $query = $query->whereIn('status_job', ['Выдан клиенту', 'Выдан без ремонта'])->whereBetween('is_check_conditions', [date('Y-m-d 00:00:00'), date('Y-m-d H:i:s')]);
            }
        }
        return $query;
    }

    public function scopeAllJobFreeMaster($query, $types)
    {
        if ($types == '1') {
            $query = $query->where("master_id", null)->whereIn('status_job', ['Принят', 'Не обработана']);
        }
        return $query;
    }

    public function filterFields($fields, $context = null)
    {
        $user = BackendAuth::getUser();
        $userRole = "superuser";
        if($user["role"] != null){
            $userRole = $user["role"]->attributes["name"];
        }


        if ($this->status_job == 'Выдан без ремонта' || $this->status_job == 'Выдан клиенту') {
            $fields->is_status->disabled = true;
            $fields->manager->readOnly = true;
            $fields->stock->readOnly = true;
            $fields->warranty->readOnly = true;
            $fields->master->readOnly = true;
            $fields->type_job->readOnly = true;
            $fields->orientir_cost->readOnly = true;
            $fields->status_job->readOnly = true;
            $fields->patternlock->hidden = true;
            $fields->type_device->readOnly = true;
            $fields->brand_device->readOnly = true;
            $fields->devicemodel->readOnly = true;
            $fields->imei->readOnly = true;
            $fields->name_id->readOnly = true;
            $fields->condition_device->readOnly = true;
            $fields->pinkod->readOnly = true;
            $fields->descriptions->readOnly = true;
            $fields->notehzzahcem->readOnly = true;
            $fields->discount_work->readOnly = true;
            $fields->discount_details->readOnly = true;
            $fields->work_done->hidden = true;
            $fields->used_detail->hidden = true;
            $fields->print->hidden = true;
            $fields->_histiry->hidden = false;
            $fields->print_close->hidden = false;

            if($userRole != "Мастер" && $this->status_job != 'Выдан без ремонта'){
                $fields->garant->hidden = false;
            }
        }
        else{
            if($userRole == "Мастер"){
                $fields->_histiry->hidden = false;
                $fields->is_status->disabled = true;
                $fields->manager->readOnly = true;
                $fields->stock->readOnly = true;
                $fields->warranty->readOnly = true;
                $fields->master->readOnly = true;
                $fields->type_job->readOnly = true;
                $fields->orientir_cost->readOnly = true;
                $fields->name_id->readOnly = true;
                //$fields->patternlock->hidden = true;
                $fields->type_device->readOnly = true;
                $fields->brand_device->readOnly = true;
                $fields->devicemodel->readOnly = true;
                $fields->imei->readOnly = true;
                $fields->condition_device->readOnly = true;
                $fields->pinkod->readOnly = true;
                $fields->descriptions->readOnly = true;
                $fields->discount_work->readOnly = true;
                $fields->discount_details->readOnly = true;
                $fields->work_done->hidden = true;
                $fields->used_detail->hidden = true;
                $fields->print->hidden = true;
            }
        }
    }

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'master' => 'PredeinDmitry\MainCRM\Models\Employee',
        'manager' => 'PredeinDmitry\MainCRM\Models\Employee',
        'name' => 'PredeinDmitry\MainCRM\Models\Customer',
        'stock' => 'PredeinDmitry\MainCRM\Models\Stock',
    ];
}
