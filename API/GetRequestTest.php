<?php

use PHPUnit\Framework\TestCase;

require __DIR__ . "/GetToken.php";
require __DIR__ . "/GetRequest.php";
require __DIR__ . "/APIEndpoints.php";
include_once('../Model/User.php');
include_once('../Model/Loop.php');

class GetRequestTest extends TestCase
{

    private $baseUrl = "http://localhost/BusShuttleAPI/public/";

    public function testGetBusesIsValid(){
        $responseJSON = GetRequest::executeGetRequest($this->baseUrl, APIEndpoints::$BUS_NUMBERS, GetToken::acquireToken($this->baseUrl, "pepsi@gmail.com", "password"));

        self::assertNotEmpty($responseJSON);
        self::assertNotEquals(FALSE, $responseJSON); //curl returns FALSE on failure

        $responseArray = json_decode($responseJSON, 1);

        self::assertIsArray($responseArray);
        self::assertIsArray($responseArray["data"]);
    }

    public function testGetUsersIsValid(){
        $responseJSON = GetRequest::executeGetRequest($this->baseUrl, APIEndpoints::$USERS);

        self::assertNotEmpty($responseJSON);
        self::assertNotEquals(FALSE, $responseJSON); //curl returns FALSE on failure

        $responseJSON = GetRequest::executeGetRequest($this->baseUrl, APIEndpoints::$USERS);
        $responseArray = json_decode($responseJSON, 1);

        self::assertIsArray($responseArray);
        self::assertIsArray($responseArray["data"]);
    }

    public function testCanCreateUserFromGet(){
        $responseJSON = GetRequest::executeGetRequest($this->baseUrl, APIEndpoints::$USERS);
        $responseArray = json_decode($responseJSON, 1);

        $object_results = array();
        $count = 0;
        foreach ($responseArray as $user) {
            $userJson = $user[$count];
            $object_results[$count] = new User($userJson["id"], $userJson["firstname"], $userJson["lastname"]);
            $count+=1;
        }
        self::assertNotEmpty($object_results[0]->id);
    }

    public function testGetLoopsIsValid(){
        $responseJSON = GetRequest::executeGetRequest($this->baseUrl, APIEndpoints::$LOOPS);

        self::assertNotEmpty($responseJSON);
        self::assertNotEquals(FALSE, $responseJSON); //curl returns FALSE on failure

        $responseJSON = GetRequest::executeGetRequest($this->baseUrl, APIEndpoints::$LOOPS);
        $responseArray = json_decode($responseJSON, 1);

        self::assertIsArray($responseArray);
        self::assertIsArray($responseArray["data"]);
    }

    public function testCanCreateLoopFromGet(){
        $responseJSON = GetRequest::executeGetRequest($this->baseUrl, APIEndpoints::$LOOPS);
        $responseArray = json_decode($responseJSON, 1);

        $object_results = array();
        $count = 0;
        foreach ($responseArray as $loop) {
            $loopJSON = $loop[$count];
            $object_results[$count] = new Loop($loopJSON["id"], $loopJSON["loops"]);
            self::assertNotEmpty($object_results[$count]->id);
            $count+=1;
        }
    }

}