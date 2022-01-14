<?php namespace PredeinDmitry\Cashbox\Widgets;

use Backend\Classes\WidgetBase;
use PredeinDmitry\Cashbox\Models\CashboxHistory;
use PredeinDmitry\Cashbox\Models\CashboxAxmobi;
use PredeinDmitry\MainCRM\Models\Stock;
use BackendAuth;

class ManageCashbox extends WidgetBase {

    protected $defaultAlias = 'managecashbox';

    public function render() {
        $this->prepareVars();
        return $this->makePartial('managecashbox');
    }
    
    public function prepareVars() {
        
        $stockArray = CashboxAxmobi::get()->where("stock", post("stock"));
            
        $this->vars['stock'] = $stockArray->pluck('stock')->first();
        $this->vars['all'] = $stockArray->pluck('cahs')->first();
        $this->vars['allNal'] = $stockArray->pluck('nal')->first();
        $this->vars['allBeznal'] = $stockArray->pluck('beznal')->first();
            
        
        $this->vars['stockArray'] = Stock::where("stock", "!=", "Не определён")->lists("stock");
    }

    protected function loadAssets() {
        $this->addJs('js/managecashbox.js');
        $this->addCss('css/managecashbox.css');
    }
    
    public function onRefresh() {
        $this->prepareVars();
    }
    
    public function onCahsManage() {
        
        $user = BackendAuth::getUser();
		
		if(post('type') == 'nal' && post('pay') == '2'){
            CashboxHistory::insert([
			   'user' => $user["last_name"]." ".$user["first_name"],
			   'komment' => post('koment'),
			   'beznal' => post('sum'),
			   'stock' => post('stock'),
			   'created_at' => date("Y-m-d H:i:s")
			]);
        }
        else{
            CashboxHistory::insert([
			   'user' => $user["last_name"]." ".$user["first_name"],
			   'komment' => post('koment'),
			   post('type') => post('sum'),
			   'stock' => post('stock'),
			   'created_at' => date("Y-m-d H:i:s")
			]);
        }
        
        
        $cahs = CashboxAxmobi::get()->where("stock", post("stock"))->pluck('cahs')->first();
        $nal = CashboxAxmobi::get()->where("stock", post("stock"))->pluck('nal')->first();
		$beznal = CashboxAxmobi::get()->where("stock", post("stock"))->pluck('beznal')->first();
        
        if(post('type') == 'nal' && post('pay') == '1'){
            CashboxAxmobi::where("stock", post("stock"))->update([
                            'cahs' => $cahs+post('sum'),
                            'nal' => $nal+post('sum')
                        ]);
        }
		else if(post('type') == 'nal' && post('pay') == '2'){
            CashboxAxmobi::where("stock", post("stock"))->update([
                            'cahs' => $cahs+post('sum'),
                            'beznal' => $beznal+post('sum')
                        ]);
        }
        else if(post('type') == 'expenses' && post('pay') == '1'){
            CashboxAxmobi::where("stock", post("stock"))->update([
                            'cahs' => $cahs-post('sum'),
                            'nal' => $nal-post('sum')
                        ]);
        }
		else if(post('type') == 'expenses' && post('pay') == '2'){
            CashboxAxmobi::where("stock", post("stock"))->update([
                            'cahs' => $cahs-post('sum'),
                            'beznal' => $beznal-post('sum')
                        ]);
        }
        $this->prepareVars();
        
    }
}
