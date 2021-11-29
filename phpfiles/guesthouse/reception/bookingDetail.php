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
    if($_SESSION['username'] != 'ghreception@iitp.ac.in')
    {
        header("location: ./../welcome.php");
        exit;
    }
}

$emptyerror = false;
$invaliderror = false;

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["bookingid"]))
{
  $bookingid = $_POST["bookingid"];
  if(empty($bookingid))
  {
    $emptyerror = true;
  }
  else
  {
    // booking details
    $query = "SELECT * FROM booking WHERE bookingId = $bookingid";
    $bookingdetails = mysqli_query($db,$query);

    $numrows = mysqli_num_rows($bookingdetails);
    if($numrows == 0)
    {
      $invaliderror = true;
    }
    else
    {
      $_SESSION['bookingid'] = $bookingid;
      $query = "SELECT * FROM payment WHERE bookingid = $bookingid";
      $paymentdetails = mysqli_query($db,$query);

      $query = "SELECT customer.* FROM hasBooked NATURAL JOIN customer WHERE bookingid = $bookingid";
      $customerdetails = mysqli_query($db,$query);

      $query = "SELECT room.* FROM isBooked NATURAL JOIN room WHERE bookingid = $bookingid";
      $roomdetails = mysqli_query($db,$query);
    }
  }
}
else if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["paymentdone"]))
{
  $bookingid = $_SESSION['bookingid'];
  $query = "UPDATE payment SET payment.status = 'DONE' WHERE bookingid = $bookingid";
  mysqli_query($db,$query);
  $query = "UPDATE payment SET paymentDate = curdate() WHERE bookingid = $bookingid";
  mysqli_query($db,$query);
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
  <title>Guest House</title>
</head>

<body>
  <?php require('./nav.php'); ?>
  <br>
  <h2 style="text-align: center;">Booking Details : </h2>

<!-- form for booking details -->
  <form action="bookingDetail.php" method="POST">
    <?php
      if ($emptyerror) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  Enter all feilds!
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
      }
      if ($invaliderror) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  Invalid Booking ID!
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
      }
      ?>
      <div>
        <label for="bookingid">Booking ID</label>
        <input type="number" class="form-control" name="bookingid" id="bookingid">
      </div>
      <br>
      <div class="subbutton">
      <button type="submit" class="btn btn-primary">Check Booking Details</button>
    </div>
  </form>

  <?php
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["bookingid"]) && !$emptyerror && !$invaliderror)
    {
      echo "<h2>Booking Details:</h2>";
      echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">bookingId</th>
                <th scope="col">bookingDate</th>
                <th scope="col">arrival</th>
                <th scope="col">departure</th>
                <th scope="col">foodServices</th>
                <th scope="col">bookedBy</th>
              </tr>
            </thead>
            <tbody>';

      while($row = mysqli_fetch_assoc($bookingdetails))
      {
        echo '<tr>';
        foreach($row as $f => $v)
        {
          echo "<td>".$v."</td>";
        }
        echo "</tr>";
      }
      echo '</tbody>
      </table>';

      echo "<h2>Customer Details:</h2>";
      echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Aadhaar No</th>
                <th scope="col">Name</th>
                <th scope="col">Gender</th>
                <th scope="col">Age</th>
              </tr>
            </thead>
            <tbody>';

      while($row = mysqli_fetch_assoc($customerdetails))
      {
        echo '<tr>';
        foreach($row as $f => $v)
        {
          echo "<td>".$v."</td>";
        }
        echo "</tr>";
      }
      echo '</tbody>
      </table>';

      echo "<h2>Room Details:</h2>";
      echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Room ID</th>
                <th scope="col">Room Type</th>
              </tr>
            </thead>
            <tbody>';

      while($row = mysqli_fetch_assoc($roomdetails))
      {
        echo '<tr>';
        foreach($row as $f => $v)
        {
          echo "<td>".$v."</td>";
        }
        echo "</tr>";
      }
      echo '</tbody>
      </table>';

      echo "<h2>Payment Details:</h2>";
      echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Booking Id</th>
                <th scope="col">PaymentDate</th>
                <th scope="col">amount</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>';

      while($row = mysqli_fetch_assoc($paymentdetails))
      {
        echo '<tr>';
        foreach($row as $f => $v)
        {
          echo "<td>".$v."</td>";
        }
        echo "</tr>";

        if($row["status"] == "PENDING")
        {
          echo '<form action="bookingDetail.php" method="POST">
                <input type="hidden" id="paymentdone" name="paymentdone" value="1">
                <button type="submit">Mark as Done</button>
              </form>';
        }
      }
      echo '</tbody>
      </table>';
    }
  ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>