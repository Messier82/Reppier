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
        //check if there already exsists session for current ip address
        if(self::count_by_ip_address($ip) != 0) {
            return false;
        }
        $session = new self();
        $session->user_id = $userObj->id;
        $session->ip_address = $ip;
        $timestamp = time(); // used for session id forming, along with IP and used ID
        $session->start_time = $timestamp;
        $session->last_activity = $timestamp;
        $hashString = $session->user_id . $session->ip_address . $timestamp; // generating session id
        $session->id = md5($hashString);
        $session->remember = filter_input(INPUT_GET, 'remember', FILTER_VALIDATE_BOOLEAN);
        $status = $session->save();
        if (!$status) {
            return false;
        }
        return $session;
   }

}
