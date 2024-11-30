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

class SchoolEditForm
{
    protected $errors = [];

    public function __construct(public array $attributes)
    {

        if (!Validator::regex($attributes['school_id'], '/^\d{6}$/')) {
            $this->errors[$attributes['_school_id']]['school_id'] = 'Please enter a valid 6-digit School ID.';
        } elseif (!Validator::no_whitespace($attributes['school_id'])) {
            $this->errors[$attributes['_school_id']]['school_id'] = 'School ID should not contain any whitespace.';
        }
        
        if (!Validator::string($attributes['school_name'], 1, 50)) {
            $this->errors[$attributes['_school_id']]['school_name'] = 'Please enter a valid School Name.';
        } elseif (!Validator::no_whitespace($attributes['school_name'])) {
            $this->errors[$attributes['_school_id']]['school_name'] = 'School Name should not contain any whitespace.';
        }
        
        if (!Validator::regex($attributes['school_type'], '/^1|2$/')) {
            $this->errors[$attributes['_school_id']]['school_type'] = 'Please select a valid School Type.';
        }
        
        if (!Validator::regex($attributes['school_district'], '/^1|2|3|4$/')) {
            $this->errors[$attributes['_school_id']]['school_district'] = 'Please select a valid School District.';
        }
        
        if (!Validator::regex($attributes['school_division'], '/^1|2|3|4$/')) {
            $this->errors[$attributes['_school_id']]['school_division'] = 'Please select a valid School Division.';
        }
        
        if (!Validator::string($attributes['contact_name'], 1, 32)) {
            $this->errors[$attributes['_school_id']]['contact_name'] = 'Please enter a valid Contact Name that is under 32 characters.';
        } elseif (!Validator::no_whitespace($attributes['contact_name'])) {
            $this->errors[$attributes['_school_id']]['contact_name'] = 'Contact Name should not contain any whitespace.';
        }
        
        if (!Validator::regex($attributes['contact_no'], '/^\d{11}$/')) {
            $this->errors[$attributes['_school_id']]['contact_no'] = 'Please enter a valid contact number.';
        } elseif (!Validator::no_whitespace($attributes['contact_no'])) {
            $this->errors[$attributes['_school_id']]['contact_no'] = 'Contact number should not contain any whitespace.';
        }
        
        if (!Validator::email($attributes['contact_email'])) {
            $this->errors[$attributes['_school_id']]['contact_email'] = 'Please enter a valid email address.';
        } elseif (!Validator::no_whitespace($attributes['contact_email'])) {
            $this->errors[$attributes['_school_id']]['contact_email'] = 'Email should not contain any whitespace.';
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
