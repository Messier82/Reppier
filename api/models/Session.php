<?php
class Session extends ActiveRecord\Model {
    public function start($userObj) {
        $session = new self();
        
        return $session;
    }
}