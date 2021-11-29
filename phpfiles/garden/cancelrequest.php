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

$emptyerror = false;
$invaliderror = false;
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reqid"])) {

    $reqid = $_POST["reqid"];
    $username = $_SESSION['username'];
    
    if (empty($reqid)) 
    {
        $emptyerror = true;
    }
    else 
    {
      $query = "SELECT * FROM request WHERE reqid = $reqid AND empid = $empid AND status = 'PENDING'";
      $result = mysqli_query($db, $query) or die(mysqli_error($db));

      $numrows = mysqli_num_rows($result);

      if($numrows == 0)
      {
        $invaliderror = true;
      }
      else
      {
        $query = "DELETE FROM request WHERE reqid = $reqid";
        // echo $query;
        mysqli_query($db, $query) or die(mysqli_error($db));

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

  <link rel="stylesheet" href="style.css">
  <title>Market Shop</title>
</head>

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

  <div>
  <h3>Pending Requests:</h3>
  <?php
    $query = "SELECT * FROM request NATURAL JOIN equiptype WHERE empid = $empid AND request.status = 'PENDING'";
    $req = mysqli_query($db,$query) or die(mysqli_error($db));

    echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Request ID</th>
                <th scope="col">Request Date</th>
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
        echo '<td>'.$row['name'].'</td>';
        echo '<td>'.$row['equiptypeid'].'</td>';
        echo '<td>'.$row['status'].'</td>';
        echo '</tr>';
      }
      echo '</tbody>
      </table>';
  ?>
</div>
<br><br>
  <form action="cancelrequest.php" method="POST">
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
    if ($success) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Your request has been cancelled successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    ?>
    <div class="mb-3">
      <label for="reqid" class="form-label">Request ID:</label>
      <input type="reqid" class="form-control" id="reqid" name="reqid">
    </div>
    <br>
    <div class="subbutton">
      <button type="submit" class="btn btn-primary">Cancel Request</button>
    </div>
  </form>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>