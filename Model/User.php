<?php

class User {

    public $id;
    public $firstName;
    public $lastName;

    /**
     * User constructor.
     * @param $_id
     * @param $firstName
     * @param $lastName
     */
    public function __construct($_id, $firstName, $lastName)
    {
        $this->id = $_id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }


}