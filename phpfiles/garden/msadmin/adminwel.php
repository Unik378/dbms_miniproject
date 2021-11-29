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

<style>
  h3{
    text-align: center;
    color: blue;
  }
  h4{
    color: orangered;
  }
</style>

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

  <br>
  <div>
  <h3>Work Assignments Today Onwards:</h3>
  <?php
    $query = "SELECT * FROM gardener NATURAL JOIN gardening NATURAL JOIN garden WHERE date >= curdate() ORDER BY date";
    $contracts = mysqli_query($db,$query) or die(mysqli_error($db));

    echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Date</th>
                <th scope="col">Gardener ID</th>
                <th scope="col">Name</th>
                <th scope="col">Mobile</th>
                <th scope="col">Location</th>
                <th scope="col">Garden ID</th>
                <th scope="col">Work Type</th>
                <th scope="col">Hours</th>
              </tr>
            </thead>
            <tbody>';

      while($row = mysqli_fetch_assoc($contracts))
      {
        echo '<tr>';
        echo '<td>'.$row['date'].'</td>';
        echo '<td>'.$row['empid'].'</td>';
        echo '<td>'.$row['name'].'</td>';
        echo '<td>'.$row['mobile'].'</td>';
        echo '<td>'.$row['location'].'</td>';
        echo '<td>'.$row['gardenid'].'</td>';
        echo '<td>'.$row['worktype'].'</td>';
        echo '<td>'.$row['manhours'].'</td>';
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
  <h3>Equipments in Stock:</h3>
  <?php
    $query = "SELECT * FROM equipments NATURAL JOIN equiptype WHERE owner = 'IITP'";
    $req = mysqli_query($db,$query) or die(mysqli_error($db));

    echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Equipment ID</th>
                <th scope="col">Equipment Type</th>
                <th scope="col">Equipment Type ID</th>
                <th scope="col">Cost</th>
              </tr>
            </thead>
            <tbody>';

      while($row = mysqli_fetch_assoc($req))
      {
        echo '<tr>';
        echo '<td>'.$row['equipid'].'</td>';
        echo '<td>'.$row['name'].'</td>';
        echo '<td>'.$row['equiptypeid'].'</td>';
        echo '<td>'.$row['cost'].'</td>';
        echo '</tr>';
      }
      echo '</tbody>
      </table>';
  ?>
</div>
<br>
<div>
  <h3>Equipments with Gardeners:</h3>
  <?php
    $query = "SELECT * FROM equipments NATURAL JOIN equiptype WHERE owner NOT LIKE 'V-%' AND owner <> 'IITP'";
    $req = mysqli_query($db,$query) or die(mysqli_error($db));

    echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Equipment ID</th>
                <th scope="col">Equipment Type</th>
                <th scope="col">Equipment Type ID</th>
                <th scope="col">Gardener ID</th>
                <th scope="col">Name</th>
                <th scope="col">Mobile</th>
              </tr>
            </thead>
            <tbody>';

      while($row = mysqli_fetch_assoc($req))
      {
        $owner = $row['owner'];
        $query = "SELECT * FROM gardener WHERE empid = $owner";
        $result = mysqli_query($db,$query) or die(mysqli_error($db));

        $row1 = mysqli_fetch_assoc($result);

        echo '<tr>';
        echo '<td>'.$row['equipid'].'</td>';
        echo '<td>'.$row['name'].'</td>';
        echo '<td>'.$row['equiptypeid'].'</td>';
        echo '<td>'.$row['owner'].'</td>';
        echo '<td>'.$row1['name'].'</td>';
        echo '<td>'.$row1['mobile'].'</td>';
        echo '</tr>';
      }
      echo '</tbody>
      </table>';
  ?>
</div>
<br>
<div>
  <h3>Equipments In Repair:</h3>
  <?php
    $query = "SELECT * FROM equipments NATURAL JOIN equiptype NATURAL JOIN repair NATURAL JOIN vendor WHERE owner LIKE 'V-%' AND returndate = '2001-01-01'";
    $req = mysqli_query($db,$query) or die(mysqli_error($db));

    echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Equipment ID</th>
                <th scope="col">Equipment Type</th>
                <th scope="col">Equipment Type ID</th>
                <th scope="col">Sent in Repair</th>
                <th scope="col">Vendor ID</th>
                <th scope="col">Name</th>
                <th scope="col">Mobile</th>
              </tr>
            </thead>
            <tbody>';

      while($row = mysqli_fetch_assoc($req))
      {
        $owner = $row['owner'];

        echo '<tr>';
        echo '<td>'.$row['equipid'].'</td>';
        echo '<td>'.$row['name'].'</td>';
        echo '<td>'.$row['equiptypeid'].'</td>';
        echo '<td>'.$row['repairdate'].'</td>';
        echo '<td>'.$row['owner'].'</td>';
        echo '<td>'.$row['vname'].'</td>';
        echo '<td>'.$row['mobile'].'</td>';
        echo '</tr>';
      }
      echo '</tbody>
      </table>';
  ?>
</div>
<br>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>