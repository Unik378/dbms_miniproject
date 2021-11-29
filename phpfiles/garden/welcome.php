<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


session_start();
require("db.php");

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
  header("location: login.php");
}

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'])
{
  if($_SESSION['username'] == 'admin')
  {
      header("location: ./msadmin/adminwel.php");
      exit;
  }
}
    $query = "SELECT * FROM gardener WHERE mobile = '{$_SESSION["username"]}'";
    $result = mysqli_query($db,$query) or die(mysqli_error($db));
    $empid = mysqli_fetch_assoc($result);

    $empid = $empid['empid'];
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <link rel="stylesheet" href="style.css">
  <title>Monthly Work</title>
</head>
<style>
  h3{
    text-align: center;
    color: blue;
  }
</style>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Market Shop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item active">
        <a class="nav-link" href="welcome.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="request.php">Equipment Request</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="cancelrequest.php">Cancel Request</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
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

<h3 style="text-align: center;">Monthly Work:</h3>
<div>
  <?php
    $query = "SELECT * FROM gardener NATURAL JOIN gardening NATURAL JOIN garden WHERE empid = $empid AND DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(curdate(), '%Y-%m')";
    $res = mysqli_query($db,$query) or die(mysqli_error($db));
    
    echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">DATE:</th>
                <th scope="col">Garden</th>
                <th scope="col">Location</th>
                <th scope="col">WORK TYPE</th>
                <th scope="col">Attendence</th>
              </tr>
            </thead>
            <tbody>';

      while($row = mysqli_fetch_assoc($res))
      {
        echo '<tr>';
        echo '<td>'.$row['date'].'</td>';
        echo '<td>'.$row['gardenid'].'</td>';
        echo '<td>'.$row['location'].'</td>';
        echo '<td>'.$row['worktype'].'</td>';
        echo '<td>'.$row['attendence'].'</td>';
        echo '</tr>';
      }
      echo '</tbody>
      </table>';
  ?>
</div>
<br>
<div>
  <h3>Request Status:</h3>
  <?php
    $query = "SELECT * FROM request WHERE empid = $empid AND request.status <> 'ACCEPTED'";
    $req = mysqli_query($db,$query) or die(mysqli_error($db));

    echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Request ID</th>
                <th scope="col">Request Date</th>
                <th scope="col">Equipment Type</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>';

      while($row = mysqli_fetch_assoc($req))
      {
        echo '<tr>';
        echo '<td>'.$row['reqid'].'</td>';
        echo '<td>'.$row['date'].'</td>';
        echo '<td>'.$row['equiptypeid'].'</td>';
        echo '<td>'.$row['status'].'</td>';
        echo '</tr>';
      }
      echo '</tbody>
      </table>';
  ?>
</div>
<br>
<div>
  <h3>Your Possessions:</h3>
  <?php
    $query = "SELECT * FROM equipments NATURAL JOIN equiptype WHERE owner = '$empid'";
    $possessions = mysqli_query($db,$query) or die(mysqli_error($db));

    echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Equipment ID</th>
                <th scope="col">Equipment Type</th>
                <th scope="col">Cost</th>
              </tr>
            </thead>
            <tbody>';

      while($row = mysqli_fetch_assoc($possessions))
      {
        echo '<tr>';
        echo '<td>'.$row['equipid'].'</td>';
        echo '<td>'.$row['name'].'</td>';
        echo '<td>'.$row['cost'].'</td>';
        echo '</tr>';
      }
      echo '</tbody>
      </table>';
  ?>
</div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>