<?php
namespace App;

class ValidationResult
{
    private $errors = [];

    /**
     * @return bool
     */
    public function isValid() : bool
    {
        if (!empty($this->getErrors())) {
            return false;
        }

        return true;
    }

    /**
     * @param string $error
     * 
     * @return void
     */
    public function addError(string $error) : void
    {
        $this->errors[] = $error;
    }

    /**
     * @return array
     */
    public function getErrors() : array
    {
        return $this->errors;
    }
}