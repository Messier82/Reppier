<?php

class User extends ActiveRecord\Model {

    // Validation conditions
    static $validates_presence_of = [
        ['email'],
        ['password'],
        ['first_name'],
        ['last_name'],
        ['phone_number']
    ];
    static $validates_length_of = [
        ['email', 'maximum' => 30],
        ['first_name', 'within' => [2, 15]],
        ['last_name', 'within' => [2, 20]],
        ['phone_number', 'within' => [8, 16]]
    ];

    public function checkEmailAvailability($email) {
        if (!$email) {
            return false;
        }
        $userCount = self::count_by_email($email);
        if ($userCount == 1) {
            return false;
        }
        return true;
    }

    public function checkPhoneNumberAvailability($phoneNumber) {
        if (!$phoneNumber) {
            return false;
        }
        $userCount = self::count_by_phone_number($phoneNumber);
        if ($userCount == 1) {
            return false;
        }
        if (substr($phoneNumber, 0, 3) != "371") {
            $phoneNumber = "371" . $phoneNumber;
            $userCount = self::count_by_phone_number($phoneNumber);
            if ($userCount == 1) {
                return false;
            }
        }
        return true;
    }

    public function register() {
        $user = new self();
        $registerData = $user->parseRegisterDataFromGET();
        $user->set_attributes($registerData);
        $user->save(true);
        return $user->formatRegisterJsonAnswer();
    }

    private function parseRegisterDataFromGET() {
        $output = [
            "first_name" => filter_input(INPUT_GET, "first_name", FILTER_SANITIZE_STRING),
            "last_name" => filter_input(INPUT_GET, "last_name", FILTER_SANITIZE_STRING),
            "email" => filter_input(INPUT_GET, "email", FILTER_SANITIZE_EMAIL),
            "password" => password_hash(filter_input(INPUT_GET, "password", FILTER_UNSAFE_RAW), PASSWORD_DEFAULT),
            "phone_number" => filter_input(INPUT_GET, "phone_number", FILTER_SANITIZE_NUMBER_INT)
       ];
       return $output;
    }
    
    private function formatRegisterJsonAnswer() {
        if($this->errors->is_empty()) {
            return json_encode(['status' => 'success']);
        }
        return json_encode(['status' => 'error', 'errors' => $this->errors->full_messages()]); 
   }

}
