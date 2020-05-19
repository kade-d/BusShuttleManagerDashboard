<?php


use PHPUnit\Framework\TestCase;

require __DIR__ . "/GetToken.php";

class GetTokenTest extends TestCase
{
    private $baseUrl = "http://localhost/BusShuttleAPI/public/";

    public function testCanGetToken(){
        $token = GetToken::acquireToken($this->baseUrl, "pepsi@gmail.com", "password");
        self::assertNotEmpty($token);
    }
}
