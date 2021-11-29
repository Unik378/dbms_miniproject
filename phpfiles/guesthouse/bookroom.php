<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
// echo $_SERVER["REQUEST_METHOD"];
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
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

echo '<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<link rel="stylesheet" href="style.css">
<title>Guest House</title>
</head>
';
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["roomtypeid"]))
{
  require('db.php');
  $roomtypeid = mysqli_real_escape_string($db,$_POST["roomtypeid"]);
  $numguests = mysqli_real_escape_string($db,$_POST["guests"]);
  $foodservices = mysqli_real_escape_string($db,$_POST["foodservices"]);

  if($foodservices == "on")
    $foodservices = 1;
  else
    $foodservices = 0;
  
  $checkin = $_SESSION["checkin"];
  $checkout = $_SESSION["checkout"];

  if(empty($roomtypeid) || empty($numguests))
  {
    echo 'Empty feilds!<br>';
    echo '<a href = "welcome.php">Go back to welcome page</a>';
  }
  else
  {
    $query = "SELECT capacity FROM ROOM_TYPE WHERE roomTypeID = '$roomtypeid'";
    $result = mysqli_query($db,$query) or die(mysqli_error($db));
    $row = mysqli_fetch_assoc($result);
    $capacity = $row["capacity"];

    if($capacity < $numguests || $numguests <= 0)
    {
        echo 'Number of guest greater than capacity of room!<br>';
        echo '<a href = "welcome.php">Go back to welcome page</a>';
    }
    else
    {
        $_SESSION["roomtypeid"] = $roomtypeid;
        $_SESSION["numguests"] = $numguests;
        $_SESSION["foodservices"] = $foodservices;

        $diff=date_diff(date_create($checkin),date_create($checkout));
        $amount = 0;
        $cost = 0;
        if($roomtypeid == 'A')
        {
            $cost = 500;
        }
        else if($roomtypeid == 'B')
        {
            $cost = 1000;
        }
        else
        {
            $cost = 1200;
        }
        
        $amount += $diff->format("%a")*($cost+ $foodservices*300*$numguests);

        echo "<br><h4 style='text-align:center; color:red;'>Amount to be paid for this booking : Rs. $amount </h4><br><br>";

        echo '<form action="bookroom.php" method = "POST">';
        $i = 1;
        while($i <= $numguests)
        {
            echo '  <h3>For Guest '.$i.'</h3>  
                    <div>
                        <div>
                            <label for="aadhaar'.$i.'" class="form-label">Aadhaar Card No:</label>
                            <input type="text" class="form-control" name="aadhaar'.$i.'" id="aadhaar'.$i.'">
                        </div>
                        <div>
                            <label for="name'.$i.'" class="form-label">Name:</label>
                            <input type="text" class="form-control" name="name'.$i.'" id="name'.$i.'">
                        </div>
                        <div>
                            <label for="age'.$i.'" class="form-label">Age:</label>
                            <input type="number" class="form-control" name="age'.$i.'" id="age'.$i.'">
                        </div>
                        <div>
                            <label for="gender'.$i.'" class="form-label">Gender:</label>
                            <select name="gender'.$i.'" id="gender'.$i.'" class="form-control">
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                            <option value="O">Other</option>
                            </select>
                        </div>
                    </div><br>';
            $i += 1;
        }
        echo '<button type="submit" class="btn btn-primary w-100 mt-3">Submit</button>
              </form>';
    }
  }
}
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
    require('db.php');
    $roomtypeid = $_SESSION["roomtypeid"];
    $numguests = $_SESSION["numguests"];

    $foodservices = $_SESSION["foodservices"];
    
    $checkin = $_SESSION["checkin"];
    $checkout = $_SESSION["checkout"];
    $bookedby = $_SESSION["username"];

    $query = "SELECT MAX(bookingId) as bookingid FROM booking";
    $result = mysqli_query($db,$query) or die(mysqli_error($db));
    $row = mysqli_fetch_assoc($result);

    $bookingid = $row["bookingid"]+1;

    $query = "INSERT INTO booking (bookingId,arrival,departure,foodservices,bookedBy) VALUES ($bookingid,'$checkin','$checkout',$foodservices,'$bookedby')";
    mysqli_query($db,$query) or die(mysqli_error($db));

    $i = 1;
    while($i <= $numguests)
    {
        $customerid = $_POST["aadhaar".$i];
        $customername = $_POST["name".$i];
        $customerage = $_POST["age".$i];
        $customergender = $_POST["gender".$i];

        $query = "SELECT * FROM customer where customerID = '$customerid'";
        $result = mysqli_query($db,$query) or die(mysqli_error($db));
        $numrows = mysqli_num_rows($result);

        if($numrows == 0)
        {
            $query = "INSERT INTO customer VALUES ('$customerid','$customername','$customergender',$customerage)";
            mysqli_query($db,$query) or die(mysqli_error($db));
        }

        $query = "INSERT INTO hasBooked VALUES ($bookingid,'$customerid')";
        mysqli_query($db,$query);

        $i += 1;
    }

    $email = $_SESSION['username'];
    $query = "SELECT designation FROM login WHERE emailID = '$email'";
    $des = mysqli_query($db,$query) or die(mysqli_error($db));
    $des = mysqli_fetch_assoc($des);
    $des = $des['designation'];

    $query = "SELECT roomid from ROOM_TYPE NATURAL JOIN ROOM WHERE roomtypeid = '$roomtypeid' AND roomid IN (SELECT roomid from ROOM WHERE roomid NOT IN (SELECT roomid from isBooked NATURAL JOIN booking WHERE '$checkin' < departure AND arrival < '$checkout')) LIMIT 1;";
    $result = mysqli_query($db,$query);
    $row = mysqli_fetch_assoc($result);
    $roomid = $row["roomid"];

    $query = "INSERT INTO isBooked VALUES ($bookingid,'$roomid')";
    mysqli_query($db,$query) or die(mysqli_error($db));

    $diff=date_diff(date_create($checkin),date_create($checkout));
    $amount = 0;
    $cost = 0;
    if($roomtypeid == 'A')
    {
        $cost = 500;
    }
    else if($roomtypeid == 'B')
    {
        $cost = 1000;
    }
    else
    {
        $cost = 1200;
    }
    
    $amount += $diff->format("%a")*($cost+ $foodservices*300*$numguests);
    $query = "INSERT INTO payment (bookingId,amount) VALUES ($bookingid,$amount)";
    mysqli_query($db,$query) or die(mysqli_error($db));

    if($des == 'IITP')
    {
        $query = "UPDATE payment SET payment.status = 'BY IITP' WHERE bookingid = $bookingid";
        mysqli_query($db,$query) or die(mysqli_error($db));
        $query = "UPDATE payment SET paymentDate = curdate() WHERE bookingid = $bookingid";
        mysqli_query($db,$query) or die(mysqli_error($db));
    }

    echo "Booked succesfully<br>";
    echo '<a href = "welcome.php">Go back to welcome page</a>';
}
else
{
    header("location: welcome.php");
}
?>