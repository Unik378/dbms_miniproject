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
    if($_SESSION['username'] == 'ghreception@iitp.ac.in')
    {
        header("location: ./reception/ghwelcome.php");
        exit;
    }
}

$emptyerror = false;
$invaliderror = false;
$lateerror = false;

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
        $bookedby = $_SESSION['username'];
        $query = "SELECT * FROM booking WHERE bookingId = $bookingid AND bookedBy = '$bookedby'";

        $bookingdetails = mysqli_query($db,$query);

        $numrows = mysqli_num_rows($bookingdetails);

        if($numrows == 0)
        {
        $invaliderror = true;
        }
        else
        {
            $row = mysqli_fetch_assoc($bookingdetails);
            $today = date('Y-m-d');
            $diff=date_diff(date_create($today),date_create($row['arrival']));
        
            if($diff->format('%R%a') < 7)
            {
                $lateerror = true;
            }
            else
            {
                $query = "DELETE FROM hasBooked WHERE bookingId = $bookingid";
                mysqli_query($db,$query);

                $query = "DELETE FROM isBooked WHERE bookingId = $bookingid";
                mysqli_query($db,$query);
                
                $query = "DELETE FROM payment WHERE bookingId = $bookingid";
                mysqli_query($db,$query);

                $query = "DELETE FROM booking WHERE bookingId = $bookingid";
                mysqli_query($db,$query);
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

  <link rel="stylesheet" href="style.css">
  <title>Guest House</title>
</head>

<body>
<?php require('nav.php') ?>

    <div>
        <br>
  <h3 style="text-align: center;">Your current bookings:</h3>
    <?php
        $query = "SELECT * FROM booking NATURAL JOIN isBooked NATURAL JOIN room NATURAL JOIN payment WHERE bookedBy = '{$_SESSION["username"]}' AND departure > curdate()";
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
  <h2 style="text-align: center;">Cancel Booking : </h2>

<!-- form for booking details -->
  <form action="cancelBooking.php" method="POST">
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
      if ($lateerror) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  Bookings can only be cancelled before 7 days of Check IN date!!!
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
      <button type="submit" class="btn btn-primary">Cancel Booking</button>
    </div>
  </form>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>