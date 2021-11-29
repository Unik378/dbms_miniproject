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
  <h2 style="text-align: center;">Monthly Expenditure : </h2>

  <form action="monthlyexpenditure.php" method="POST">
    <?php
    if ($emptyerror) {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Enter all feilds!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    ?>
    <div class="col">
      <label for="month">Month</label>
      <input type="month" class="form-control" name="month" id="month" min="2008-06" value="<?php if(isset($_POST['month']) && !empty($_POST['month'])){echo $_POST["month"];}else{echo date('Y-m');}?>">
    </div>
    <br>
    <div class="subbutton">
      <button type="submit" class="btn btn-primary">Proceed</button>
    </div>
  </form>
  
  <?php
      if(!$emptyerror && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["month"]))
      {
        $end = 0;
        $month = $_POST['month'];
        findenddate($month,$end);
        $month = $_POST['month'];
    
        $start = $month.'-01';
        $end = $month."-".$end;
    
        $query = "SELECT bookingID,foodServices FROM booking WHERE arrival <= '$end' AND departure > '$start'";
        $bookingids = mysqli_query($db,$query);
    
        echo '<table class="table">
                <thead>
                  <tr>
                    <th scope="col">Booking ID</th>
                    <th scope="col">Room No</th>
                    <th scope="col">Stay in Given Month</th>
                    <th scope="col">Number of guests</th>
                    <th scope="col">Food Expenses</th>
                    <th scope="col">Other Expenses</th>
                    <th scope="col">Per Booking Total</th>
                  </tr>
                </thead>
                <tbody>';
    
        $expense = 0;
        while($row = mysqli_fetch_assoc($bookingids))
        {
          echo '<tr>';
          $id = $row['bookingID'];
          $foodservices = $row['foodServices'];

          echo '<td>'.$id.'</td>';
    
          $query = "SELECT * FROM room NATURAL JOIN isBooked NATURAL JOIN ROOM_TYPE WHERE bookingid = '$id'";
          $res = mysqli_query($db,$query);
          $res = mysqli_fetch_assoc($res);

          $room = $res['roomid'];
          $cost = $res['cost'];
      
          echo '<td>'.$room.'</td>';
    
          $query = "SELECT count(*) as cnt FROM hasBooked WHERE bookingID = '$id'";
          $numguest = mysqli_query($db,$query);
          $numguest = mysqli_fetch_assoc($numguest);
          $numguest = $numguest['cnt'];
    
          $numdays = 0;
    
          $query = "SELECT arrival,departure FROM booking WHERE bookingid = '$id'";
          $arr_dep = mysqli_query($db,$query);
          $arr_dep = mysqli_fetch_assoc($arr_dep);
    
          $arrival = $arr_dep['arrival'];
          $departure = $arr_dep['departure'];
    
          if($arrival >= $start && $departure < $end)
          {
              $diff=date_diff(date_create($arrival),date_create($departure));
              $numdays = $diff->format('%a');
          }
          else if($arrival < $start && $departure > $end)
          {
              $diff=date_diff(date_create($start),date_create($end));
              $numdays = $diff->format('%a');
          }
          else if($arrival < $start && $departure < $end)
          {
              $diff=date_diff(date_create($start),date_create($departure));
              $numdays = $diff->format('%a');
          }
          else
          {
              $diff=date_diff(date_create($arrival),date_create($end));
              $numdays = $diff->format('%a');
          }
          
          echo '<td>'.$numdays.' days</td>';
          echo '<td>'.$numguest.'</td>';
    
          $foodbill = $foodservices * $numguest * $numdays * 300 * 0.7;
          $cost = $cost*0.7;
          echo '<td>Rs. '.$foodbill.'</td>';
          echo '<td>Rs. '.$cost.'</td>';
          echo '<td>Rs. '.$foodbill+$cost.'</td>';
          echo '</tr>';
          $expense = $expense + $foodbill + $cost;
        }
        echo '<tr><td></td><td></td><td></td><td></td><td></td><td style="text-align:right;">Total : </td><td>Rs. '.$expense.'</td></tr>';
        echo '</tbody>
        </table>';
      }
  ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>