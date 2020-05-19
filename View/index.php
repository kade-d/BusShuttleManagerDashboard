<?php
require ('../Model/User.php');

require_once(dirname(__FILE__) . '/../DataLink/AccessLayer.php');

//instance of AccessLayer
$AccessLayer = new AccessLayer();

$users = Array(1);

foreach ($users as $user) {
    $results = GetRequest::executeGetRequest();
    echo "<h1>Users by $user</h1>";
    //$AccessLayer->update_user(1, "hello", "world");
    //$AccessLayer->remove_user(1);

    if ($results){
        echo "<ul>";
        foreach ($results as $user) {
           echo "<li>$user->firstname (Database ID: $user->id)</li>";
       }
        echo "</ul>";
    } else {
        echo "Sorry nothing to show here.";
    }
}


?>