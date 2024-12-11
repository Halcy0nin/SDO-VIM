<?php

//  ==========================================
//       This is the Forms Validator 
// ===========================================
// 
//  This is where you validate the forms posted
//  on your controllers.
// 
//   Each Form should have their own Form Class.
//  
//   This sample form will give you overview on
//   how to use this class.
//   
//   You are generally be editing only the
//   __construct by specifying the attributes passed
//   and the corresponding validator function to
//   validate the attribute.
//
//   This example validates the string using the
//   string function in the Validator class.
//
//   Just import the Form Validator class and
//   instantiate the validate function that will
//   return a boolean that corresponds with the
//   validation result.
//
//   $form = SampelForm::validate($attributes = [
//    'string' => $_POST['body'],
//   ]);
//
//   the form varialbe will now be either true or
//   false depending on the posted body. Make sure
//   to use the appropriate keys when passing the
//   attributes.
//   



namespace Http\Forms;

use Core\ValidationException;
use Core\Validator;

class SchoolItemsAddForm
{
    protected $errors = [];

    public function __construct(public array $attributes)
    {
        if (!Validator::string($attributes['item_article'], 1, 50)) {
            $this->errors['add_item']['item_article'] = '<span class="error-message">Invalid Item Article Input</span>';
        }
    
        if (!Validator::string($attributes['item_desc'], 1, 50)) {
            $this->errors['add_item']['item_desc'] = '<span class="error-message1">Invalid Item Description Input</span>';
        }
    
        if (!Validator::regex($attributes['item_unit_value'], '/^\$?(([1-9](\d*|\d{0,2}(,\d{3})*))|0)(\.\d{1,2})?$/')) {
            $this->errors['add_item']['item_unit_value'] = '<span class="error-message">Invalid Item Unit Value Input</span>';
        } 
    
        if (!Validator::regex($attributes['item_quantity'], '/^\d{1,10}$/')) {
            $this->errors['add_item']['item_quantity'] = '<span class="error-message1">Invalid Item Quantity Input</span>';
        } 
    
        if (!Validator::regex($attributes['item_active'], '/^\d{1,11}$/')) {
            $this->errors['add_item']['item_active'] = '<span class="error-message">Invalid Active Item Input</span>';
        } 
    
        if (!Validator::regex($attributes['item_inactive'], '/^\d{1,11}$/')) {
            $this->errors['add_item']['item_inactive'] = '<span class="error-message1">Invalid Inactive Item Input</span>';
        } 
    
        if (!Validator::string($attributes['item_funds_source'], 1, 50)) {
            $this->errors['add_item']['item_funds_source'] = '<span class="error-message">Invalid Source of Fund Input</span>';
        }
    }

    public static function validate($attributes)
    {
        $instance = new static($attributes);

        return $instance->failed() ? $instance->throw() : $instance;
    }

    public function throw()
    {
        ValidationException::throw($this->errors(), $this->attributes);
    }

    public function failed()
    {
        return count($this->errors());
    }

    public function errors()
    {
        return $this->errors;
    }

    public function error($field, $message)
    {
        $this->errors[$field] = $message;

        return $this;
    }
}
