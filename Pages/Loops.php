<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(dirname(__FILE__) . '/../DataLink/AccessLayer.php');

$_SESSION["Title"] = "Loops";

$input = "";
$results = null;

if (isset($_POST['SubmitButton'])) {
  $input = $_POST['inputText'];
  if ($input != '') {
    postLoop($input);
  }
  header('Location: Loops.php');
}

function makeList(&$results)
{
  $AccessLayer = new AccessLayer($_SESSION['api_token']);
  $results = $AccessLayer->get_loops();
}

function postLoop($input)
{
  $AccessLayer = new AccessLayer();
  $AccessLayer->add_loop($input);
}
?>
<?php
require '../themepart/resources.php';
require '../themepart/sidebar.php';
require '../themepart/pageContentHolder.php';
?>
<html>

<head>

</head>

<body>
  <div align="center">

    <?php
    makeList($results);
    ?>


    <div class="d-flex justify-content-center">
      <p>
        <h3>Create a New Loop</h3>
      </p>
    </div>

    <br>
    <div class="d-flex justify-content-center">
      <form action="" method="post">
        <div class="form-row align-items-center">
          <div class="col-auto">
            <label class="sr-only" for="inlineFormInput">Loop Name</label>
            <input type="text" class="form-control mb-2" name='inputText' id="inlineFormInput" placeholder="enter loop name">
          </div>
          <div class="col-auto">
            <button type="submit" name="SubmitButton" class="btn btn-dark mb-2">Create</button>
          </div>
        </div>
      </form>
    </div>

    <table id="editable_table" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Loop</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($results as $loop) : ?>
          <tr>
            <td><?php echo $loop->loopName; ?></td>
            <td style="display:none;"><?php echo $loop->id; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
<script>
  $(document).ready(function() {
    $('#editable_table').Tabledit({
      url: '../Actions/actionLoops.php',
      buttons: {
        confirm: {
            class: 'btn btn-lg btn-danger',
            html: 'This action will remove  </br>  the associated </br> stops from route. </br> Click here to proceed'
        }
    },
      columns: {
        identifier: [1, 'id'],
        editable: [
          [0, 'loop']
        ]
      }
    });
  });
</script>

</html>
<?php require '../themepart/footer.php'; ?>