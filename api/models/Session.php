<?php

class Session extends ActiveRecord\Model {

    // Function to get the client IP address
    private static function get_client_ip() {
        $ipaddress = '';
        if ($_SERVER['HTTP_CLIENT_IP'])
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if ($_SERVER['HTTP_X_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if ($_SERVER['HTTP_X_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if ($_SERVER['HTTP_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if ($_SERVER['HTTP_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if ($_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function start($userObj) {
        $ip = self::get_client_ip();
        $session = new self();
        $session->user_id = $userObj->id;
        $session->ip_address = $ip;
        $session->start_time = time();
        $session->last_activity = time();
        $hashString = $session->user_id . $session->ip_address . time(); // generating session id
        $session->id = md5($hashString);
        $session->remember = filter_input(INPUT_GET, 'remember', FILTER_VALIDATE_BOOLEAN);
        $status = $session->save();
        if (!$status) {
            return false;
        }
        return $session;
   }
   
   public function get_user_data($sessionId) {
       $session = self::find_by_id($sessionId);
       if(!$session) {
           return false;
       }
       $user = User::find_by_id($session->user_id);
       if(!$user)  {
           return false;
       }
       return [
           "id" => $user->id,
           "first_name" => $user->first_name,
           "last_name" => $user->last_name,
           "email" => $user->email,
           "phone_number" => $user->phone_number
       ];
   }

}
