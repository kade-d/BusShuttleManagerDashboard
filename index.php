<?php

include_once('config.php');
require __DIR__ . "/API/GetToken.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$action = @$_POST['action'];
$username = @$_POST['user'];
$password = @$_POST['pwd'];

$APIToken = null;

header('Content-Type: text/html; charset=UTF-8');

if($username != null) {
    $APIToken = GetToken::acquireToken(BASE_API_URL, $username, $password);
    if($APIToken != null){
        $_SESSION["api_token"] = $APIToken;
        header("Location: ./Pages/Users.php"); /* Redirect browser */
    }
?>
<?php
}
else {
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
<div style="background-color:#BA0C2F;" class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 align="center" style="color:#FFFFFF;" class="display-4">Transportation Management Dashboard</h1>
  </div>
</div>
<form action="index.php" style="text-align: center" method="POST">
    <fieldset>
        <legend>Login</legend>
        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="user"></label>
            <div class="col-md-4">
            <input style="horiz-align: center" id="user" name="user" type="text" placeholder="Username" class="form-control input-md" required="">
            </div>
        </div>

        <!-- Password input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="pwd"></label>
            <div class="col-md-4">
                <input id="pwd" name="pwd" type="password" placeholder="Password" class="form-control input-md" required="">
            </div>
        </div>

        <!-- Multiple Checkboxes -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="autologin"></label>
            <div class="col-md-4">
            <div class="checkbox">
            <label for="autologin-0">
            <input type="checkbox" name="autologin" id="autologin-0" value="1">
            Remember Me
            </label>
            </div>
            </div>
        </div>

        <!-- Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for=""></label>
            <div class="col-md-4">
                <button id="" name="" class="btn btn-lg btn-block btn-dark">Login</button>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="autologin"></label>
        </div>

    </fieldset>
</form>
<?php
}
?>


