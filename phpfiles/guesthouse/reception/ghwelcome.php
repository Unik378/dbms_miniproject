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

  <?php
      $query = "SELECT * FROM booking NATURAL JOIN payment WHERE departure >= curdate() OR status = 'PENDING'";
      $result = mysqli_query($db,$query) or die(mysqli_error($db));

      echo '<table class="table">
            <thead>
              <tr>
                <th scope="col">Booking ID</th>
                <th scope="col">Booking Date</th>
                <th scope="col">Check IN</th>
                <th scope="col">Check OUT</th>
                <th scope="col">Food Services</th>
                <th scope="col">BookedBy</th>
                <th scope="col">Payment Amount</th>
                <th scope="col">Payment Date</th>
                <th scope="col">Payment Stauts</th>
              </tr>
            </thead>
            <tbody>';

          while($row = mysqli_fetch_assoc($result))
          {
            echo '<tr>';
            echo '<td>'.$row['bookingId'].'</td>';
            echo '<td>'.$row['bookingDate'].'</td>';
            echo '<td>'.$row['arrival'].'</td>';
            echo '<td>'.$row['departure'].'</td>';
            echo '<td>'.$row['foodServices'].'</td>';
            echo '<td>'.$row['bookedBy'].'</td>';
            echo '<td>RS.'.$row['amount'].'</td>';
            echo '<td>'.$row['paymentDate'].'</td>';
            echo '<td>'.$row['status'].'</td>';
            echo '</tr>';
          }
      echo '</tbody>
      </table>';
  ?>
<?php require('./cards.php'); ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>