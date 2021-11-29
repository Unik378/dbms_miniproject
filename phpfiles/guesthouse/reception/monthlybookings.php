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

function findenddate($month, &$end) {
  $month = explode('-',$month);
  if($month[1] == '01' || $month[1] == '03' || $month[1] == '05' || $month[1] == '07' || $month[1] == '08' || $month[1] == '10' || $month[1] == '12')
  {
    $end = 31;
  }
  else if($month[1] == '02')
  {
    $end = 28;
  }
  else
  {
    $end = 30;
  }
}

$emptyerror = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["month"]))
{
  if(empty($_POST['month']))
  {
    $emptyerror = true;
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
  <h2 style="text-align: center;">Monthly bookings : </h2>

  <form action="monthlybookings.php" method="POST">
    <?php
    if ($emptyerror) {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Enter all feilds!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    ?>
    <div class="col">
      <label for="month">Month and Year</label>
      <input type="month" class="form-control" name="month" id="month" min="2008-06" value="<?php if(isset($_POST['month']) && !empty($_POST['month'])){echo $_POST["month"];}else{echo date('Y-m');}?>">
    </div>
    <br>
    <div class="subbutton">
      <button type="submit" class="btn btn-primary">Proceed</button>
    </div>
  </form>
  <br><br>
  
  <?php
      if(!$emptyerror && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["month"]))
      {
        $end = 0;
        $month = $_POST['month'];
        findenddate($month,$end);
        $month = $_POST['month'];
    
        $start = $month.'-01';
        $end = $month."-".$end;
    
        $query = "SELECT * FROM booking NATURAL JOIN isBooked NATURAL JOIN room NATURAL JOIN payment WHERE bookingdate <= '$end' AND bookingdate >= '$start'";
        $bookings = mysqli_query($db,$query);

        echo '<table class="table">
                <thead>
                  <tr>
                    <th scope="col">Booking ID</th>
                    <th scope="col">Room No</th>
                    <th scope="col">Room Type</th>
                    <th scope="col">Booking Date</th>
                    <th scope="col">Payment Status</th>
                    <th scope="col">Payment Date</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Booked By</th>
                  </tr>
                </thead>
                <tbody>';
    
        while($row = mysqli_fetch_assoc($bookings))
        {
            echo '<tr>';
            echo '<td>'.$row['bookingId'].'</td>';
            echo '<td>'.$row['roomID'].'</td>';
            echo '<td>'.$row['roomtypeid'].'</td>';
            echo '<td>'.$row['bookingDate'].'</td>';
            echo '<td>'.$row['status'].'</td>';
            echo '<td>'.$row['paymentDate'].'</td>';
            echo '<td>'.$row['amount'].'</td>';
            echo '<td>'.$row['bookedBy'].'</td>';
            echo '</tr>';
        }
        echo '</tbody>
        </table>';
      }
  ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>