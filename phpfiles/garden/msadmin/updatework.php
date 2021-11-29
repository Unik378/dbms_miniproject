<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();
require("./../db.php");

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
    header("location: ./../login.php");
}

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'])
{
    if($_SESSION['username'] != 'admin')
    {
        header("location: ./../welcome.php");
        exit;
    }
}

$emptyerror = false;
$success = false;

if($_SERVER["REQUEST_METHOD"] == "POST")
{
  $gardenid = $_POST["gardenid"];
  $empid = $_POST["empid"];
  $date = $_POST["date"];
  $worktype = $_POST["worktype"];

  if(empty($gardenid) || empty($empid) || empty($date) || empty($worktype))
  {
    $emptyerror = true;
  }
  else
  {
    $query = "UPDATE gardening SET gardenid = '$gardenid' WHERE empid = $empid AND date = '$date'";
    mysqli_query($db,$query) or die(mysqli_error($db));

    $query = "UPDATE gardening SET worktype = '$worktype' WHERE empid = $empid AND date = '$date'";
    mysqli_query($db,$query) or die(mysqli_error($db));

    $success = true;
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <link rel="stylesheet" href="./../style.css">
  <title>Landscaping</title>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">IITP Landscaping</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
      <li class="nav-item active">
          <a class="nav-link" href="adminwel.php">Home</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="attendence.php">Mark Attendence</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="updatework.php">Update Work</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="requestdetails.php">Request Details</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="repair.php">Repair</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="repairreturn.php">Repair Return</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="equipreturn.php">Equipment Return</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./../logout.php">Logout</a>
        </li>
      </ul>
      <div class="navbar-collapse collapse">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#"> <img src="https://img.icons8.com/metro/26/000000/guest-male.png"> <?php echo "Welcome " . $_SESSION['username'] ?></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div>
  <h3>Gardener Details:</h3>
  <?php
    $query = "SELECT * FROM gardener WHERE empid <> 0";
    $contracts = mysqli_query($db,$query) or die(mysqli_error($db));

    echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Gardener ID</th>
                <th scope="col">Name</th>
                <th scope="col">Mobile</th>
                <th scope="col">Date of Joining</th>
              </tr>
            </thead>
            <tbody>';

      while($row = mysqli_fetch_assoc($contracts))
      {
        echo '<tr>';
        echo '<td>'.$row['empid'].'</td>';
        echo '<td>'.$row['name'].'</td>';
        echo '<td>'.$row['mobile'].'</td>';
        echo '<td>'.$row['doj'].'</td>';
        echo '</tr>';
      }
      echo '</tbody>
      </table>';
  ?>
</div>
<br>

<div>
  <h3>Garden Details:</h3>
  <?php
    $query = "SELECT * FROM garden";
    $contracts = mysqli_query($db,$query) or die(mysqli_error($db));

    echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Garden ID</th>
                <th scope="col">Location</th>
                <th scope="col">Hours</th>
              </tr>
            </thead>
            <tbody>';

      while($row = mysqli_fetch_assoc($contracts))
      {
        echo '<tr>';
        echo '<td>'.$row['gardenid'].'</td>';
        echo '<td>'.$row['location'].'</td>';
        echo '<td>'.$row['manhours'].'</td>';
        echo '</tr>';
      }
      echo '</tbody>
      </table>';
  ?>
</div>
<br>
  <form action="updatework.php" method="POST">
    <?php
      if ($emptyerror) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  Enter all feilds!
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
      }
      if ($success) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  Updated Successfully.
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
      }
      ?>
      <div>
        <label for="gardenid">Garden ID:</label>
        <input type="text" class="form-control" name="gardenid" id="gardenid">
      </div>
      <div>
        <label for="empid">Gardener ID:</label>
        <input type="number" class="form-control" name="empid" id="empid">
      </div>
      <div>
        <label for="date">Date:</label>
        <input type="date" min = "<?php echo date('Y-m-d') ?>" max = "<?php echo date("Y-m-t", strtotime(date('Y-m-d'))) ?>" class="form-control" name="date" id="date">
      </div>
      <div>
      <label for="worktype">Work Type:</label>
        <select id="worktype" name="worktype" class="form-control">
          <option disabled selected value> -- select an option -- </option>;
          <option value = 'Watering'>Watering</option>
          <option value = 'Grass Cutting'>Grass Cutting</option>
          <option value = 'Flowering'>Flowering</option>
        </select>
      </div>
    <br>
    <div class="subbutton">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
</body>
<br><br>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>