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
  <h1 style="text-align: center;">Welcome to IITP Guest house</h1>

  <?php require('cards.php'); ?>
  <br>
  <br>

<div>
  <h3>Important Points:</h3>
  <ul>
    <li>Any booking can be cancelled only before 7 days of Check IN Date.</li>
    <li>Any change in any credential of a booking can be taken care of at the reception while checking in.</li>
    <li>Once the payment is done, it is not refundable.</li>
    <li>Verify all the details properly.</li>
  </ul>
</div>
<br>
<div>
  <h3>Your Previous Bookings:</h3>
  <?php
    $query = "SELECT * FROM booking NATURAL JOIN isBooked NATURAL JOIN room NATURAL JOIN payment WHERE bookedBy = '{$_SESSION["username"]}' AND departure < curdate()";
    $yourbookings = mysqli_query($db,$query) or die(mysqli_error($db));

    echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Booking ID</th>
                <th scope="col">Booking Date</th>
                <th scope="col">Check IN</th>
                <th scope="col">Check OUT</th>
                <th scope="col">Food Services</th>
                <th scope="col">Room No</th>
                <th scope="col">Room Type</th>
                <th scope="col">Amount</th>
                <th scope="col">Payment Status</th>
              </tr>
            </thead>
            <tbody>';

      while($row = mysqli_fetch_assoc($yourbookings))
      {
        echo '<tr>';
        echo '<td>'.$row['bookingId'].'</td>';
        echo '<td>'.$row['bookingDate'].'</td>';
        echo '<td>'.$row['arrival'].'</td>';
        echo '<td>'.$row['departure'].'</td>';
        echo '<td>'.$row['foodServices'].'</td>';
        echo '<td>'.$row['roomID'].'</td>';
        echo '<td>'.$row['roomtypeid'].'</td>';
        echo '<td>'.$row['amount'].'</td>';
        echo '<td>'.$row['status'].'</td>';
        echo '</tr>';
      }
      echo '</tbody>
      </table>';
  ?>
</div>
<br>
<div>
  <h3>Your Current Bookings:</h3>
  <?php
    $query = "SELECT * FROM booking NATURAL JOIN isBooked NATURAL JOIN room NATURAL JOIN payment WHERE bookedBy = '{$_SESSION["username"]}' AND departure >= curdate()";
    $yourbookings = mysqli_query($db,$query) or die(mysqli_error($db));

    echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Booking ID</th>
                <th scope="col">Booking Date</th>
                <th scope="col">Check IN</th>
                <th scope="col">Check OUT</th>
                <th scope="col">Food Services</th>
                <th scope="col">Room No</th>
                <th scope="col">Room Type</th>
                <th scope="col">Amount</th>
                <th scope="col">Payment Status</th>
              </tr>
            </thead>
            <tbody>';

      while($row = mysqli_fetch_assoc($yourbookings))
      {
        echo '<tr>';
        echo '<td>'.$row['bookingId'].'</td>';
        echo '<td>'.$row['bookingDate'].'</td>';
        echo '<td>'.$row['arrival'].'</td>';
        echo '<td>'.$row['departure'].'</td>';
        echo '<td>'.$row['foodServices'].'</td>';
        echo '<td>'.$row['roomID'].'</td>';
        echo '<td>'.$row['roomtypeid'].'</td>';
        echo '<td>'.$row['amount'].'</td>';
        echo '<td>'.$row['status'].'</td>';
        echo '</tr>';
      }
      echo '</tbody>
      </table>';
  ?>
</div>
<br><br>
<div>
  <h3>Guests Details Corresponding to Current Bookings:</h3>
  <?php
      $username = $_SESSION['username'];
      $query = "SELECT bookingId, customer.* FROM hasBooked NATURAL JOIN customer NATURAL JOIN booking WHERE bookedby = '$username' AND departure > curdate()";

      $customerdetails = mysqli_query($db,$query);

      echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Booking ID</th>
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
  ?>
</div>
  <br>
  <br>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>