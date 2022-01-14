<?php namespace PredeinDmitry\CreateLanding\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * Demonstracia Form Widget
 */
class Demonstracia extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'predeindmitry_createlanding_demonstracia';

    /**
     * @inheritDoc
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        return $this->makePartial('demonstracia');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        //$this->vars['name'] = $this->formField->getName();
        //$this->vars['value'] = $this->getLoadValue();
        //$this->vars['model'] = $this->model;
        
        $this->vars['color_back_button'] = $this->model->color_back_button;
        $this->vars['color_back_secondary'] = $this->model->color_back_secondary;
        $this->vars['color_back_primary'] = $this->model->color_back_primary;
        $this->vars['color_fonts_ptimary'] = $this->model->color_fonts_ptimary;
        $this->vars['color_fonts_secondary'] = $this->model->color_fonts_secondary;
        $this->vars['color_fonts_button'] = $this->model->color_fonts_button;
        $this->vars['img_back_maincontent'] = $this->model->img_back_maincontent;
        $this->vars['img_arrow_up'] = $this->model->img_arrow_up;
        $this->vars['img_back_model1'] = $this->model->img_back_model1;
        $this->vars['img_back_model2'] = $this->model->img_back_model2;
        
        $this->vars['menu'] = $this->model->menu;
        $this->vars['tel'] = $this->model->tel;
        $this->vars['label_tel'] = $this->model->label_tel;
        $this->vars['logo'] = $this->model->logo;
        
        $this->vars['label_descriptor'] = $this->model->label_descriptor;
        $this->vars['label_button_descriptor'] = $this->model->label_button_descriptor;
        $this->vars['description_descriptor'] = $this->model->description_descriptor;
        $this->vars['img_descriptor'] = $this->model->img_descriptor;
        $this->vars['img_back_descriptor'] = $this->model->img_back_descriptor;
        
        $this->vars['item_slider1'] = $this->model->item_slider1;
        $this->vars['img_arrow_right_slider1'] = $this->model->img_arrow_right_slider1;
        $this->vars['img_arrow_left_slider1'] = $this->model->img_arrow_left_slider1;
        
        $this->vars['label_slider2'] = $this->model->label_slider2;
        $this->vars['item_slider2'] = $this->model->item_slider2;
        
        $this->vars['label_model'] = $this->model->label_model;
        $this->vars['item_model'] = $this->model->item_model;
        
        $this->vars['label_price'] = $this->model->label_price;
        $this->vars['description_price'] = $this->model->description_price;
        
        $this->vars['label_stat'] = $this->model->label_stat;
        $this->vars['value_stat'] = $this->model->value_stat;
        $this->vars['description_stat'] = $this->model->description_stat;
        
        $this->vars['label_homeOrder'] = $this->model->label_homeOrder;
        $this->vars['placeholder_form_name_homeOrder'] = $this->model->placeholder_form_name_homeOrder;
        $this->vars['placeholder_form_tel_homeOrder'] = $this->model->placeholder_form_tel_homeOrder;
        $this->vars['label_form_button_homeOrder'] = $this->model->label_form_button_homeOrder;
        $this->vars['description_homeOrder'] = $this->model->description_homeOrder;
        $this->vars['img_back_homeOrder'] = $this->model->img_back_homeOrder;
        
        
        $this->vars['label_feedback'] = $this->model->label_feedback;
        $this->vars['img_user_item_feedback'] = $this->model->img_user_item_feedback;
        $this->vars['item_feedback'] = $this->model->item_feedback;
        
        $this->vars['label_homeOrder2'] = $this->model->label_homeOrder2;
        $this->vars['placeholder_form_name_homeOrder2'] = $this->model->placeholder_form_name_homeOrder2;
        $this->vars['placeholder_form_tel_homeOrder2'] = $this->model->placeholder_form_tel_homeOrder2;
        $this->vars['label_form_button_homeOrder2'] = $this->model->label_form_button_homeOrder2;
        $this->vars['description_homeOrder2'] = $this->model->description_homeOrder2;
        $this->vars['img_back_homeOrder2'] = $this->model->img_back_homeOrder2;
        
        $this->vars['label_offer'] = $this->model->label_offer;
        $this->vars['description_offer'] = $this->model->description_offer;
        
        $this->vars['label1_footer'] = $this->model->label1_footer;
        $this->vars['label2_footer'] = $this->model->label2_footer;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/slickStyle.css', 'PredeinDmitry.CreateLanding');
        $this->addCss('css/style.css', 'PredeinDmitry.CreateLanding');
    }
    
    
    public function onLoadContentDemostracia()
    {
        $this->prepareVars();
        return $this->makePartial('demonstr_modal');
    }
    
    
    
    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return \Backend\Classes\FormField::NO_SAVE_DATA;
    }
}
