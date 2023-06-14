<?php
namespace Model;

class Validation
{
    public $errors = [];

    public function validateUnique($table, $key, $value)
    {
        $query = "SELECT $table.$key FROM $table WHERE $key = ?;";
        $data = Db::query($query, [$value]);

        if ($data == true) {
            $this->addError($key, $key . ' that you entered is already exists');
        } else {
            $value = trim($value);
            return $value;
        }
    }

    protected function validateString($key, $string)
    {

        if (!isset($string) || $string == '') {
            $this->addError($key, 'This field is required, Please provide ' . $key);
        } else {
            $string = trim($string);
            return $string;
        }
    }

    protected function validateType($type, $value)
    {
        if (!isset($value) || $value == 'DefaultType') {
            $this->addError($type, 'The type is required, Please select type');
        } else {
            $value = trim($value);
            return $value;
        }
    }

    protected function validateFloat($key, $float)
    {
        if (!isset($float) || $float == '') {
            $this->addError($key, 'This field is required, Please provide ' . $key);
        } elseif (!filter_var($float, FILTER_VALIDATE_FLOAT) || $float <= 0 ) {
            $this->addError($key, 'Enter a valid number');
        } else {
            $float = trim($float);
            return $float;
        }
    }

    protected function addError($key, $value)
    {
        $this->errors[$key] = $value;
    }
}
