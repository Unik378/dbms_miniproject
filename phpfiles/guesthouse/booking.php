<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


session_start();
require("db.php");

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: login.php");
}

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'])
{
    if($_SESSION['username'] == 'ghreception@iitp.ac.in')
    {
        header("location: ./reception/ghwelcome.php");
        exit;
    }
}

$displayform = false;
$notavailable = false;
$emptyerror = false;
$invaliderror = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["checkin"])) {

  $checkin = $_POST["checkin"];
  $checkout = $_POST["checkout"];

  $today = date('Y-m-d'); 
  
  if (empty($checkin) || empty($checkout)) {
    $emptyerror = true;
  } 
  else if ($checkin > $checkout || $checkin < $today) { //
    $invaliderror = true;
  } 
  else {
    // $q1 = "SELECT roomid from ROOM WHERE roomid NOT IN (SELECT roomid from isBooked NATURAL JOIN booking WHERE ('$checkin' < departure AND '$checkout' > arrival)";
    // $query = "SELECT * from ROOM_TYPE NATURAL JOIN ROOM WHERE roomid IN (".$q1.")";

    // $query = "SELECT roomid, roomtypeid from ROOM_TYPE NATURAL JOIN ROOM WHERE roomid IN (SELECT roomid from ROOM WHERE roomid NOT IN (SELECT roomid from isBooked NATURAL JOIN booking WHERE '$checkin' < departure AND arrival < '$checkout'));";
    $query = "SELECT roomtypeid, COUNT(roomtypeid) as cnt from ROOM_TYPE NATURAL JOIN ROOM WHERE roomid IN (SELECT roomid from ROOM WHERE roomid NOT IN (SELECT roomid from isBooked NATURAL JOIN booking WHERE '$checkin' < departure AND arrival < '$checkout')) GROUP BY roomtypeid";
    $availablerooms = mysqli_query($db, $query) or die(mysqli_error($db));

    $num_rows = mysqli_num_rows($availablerooms);
    if ($num_rows == 0) {
      $notavailable = true;
    } else {
      $displayform = true;
      $_SESSION["checkin"] = $checkin;
      $_SESSION["checkout"] = $checkout;
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
  <title>Guest House</title>
</head>

<body>
  <?php require('nav.php') ?>
<br>
  <form action="booking.php" method="POST">
    <?php
    if ($notavailable) {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                No room available in the provided inteval.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    if ($emptyerror) {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Enter all feilds!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    if ($invaliderror) {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Invalid inputs!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    ?>
    <div class="checkinout">
      <div class="col">
        <label for="checkin">Check IN</label>
        <input type="date" class="form-control" name="checkin" id="checkin" value="<?php if(isset($checkin) && !empty($checkin)){echo "$checkin";}?>">
      </div>
      <div class="col">
        <label for="checkin">Check Out</label>
        <input type="date" class="form-control" name="checkout" id="checkout" value="<?php if(isset($checkout) && !empty($checkout)){echo "$checkout";}?>">
      </div>
    </div>
    <br>
    <div class="subbutton">
      <button type="submit" class="btn btn-primary">Check Availability</button>
    </div>
  </form>

  <?php
  if($displayform)
  {
    echo '<br><br>
          <form action="bookroom.php" method="POST">
          <div>
            <label for="roomtypeid" class="form-label">Room Type:</label>
            <select id="roomtypeid" name="roomtypeid" class="form-control">
            <option disabled selected value> -- select an option -- </option>';
            while($row = mysqli_fetch_array($availablerooms)){
              echo "<option value='{$row["roomtypeid"]}'>{$row["roomtypeid"]} ({$row["cnt"]} rooms available)</option>";
              }
    echo ' 
            </select>
          </div>
          <br>
          <div>
          <label for="guests" class="form-label">Number of Guests:</label>
          <input type="guests" class="form-control" name="guests" id="guests">
          </div>
          <br>
          <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="foodservices" name="foodservices">
          <label class="form-check-label" for="foodservices">Food Services</label>
        </div>
        <div class="subbutton">
        <button type="submit" class="btn btn-primary">Book</button>
        </div>
        </form>';
  }
  ?>

  <br>
  <br>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>