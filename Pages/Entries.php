<?php

require_once(dirname(__FILE__) . '/../DataLink/AccessLayer.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$_SESSION["Title"] = "Entries in the Database";


$entries = null;
$input = "";
$loopDropdown = array();
$loop = "";
$buttonState = "disabled";
$accessLayer = new AccessLayer($_SESSION['api_token']);
$loopDropdown = $accessLayer->get_loops();


// If Submit is Clicked
if (isset($_POST['SubmitButton'])) {
    $input = $_POST['loop'];
    $dateInput = $_POST['dateInput'];
    if ($input != '' && $dateInput != '') {

        $newDate = date("Y-m-d", strtotime($dateInput));
        makeList($entries, $newDate, $input);
    }
    // header('Location: Entries.php');

}

function makeList(&$entries, $date, $loopID)
{
    $accessLayer = new AccessLayer($_SESSION['api_token']);
    $entries = $accessLayer->get_entries_by_date_and_loopID($date, $loopID);
}
?>

<?php
require '../themepart/resources.php';
require '../themepart/sidebar.php';
require '../themepart/pageContentHolder.php';
?>

<HTML LANG="EN">

<HEAD><title></title></HEAD>

<form method=post></form>

<body>
<div class="d-flex justify-content-center">
    <form action="" method="post">
        <div class="form-row align-items-center">
            <div class="col-auto">
                <input class="form-control mb-2" input="text" name="dateInput" id="datepicker" width="276" placeholder="Click to Select Date" required />
            </div>
            <div class="col-auto">
                <select class="form-control mb-2" name="loop" id="loop">
                    <option selected="selected">Select a Loop</option>
                    <?php
                    foreach ($loopDropdown as $loop) { ?>
                        <option name="loop" value="<?= $loop->id ?>"><?= $loop->loopName ?>
                        </option>
                    <?php
                    } ?>
                </select>
            </div>
            <div id='submitElement' class="col-auto">
                <button type="submit" id='submitButton' name="SubmitButton" class="btn btn-dark mb-2" <?php echo $buttonState; ?> >Search</button>
                <span id="loadingMessage"> loading...</span>
            </div>
        </div>
    </form>
</div>
    <table id="editable_table"  class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Boarded</th>
                <th>Left Behind</th>
                <th>Stop</th>
                <th>Time</th>
                <th>Date</th>
                <th>Loop</th>
                <th>Driver</th>
                <th>Bus</th> 
            </tr>
        </thead>
        <tbody id="loadingTable" style="display:none" class="row_position">
            <?php if(isset($entries)){ foreach ($entries as $entry) :?>
                <tr id="<?php echo $entry->id ?>">
                    <td><?php echo $entry->boarded; ?></td>
                    <td><?php echo $entry->left_behind; ?></td>
                    <td><?php echo $AccessLayer->get_stop_name($entry->stop)[0]->stops; ?></td>
                    <td><?php echo $entry->t_stamp; ?></td>
                    <td><?php echo $entry->date_added; ?></td>
                    <td><?php echo $AccessLayer->get_loop_name($entry->loop)[0]->loops; ?></td>
                    <td><?php echo $AccessLayer->get_user_name($entry->driver)[0]->firstname . " " . $AccessLayer->get_user_name($entry->driver)[0]->lastname ; ?></td>
                    <td><?php echo $AccessLayer->get_bus_name($entry->bus_identifier)[0]->busIdentifier; ?></td>
                    <td style="display:none;"><?php echo $entry->id; ?></td>
                    
                </tr>
            <?php endforeach ;} ?>
        </tbody>
    </table>
    
    <script>
        $('#datepickerHourly').datepicker();
    </script>



</body>
<script>
    $('#datepicker').datepicker();
</script>
<script>
    $(document).ready(function() {
        
        /*
        $('#editable_table').Tabledit({
            url: '../Actions/actionEntries.php',
            hideIdentifier: true,
            deleteButton: false,
            editButton: false,
            columns: {
                identifier: [8, 'id'],
                editable: [
                    [0, 'boarded'],
                    [1, 'leftBehind']
                ]
            }
        });
        */
        $('#loadingTable').removeAttr("style");
        $('#loadingMessage').hide();
        $('#submitButton').prop('disabled', false)
    });
</script>



</HTML>

<?php require '../themepart/footer.php'; ?>