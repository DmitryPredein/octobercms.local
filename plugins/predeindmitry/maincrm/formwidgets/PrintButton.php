<?php namespace PredeinDmitry\MainCRM\FormWidgets;

use Backend;
use Backend\Classes\FormWidgetBase;
use PredeinDmitry\MainCRM\Models\Job;
use PredeinDmitry\Cashbox\Models\CashboxHistory;
use PredeinDmitry\Cashbox\Models\CashboxAxmobi;
use PredeinDmitry\MainCRM\Models\Customer;
use PredeinDmitry\MainCRM\Models\LogJobCRM;
use BackendAuth;


class PrintButton extends FormWidgetBase
{
    public function init()
    {
    }

    public function render()
    {
        $this->vars['descriptionPrev'] = $this->model->descriptions;
        $this->vars['notehzzahcemPrev'] = $this->model->notehzzahcem;
        return $this->makePartial('printbutton');
    }

    public function prepareVars()
    {
        function num2str($num) {
            $nul='ноль';
            $ten=array(
                array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
                array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
            );
            $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
            $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
            $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
            $unit=array(
                array('копейка' ,'копейки' ,'копеек',	 1),
                array('рубль'   ,'рубля'   ,'рублей'    ,0),
                array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
                array('миллион' ,'миллиона','миллионов' ,0),
                array('миллиард','милиарда','миллиардов',0),
            );

            list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
            $out = array();
            if (intval($rub)>0) {
                foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
                    if (!intval($v)) continue;
                    $uk = sizeof($unit)-$uk-1; // unit key
                    $gender = $unit[$uk][3];
                    list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
                    // mega-logic
                    $out[] = $hundred[$i1]; # 1xx-9xx
                    if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
                    else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                    // units without rub & kop
                    if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
                } //foreach
            }
            else $out[] = $nul;
            $out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
            $out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
            return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
        }

        function morph($n, $f1, $f2, $f5) {
            $n = abs(intval($n)) % 100;
            if ($n>10 && $n<20) return $f5;
            $n = $n % 10;
            if ($n>1 && $n<5) return $f2;
            if ($n==1) return $f1;
            return $f5;
        }

        $id_name = $this->model->name_id;
        if(!($id_name)){
            $this->vars['customer_name'] = "-";
            $this->vars['customer_tel'] = "-";
            $this->vars['customer_address'] = "-";
            $this->vars['customer_email'] = "-";
        }
        else{
            $this->vars['customer_name'] = Customer::where("id", $this->model->name_id)->pluck("name")->first();
            $this->vars['customer_tel'] = Customer::where("id", $this->model->name_id)->pluck("tel")->first();
            $this->vars['customer_address'] = Customer::where("id", $this->model->name_id)->pluck("address")->first();
            $this->vars['customer_email'] = Customer::where("id", $this->model->name_id)->pluck("mail")->first();
        }
        $this->vars['stock_address'] = $this->model->stock->stock_address;
        $this->vars['stock_schedule'] = $this->model->stock->schedule;
        $this->vars['stock_stock'] = $this->model->stock->stock;
        $this->vars['device_type'] = $this->model->type_device;
        $this->vars['device_brand'] = $this->model->brand_device;
        $this->vars['device_model'] = $this->model->devicemodel;
        $this->vars['imei'] = $this->model->imei;
        $this->vars['manager'] = $this->model->manager->name;
        $this->vars['is_warranty'] = $this->model->is_warranty;
        $this->vars['warranty'] = $this->model->warranty==null?"-":$this->model->warranty;
        if($this->model->master != null){
            $this->vars['master'] = $this->model->master->name;
        }
        else{
            $this->vars['master'] = "-";
        }
        $this->vars['description'] = $this->model->descriptions;
        $this->vars['condition_device'] = $this->model->condition_device;
        $this->vars['cost'] = $this->model->cost;
        $this->vars['costFullDetails'] = $this->model->_discount_details_fullcost;
        $this->vars['costFullWork'] = $this->model->_discount_work_fullcost;
        $this->vars['orientir_cost'] = $this->model->orientir_cost;
        $this->vars['cost_italic'] = num2str(strval($this->model->cost));
        $this->vars['receipt_id'] = $this->model->id;
        $this->vars['work_done'] = $this->model->work_done;
        $this->vars['used_detail'] = $this->model->used_detail;
        $this->vars['password'] = $this->model->pinkod;

        $password_grafAr = str_split($this->model->patternlock);
        $this->vars['password_graf'] = implode('-', $password_grafAr);


        if($this->model->discount_work != null){
            $this->vars['discount_work'] = $this->model->discount_work;
        }
        else{
            $this->vars['discount_work'] = "-";
        }

