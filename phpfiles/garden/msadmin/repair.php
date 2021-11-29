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
$invaliderror = false;
$success = false;

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["equipid"]))
{
  if(empty($_POST["equipid"]) || empty($_POST["vendorid"]))
  {
    $emptyerror = true;
  }
  else
  {
    $equipid = $_POST["equipid"];
    $vendorid = $_POST["vendorid"];
    // echo $vendorid;

    $query = "SELECT * FROM equipments WHERE equipid = '$equipid' AND owner = 'IITP'";
    $equip = mysqli_query($db,$query) or die(mysqli_error($db));
    $row = mysqli_fetch_assoc($equip);

    $owner = $row['owner'];

    $numrows = mysqli_num_rows($equip);

    if($numrows == 0)
    {
      $invaliderror = true;
    }
    else
    {
      $query = "UPDATE equipments SET owner = '$vendorid' WHERE equipid = '$equipid'";
      // echo $query;
      mysqli_query($db,$query) or die(mysqli_error($db));

      $query = "INSERT INTO repair(vendorid, equipid) VALUES ('$vendorid', '$equipid')";
      // echo $query;
      mysqli_query($db,$query) or die(mysqli_error($db));

      $success = true;
    }
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
  <h3>Vendor Details:</h3>
  <?php
    $query = "SELECT * FROM vendor";
    $req = mysqli_query($db,$query) or die(mysqli_error($db));

    echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Vendor ID</th>
                <th scope="col">Name</th>
                <th scope="col">Mobile</th>
                <th scope="col">Address</th>
              </tr>
            </thead>
            <tbody>';

      while($row = mysqli_fetch_assoc($req))
      {
        echo '<tr>';
        echo '<td>'.$row['vendorid'].'</td>';
        echo '<td>'.$row['vname'].'</td>';
        echo '<td>'.$row['mobile'].'</td>';
        echo '<td>'.$row['address'].'</td>';
        echo '</tr>';
      }
      echo '</tbody>
      </table>';
  ?>
</div>
  <form action="repair.php" method="POST">
    <?php
      if ($emptyerror) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  Enter all feilds!
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
      }
      if ($invaliderror) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  Invalid Equipment ID or Equipment not in stock!
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
      }
      if ($success) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  Equipment Sent in Repair.
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
      }
      ?>
      <div>
        <label for="equipid">Equipment ID</label>
        <input type="text" class="form-control" name="equipid" id="equipid">
      </div>
      <br>
      <div>
        <label for="vendorid">Vendor ID:</label>
        <input type="text" class="form-control" name="vendorid" id="vendorid">
      </div>
      <br>
      <div class="subbutton">
      <button type="submit" class="btn btn-primary">Send for Repair</button>
    </div>
    <br>
    <br>
  </form>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>