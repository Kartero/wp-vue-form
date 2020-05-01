<?php
namespace App;

class ObjectValidator
{
    const FIRST_NAME = 'firstName';
    const LAST_NAME = 'lastName';
    const AGE = 'age';
    const EMAIL = 'email';

    /** @var ValidationResult */
    private $validationResult;

    public function __construct()
    {
        $this->validationResult = new ValidationResult();
    }

    /**
     * @param array $data
     * 
     * @return ValidationResult
     */
    public function validate(array $data) : ValidationResult
    {
        $firstName = $data[self::FIRST_NAME]; 
        $firstName ? $this->validateName($firstName, self::FIRST_NAME) : 
            $this->validationResult->addError("Etunimi puuttuu");

        $lastName = $data[self::LAST_NAME]; 
        $lastName ? $this->validateName($lastName, self::LAST_NAME) :
            $this->validationResult->addError("Sukunimi puuttuu");
        
        $age = $data[self::AGE]; 
        $age ? $this->validateAge($age) : $this->validationResult->addError("Ikä puuttuu");

        $email = $data[self::EMAIL];
        $email ? $this->validateEmail($email) :  $this->validationResult->addError("Sähköpostiosoite puuttuu");

        return $this->validationResult;
    }

    /**
     * @param int $age
     * 
     * @return void
     */
    private function validateAge(int $age) : void
    {
        if ($age < 20) {
            $this->validationResult->addError("Sinun pitää olla vähintään 20-vuotias");
        } elseif ($age > 60) {
            $this->validationResult->addError("Sinun pitää olla enintään 60-vuotias");
        }
    }

    /**
     * @param string $name
     * @param string $field
     * 
     * @return void
     */
    private function validateName(string $name, string $field) : void
    {
        if (empty($name)) {
            $this->validationResult->addError(sprintf("%s puuttuu", $field));
        } elseif (\mb_strlen($name) < 2) {
            $this->validationResult->addError(sprintf("%s on liian lyhyt (Vähintään 2 merkkiä)", $this->mapFieldToLabel($field)));
        } elseif (\mb_strlen($name) > 10) {
            $this->validationResult->addError(sprintf("%s on liian pitkä (Enintään 10 merkkiä)", $this->mapFieldToLabel($field)));
        }
    }

    /**
     * @param string $email
     * 
     * @return void
     */
    private function validateEmail(string $email) : void
    {
        if (!\filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->validationResult->addError("Tarkista sähköpostiosoite");
        }
    }

    /**
     * @param string $field
     * 
     * @return string
     */
    private function mapFieldToLabel(string $field) : string
    {
        $map = [
            self::FIRST_NAME => 'Etunimi',
            self::LAST_NAME => 'Sukunimi'
        ];

        return $map[$field] ?? $field;
    }
}