        if($this->model->discount_details != null){
            $this->vars['discount_details'] = $this->model->discount_details;
        }
        else{
            $this->vars['discount_details'] = "-";
        }
    }

    public function loadAssets()
    {
        $this->addCss('css/printbutton.css', 'PredeinDmitry.MainCRM');
        $this->addJs('js/printbutton.js', 'PredeinDmitry.MainCRM');
        $this->addJs('js/jquery-printme.min.js', 'PredeinDmitry.MainCRM');
    }

    public function onLoadContentCloseNotJob()
    {
        $this->prepareVars();
        $this->vars['cost'] = $this->model->cost;
        return $this->makePartial('print_closenotremont');
    }

    public function onCloseNotJob()
    {
        Job::where('id', $this->model->id)->update(['status_job' => 'Выдан без ремонта', 'is_check_conditions' => date("Y-m-d H:i:s")]);

        $user = BackendAuth::getUser();

        LogJobCRM::insert([
            "job_id" => $this->model->id,
            "logging" => "Менеджер ".$user["last_name"]." ".$user["first_name"]." закрыл заявку №".$this->model->id.",без ремонта",
            "created_at" => date("Y-m-d H:i:s"),
        ]);

        return Backend::redirect('predeindmitry/maincrm/job');
    }

    public function onExitJob()
    {
        Job::where('id', $this->model->id)->update(['status_job' => 'Выдан клиенту', 'is_check_conditions' => date("Y-m-d H:i:s")]);

        $user = BackendAuth::getUser();

        LogJobCRM::insert([
            "job_id" => $this->model->id,
            "logging" => "Менеджер ".$user["last_name"]." ".$user["first_name"]." закрыл заявку №".$this->model->id,
            "created_at" => date("Y-m-d H:i:s")
        ]);

        switch ($this->model->payment_method) {
            case "Безналичный":
                $beznalcost = $this->model->cost>0?$this->model->cost:0;
                CashboxHistory::insert([
                    'user' => $user["last_name"]." ".$user["first_name"],
                    'komment' => 'Закрытие заявки №'.$this->model->id,
                    'beznal' => $beznalcost,
                    'stock' => $this->model->stock->stock,
                    'created_at' => date("Y-m-d H:i:s")
                 ]);
                $cahs = CashboxAxmobi::get()->where("stock", $this->model->stock->stock)->pluck('cahs')->first();
                $beznal = CashboxAxmobi::get()->where("stock", $this->model->stock->stock)->pluck('beznal')->first();
                CashboxAxmobi::where("stock", $this->model->stock->stock)->update([
                            'cahs' => $cahs+$beznalcost,
                            'beznal' => $beznal+$beznalcost
                        ]);
                unset($beznal, $cahs, $beznalcost);
                break;
            case "Наличные":
                $nalcost = $this->model->cost>0?$this->model->cost:0;
                CashboxHistory::insert([
                    'user' => $user["last_name"]." ".$user["first_name"],
                    'komment' => 'Закрытие заявки №'.$this->model->id,
                    'nal' => $nalcost,
                    'stock' => $this->model->stock->stock,
                    'created_at' => date("Y-m-d H:i:s")
                 ]);
                $cahs = CashboxAxmobi::get()->where("stock", $this->model->stock->stock)->pluck('cahs')->first();
                $nal = CashboxAxmobi::get()->where("stock", $this->model->stock->stock)->pluck('nal')->first();
                CashboxAxmobi::where("stock", $this->model->stock->stock)->update([
                            'cahs' => $cahs+$nalcost,
                            'nal' => $nal+$nalcost
                        ]);
                unset($nal, $cahs, $nalcost);
                break;
            case "Смешаное":
                $array = explode(":::", $this->model->costpayMethod);
                $beznalcost = $array[1]>0?$array[1]:0;
                $nalcost = $array[0]>0?$array[0]:0;
                CashboxHistory::insert([
                    'user' => $user["last_name"]." ".$user["first_name"],
                    'komment' => 'Закрытие заявки №'.$this->model->id,
                    'beznal' => $beznalcost,
                    'nal' => $nalcost,
                    'stock' => $this->model->stock->stock,
                    'created_at' => date("Y-m-d H:i:s")
                 ]);
                $cahs = CashboxAxmobi::get()->where("stock", $this->model->stock->stock)->pluck('cahs')->first();
                $nal = CashboxAxmobi::get()->where("stock", $this->model->stock->stock)->pluck('nal')->first();
                $beznal = CashboxAxmobi::get()->where("stock", $this->model->stock->stock)->pluck('beznal')->first();
                CashboxAxmobi::where("stock", $this->model->stock->stock)->update([
                            'cahs' => $cahs+$nalcost+$beznalcost,
                            'nal' => $nal+$nalcost,
                            'beznal' => $beznal+$beznalcost
                        ]);
                unset($array, $beznal, $nal, $cahs, $nalcost, $beznalcost);
                break;
        }

        return Backend::redirect('predeindmitry/maincrm/job');
    }

    public function onLoadContent()
    {
        $this->vars['cost'] = $this->model->cost;
        return $this->makePartial('exemple_1');
    }

    public function onLoadContentKvitancia()
    {
        $this->prepareVars();
        return $this->makePartial('kvitancia');
    }

    public function onJobRedirect()
    {
        return Backend::redirect('predeindmitry/maincrm/job');
    }

    public function onLoadContentPrintFinal()
    {

        $this->prepareVars();

        Job::where('id', $this->model->id)->update(['payment_method' => post('target'), 'costpayMethod' => post('nal').':::'.post('besnal')]);

        return $this->makePartial('exemple_2');
    }
    public function getSaveValue($value)
    {
        return \Backend\Classes\FormField::NO_SAVE_DATA;
    }
}
