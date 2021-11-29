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
  $empid = $_POST["empid"];
  $attendence = $_POST["attendence"];

  if(empty($empid) || empty($attendence))
  {
    $emptyerror = true;
  }
  else
  {
    $query = "UPDATE gardening SET attendence = '$attendence' WHERE empid = $empid AND date = curdate()";
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
    <?php
      $query = "SELECT * FROM gardener WHERE empid <> 0";
      $result = mysqli_query($db,$query) or die(mysqli_error($db));

      echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Gardener ID</th>
                <th scope="col">Name</th>
                <th scope="col">Total Attendence</th>
                <th scope="col">Today Attendence</th>
              </tr>
            </thead>
            <tbody>';

      while($row = mysqli_fetch_assoc($result))
      {
        $start = date('Y-m').'-1';
        $total = date('d');
        $empid = $row['empid'];

        $query = "SELECT count(*) as cnt FROM gardening WHERE empid = $empid AND attendence = 'PRESENT' AND date >= '$start' and date <= curdate()";
        $present = mysqli_query($db,$query) or die(mysqli_error($db));

        $present = mysqli_fetch_assoc($present);
        $present = $present['cnt'];

        echo '<tr>';
        echo '<td>'.$row['empid'].'</td>';
        echo '<td>'.$row['name'].'</td>';
        echo '<td>'.$present.'/'.$total.'</td>';

        $query = "SELECT * FROM gardening WHERE empid = $empid AND date = curdate()";
        $res = mysqli_query($db,$query) or die(mysqli_error($db));
        $res = mysqli_fetch_assoc($res);

        if(isset($res['attendence']))
        {
          echo '<td>'.$res['attendence'].'</td>';
        } 
        else
        {
          echo '<td>Not Marked Yet</td>';
        }
        echo '</tr>';
      }
      echo '</tbody>
      </table>';
    ?>
  </div>

  <form action="attendence.php" method="POST">
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
      <label for="empid">Employee ID:</label>
        <select id="empid" name="empid" class="form-control">
          <option disabled selected value> -- select an option -- </option>;
          <?php
            $query = "SELECT * FROM gardening NATURAL JOIN gardener WHERE date = curdate()";
            $result = mysqli_query($db,$query) or die(mysqli_error($db));

            while($row = mysqli_fetch_assoc($result))
            {
              $empid = $row['empid'];
              $name = $row['name'];
              echo "<option value = '$empid'>$empid - $name</option>";
            }
          ?>
        </select>
      </div>
      <div>
      <label for="attendence">Attendence:</label>
        <select id="attendence" name="attendence" class="form-control">
          <option disabled selected value> -- select an option -- </option>;
          <option value = 'PRESENT'>PRESENT</option>
          <option value = 'ABSENT'>ABSENT</option>
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