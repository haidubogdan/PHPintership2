<?php
namespace Quiz\models;

class ValidateUsersModel
{

    /**
     * @read
     */
    protected $_validators = array(
        "required" => array(
            "handler" => "_validateRequired",
            "message" => "The {0} field is required"
        ),
        "alpha" => array(
            "handler" => "_validateAlpha",
            "message" => "The {0} field can only contain letters"
        ),
        "numeric" => array(
            "handler" => "_validateNumeric",
            "message" => "The {0} field can only contain numbers"
        ),
        "alphanumeric" => array(
            "handler" => "_validateAlphaNumeric",
            "message" => "The {0} field can only contain letters and numbers"
        ),
        "max" => array(
            "handler" => "_validateMax",
            "message" => "The {0} field must contain less than {2} characters"
        ),
        "min" => array(
            "handler" => "_validateMin",
            "message" => "The {0} field must contain more than {2} characters"
        )
    );

}

//
//    /**
//     * @read
//     */
//    protected $_errors = array();
//
//    protected function _validateRequired($value)
//    {
//        return !empty($value);
//    }
//
//    protected function _validateAlpha($value)
//    {
//        return StringMethods::match($value, "#^([a-zA-Z]+)$#");
//    }
//
//    protected function _validateNumeric($value)
//    {
//        return StringMethods::match($value, "#^([0–9]+)$#");
//    }
//
//    protected function _validateAlphaNumeric($value)
//    {
//        return StringMethods::match($value, "#^([a-zA-Z0-9]+)$#");
//    }
//
//    protected function _validateMax($value, $number)
//    {
//        return strlen($value) <= (int) $number;
//    }
//
//    protected function _validateMin($value, $number)
//    {
//        return strlen($value) >= (int) $number;
//    }
//
//    public function validate()
//    {
//        $this->_errors = array();
//        $columns = $this->getColumns();
//
//        foreach ($columns as $column) {
//            if ($column["validate"]) {
//                $error = false;
//                $pattern = "#[a-z] + \(([a-zA-Z0-9, ]+)\)#";
//
//                $raw = $column["raw"];
//                $name = $column["name"];
//                $validators = $column["validate"];
//                $label = $column["label"];
//
//                $defined = $this->getValidators();
//
//                foreach ($validators as $validator) {
//                    $function = $validator;
//                    $arguments = array(
//                        $this->$raw
//                    );
//
//                    $match = StringMethods::match($validator, $pattern);
//
//                    if (count($match) > 0) {
//                        $matches = StringMethods::split($match[0], ",\s*");
//                        $arguments = array_merge($arguments, $matches);
//                        $offset = StringMethods::indexOf($validator, "(");
//                        $function = substr($validator, 0, $offset);
//                    }
//                }
//                if (!isset($defined[$function])) {
//                    throw new Exception\Validation("The {$function} validator is not defined");
//                }
//
//                $template = $defined[$function];
//
//                if (!call_user_func_array(array($this, $template["handler"]), $arguments)) {
//                    $replacements = array_merge(array(
//                        $label ? $label : $raw
//                            ), $arguments);
//
//                    $message = $template["message"];
//                    foreach ($replacements as $i => $replacement) {
//                        $message = str_replace("{{$i}}", $replacement, $message);
//                    }
//
//                    if (!isset($this->_errors[$name])) {
//                        $this->_errors[$name] = array();
//                    }
//                    $this->_errors[$name][] = $message;
//                    $error = true;
//                }
//            }
//        }
//
//        return !$error;
//    }
//
//}
