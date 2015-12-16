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

    public static function checkEmailAvailability($email) {
        if (!$email) {
            return false;
        }
        $userCount = self::count_by_email($email);
        if ($userCount >= 1) {
            return false;
        }
        return true;
    }

    public static function checkPhoneNumberAvailability($phoneNumber) {
        $config = new Config();
        $defCountryCode = $config->values['defaultPhoneCountryCode'];
        $defCountryCodeLength = strlen($defCountryCode);
        if (!$phoneNumber) {
            return false;
        }
        $userCount = self::count_by_phone_number($phoneNumber);
        if ($userCount >= 1) {
            return false;
        }
        // Def country code checking
        if (substr($phoneNumber, 0, $defCountryCodeLength) != $defCountryCode) {
            $phoneNumber = $defCountryCode . $phoneNumber;
            $userCount = self::count_by_phone_number($phoneNumber);
            if ($userCount >= 1) {
                return false;
            }
        } else {
            $phoneNumber = substr($phoneNumber, $defCountryCodeLength);
            $userCount = self::count_by_phone_number($phoneNumber);
            if ($userCount >= 1) {
                return false;
            }
        }
        return true;
    }

    public function register() {
        $user = new self();
        $registerData = $user->parseRegisterDataFromGET();
        $user->set_attributes($registerData);
        $user->is_invalid();
        if (!self::checkEmailAvailability($registerData['email'])) {
            $user->errors->add("email", "is already taken");
        }
        if (!self::checkPhoneNumberAvailability($registerData['phone_number'])) {
            $user->errors->add("phone_number", "is already taken");
        }
        if ($user->errors->is_empty()) {
            $user->save(false);
        }
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
        if ($this->errors->is_empty()) {
            return json_encode(['status' => 'success']);
        }
        return json_encode(['status' => 'error', 'errors' => $this->errors->full_messages()]);
    }
    
    public static function login() {
        $email = filter_input(INPUT_GET, "email", FILTER_VALIDATE_EMAIL);
        if(!$email) {
            echo "memes_email";
            return false;
        }
        $password = filter_input(INPUT_GET, "password", FILTER_UNSAFE_RAW);
        if(!$password) {
            echo "memes_password";
            return false;
        }
        $user = self::find_by_email($email);
        if(!$user) {
            echo "memes_findemail" . $email;
            return false;
        }
        $passwordCheck = password_verify($password, $user->password);
        if(!$passwordCheck) {
            echo "memes_passwordcheck";
            return false;
        }
        $session = Session::start($user);
        if(!$session) {
            return false;
        }
        return $session->id;
    }
}
