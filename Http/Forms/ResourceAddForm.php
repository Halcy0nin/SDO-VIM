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

class ResourceAddForm
{
    protected $errors = [];

    public function __construct(public array $attributes)
    {
        if (!Validator::string($attributes['item_article'], 1, 50)) {
            $this->errors['add_resource']['item_article'] = 'There are errors with your string!';
        } elseif (!Validator::no_whitespace($attributes['item_article'])) {
            $this->errors['add_resource']['item_article'] = 'Item Article should not contain any whitespace.';
        }

        if (!Validator::string($attributes['item_desc'], 1, 50)) {
            $this->errors['add_resource']['item_desc'] = 'There are errors with your string!';
        } elseif (!Validator::no_whitespace($attributes['item_desc'])) {
            $this->errors['add_resource']['item_desc'] = 'Item Description should not contain any whitespace.';
        }

        if (!Validator::regex($attributes['item_unit_value'], '/^\$?(([1-9](\d*|\d{0,2}(,\d{3})*))|0)(\.\d{1,2})?$/')) {
            $this->errors['add_resource']['item_unit_value'] = 'There are errors with your string!';
        } elseif (!Validator::no_whitespace($attributes['item_unit_value'])) {
            $this->errors['add_resource']['item_unit_value'] = 'Item Unit Value should not contain any whitespace.';
        }

        if (!Validator::regex($attributes['item_quantity'], '/^\d{1,10}$/')) {
            $this->errors['add_resource']['item_quantity'] = 'There are errors with your string!';
        } elseif (!Validator::no_whitespace($attributes['item_quantity'])) {
            $this->errors['add_resource']['item_quantity'] = 'Item Quantity should not contain any whitespace.';
        }

        if (!Validator::regex($attributes['item_active'], '/^\d{1,11}$/')) {
            $this->errors['add_resource']['item_active'] = 'There are errors with your string!';
        } elseif (!Validator::no_whitespace($attributes['item_active'])) {
            $this->errors['add_resource']['item_active'] = 'Item Active should not contain any whitespace.';
        }

        if (!Validator::regex($attributes['item_inactive'], '/^\d{1,11}$/')) {
            $this->errors['add_resource']['item_inactive'] = 'There are errors with your string!';
        } elseif (!Validator::no_whitespace($attributes['item_inactive'])) {
            $this->errors['add_resource']['item_inactive'] = 'Item Inactive should not contain any whitespace.';
        }

        if (!Validator::string($attributes['item_funds_source'], 1, 50)) {
            $this->errors['add_resource']['item_funds_source'] = 'There are errors with your string!';
        } elseif (!Validator::no_whitespace($attributes['item_funds_source'])) {
            $this->errors['add_resource']['item_funds_source'] = 'Item Funds Source should not contain any whitespace.';
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
