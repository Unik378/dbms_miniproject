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
$notavailable = false;
$success = false;

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reqid"]))
{
  if(empty($_POST["reqid"]) || empty($_POST["status"]))
  {
    $emptyerror = true;
  }
  else
  {
    $reqid = $_POST["reqid"];
    $status = $_POST["status"];
    
    $query = "SELECT * FROM request WHERE reqid = $reqid AND status = 'PENDING'";
    $pendingrequest = mysqli_query($db,$query) or die(mysqli_error($db));

    $numrows = mysqli_num_rows($pendingrequest);
    if($numrows == 0)
    {
      $invaliderror = true;
    }
    else
    {
        if($status == 'DENIED')
        {
            $query = "UPDATE request SET request.status = 'DENIED' WHERE reqid = $reqid";
            mysqli_query($db,$query) or die(mysqli_error($db));
        }
        else
        {   
            $row = mysqli_fetch_assoc($pendingrequest);
            $equiptypeid = $row['equiptypeid'];
            $empid = $row['empid'];

            $query = "SELECT * FROM equipments WHERE owner = 'IITP' AND equiptypeid = '$equiptypeid' LIMIT 1";
            $result = mysqli_query($db,$query) or die(mysqli_error($db));

            $numrows = mysqli_num_rows($result);

            $row = mysqli_fetch_assoc($result);

            $equipid = $row['equipid'];

            if($numrows == 0)
            {
              $notavailable = true;
              $query = "UPDATE request SET request.status = 'DENIED' WHERE reqid = $reqid";
              mysqli_query($db,$query) or die(mysqli_error($db));
            }
            else
            {
              $query = "UPDATE request SET request.status = 'ACCEPTED' WHERE reqid = $reqid";
              mysqli_query($db,$query) or die(mysqli_error($db));
              $query = "UPDATE equipments SET owner = '$empid' WHERE equipid = '$equipid'";
              mysqli_query($db,$query) or die(mysqli_error($db));

              $success = true;
            }
        }
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
  <h3>PENDING requests:</h3>
  <?php
    $query = "SELECT *, gardener.name as name1 FROM request JOIN gardener JOIN equiptype WHERE request.empid = gardener.empid AND request.equiptypeid = equiptype.equiptypeid AND request.status = 'PENDING'";
    $req = mysqli_query($db,$query) or die(mysqli_error($db));

    echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Request ID</th>
                <th scope="col">Request Date</th>
                <th scope="col">Gardener ID</th>
                <th scope="col">Name</th>
                <th scope="col">Equipment Type</th>
                <th scope="col">Equipment Type ID</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>';

      while($row = mysqli_fetch_assoc($req))
      {
        echo '<tr>';
        echo '<td>'.$row['reqid'].'</td>';
        echo '<td>'.$row['date'].'</td>';
        echo '<td>'.$row['empid'].'</td>';
        echo '<td>'.$row['name1'].'</td>';
        echo '<td>'.$row['name'].'</td>';
        echo '<td>'.$row['equiptypeid'].'</td>';
        echo '<td>'.$row['status'].'</td>';
        echo '</tr>';
      }
      echo '</tbody>
      </table>';
  ?>
</div>
<!-- form for booking details -->
  <form action="requestdetails.php" method="POST">
    <?php
      if ($emptyerror) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  Enter all feilds!
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
      }
      if ($invaliderror) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  Invalid Request ID!
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
      }
      if ($notavailable) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  Equipment Not Available, Hence Request "DENIED"
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
      }
      if ($success) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  Request Accepted.
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
      }
      ?>
      <div>
        <label for="reqid">Request ID</label>
        <input type="number" class="form-control" name="reqid" id="reqid">
      </div>
      <div class="col">
        <label for="status">status</label>
        <select id="status" name="status" class="form-control">
            <option disabled selected value> -- select an option -- </option>';
            <option value="ACCEPTED">Accept</option>
            <option value="DENIED">Deny</option>
        </select>
        </div>
      <br>
      <div class="subbutton">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>