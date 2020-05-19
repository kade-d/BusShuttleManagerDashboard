<?php

require ('../Model/User.php');

require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../DataLink/AccessLayer.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$_SESSION["Title"]="Drivers";

$userNames = array();
$firstName = "";
$lastName = "";

function makeList(&$userNames) {
    $AccessLayer = new AccessLayer($_SESSION["api_token"]);

    $results = $AccessLayer->getDrivers();
    if($results){
        foreach ($results as $user) {
            array_push($userNames, $user);
        }
    }
}
?>
<html>
<head>

    <?php
  require '../themepart/resources.php';
  require '../themepart/sidebar.php';
  require '../themepart/pageContentHolder.php';
  ?>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    makeList($userNames);
    ?>
    <div id="response"></div>
    <h2><button class="btn btn-danger" style="color: white; background-color: #BA0C2F; border-color: #BA0C2F;"
            id="hideshow" value="New Driver">New Driver</button></h2>
    <form id='form' style="display: none;">
        <div class="form-group">
            <label for="firstname">Firstname</label>
            <input type="text" class="form-control" name="firstname" id="firstname" required />
        </div>

        <div class="form-group">
            <label for="lastname">Lastname</label>
            <input type="text" class="form-control" name="lastname" id="lastname" required />
        </div>

        <div class="form-group">
            <label for="email">Username</label>
            <input type="text" class="form-control" name="email" id="email" required />
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="text" class="form-control" name="password" id="password" required />
        </div>

        <button type='submit' id="submit" class='btn btn-danger btn-block'
            style="color: white; background-color: #BA0C2F; border-color: #BA0C2F;">Create Driver</button>
    </form>
    <h2>Existing Drivers</h2>
    <table id="editable_table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userNames as $log): ?>
            <tr>
                <td style="display:none;"><?php echo "$log->id"; ?></td>
                <td><?php echo "$log->firstName"; ?></td>
                <td><?php echo "$log->lastName"; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</body>

<script>
$(document).ready(function() {
    $('#hideshow').on('click', function(event) {
        $('#form').toggle('show');
    });

    $('#editable_table').Tabledit({
        url: '../Actions/actionUsers.php',
        columns: {
            identifier: [0, 'id'],
            editable: [
                [1, 'firstname'],
                [2, 'lastname']
            ]
        }
    });

});
</script>

<script>
$(document).on('submit', '#form', function() {

    var form = $(this);
    var form_data = JSON.stringify(form.serializeObject());
    var token = JSON.stringify($)

    $.ajax({
        url: '<?php echo BASE_API_URL;?>/api/drivers',
        type: "POST",
        contentType: 'application/json',
        header:
        data: form_data,
        success: function(result) {
            $('#response').html(
                "<div class='alert alert-success'>Success! Driver has been created.</div>");
            form.find('input').val('').serialize();
        },
        error: function(xhr, resp, text) {
            $('#response').html(
                resp + text +
                "<div class='alert alert-danger'>Unable to create driver. Please try again or contact an administrator.</div>"
                );
        }
    });
    return false;
});

$.fn.serializeObject = function() {

    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
</script>

</html>
<?php require '../themepart/footer.php'; ?>