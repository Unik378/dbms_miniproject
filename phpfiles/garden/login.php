<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

// check if the user is already logged in
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
{
    if($_SESSION['username'] == 'admin')
    {
        header("location: ./msadmin/adminwel.php");
        exit;
    }
    else
    {
        header("location: welcome.php");
        exit;
    }
}

$emptyerror = false;
$invaliderror = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require("db.php");

    $mobile = mysqli_real_escape_string($db,$_POST["mobile"]);
    $password = mysqli_real_escape_string($db,$_POST["password"]);

    if (empty($mobile) || empty($password)) {
        $emptyerror = true;
    }
    else
    {
        $query = "SELECT * from gardener WHERE mobile = '$mobile'";
        $result = mysqli_query($db, $query) or die(mysqli_error($db));
    
        $row = mysqli_fetch_assoc($result);
    
        if (isset($row) && $password == $row["password"]) {
                $_SESSION['username'] = $mobile;
                $_SESSION['loggedin'] = true;

                if($mobile == 'admin')
                {
                    header("location: ./msadmin/adminwel.php");
                    exit;
                }
                else
                {
                    header("location: welcome.php");
                    exit;
                }
        } else {
            $invaliderror = true;
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

    <title>Login</title>
</head>
<body>
    <div class="col-md-4 container">
        <h1 style="text-align: center;">Login</h1>
        <?php
        if($invaliderror)
        {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Invalid Username or Password!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
        if($emptyerror)
        {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Enter all feilds!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
        ?>
        <form action="login.php" method="post">
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile:</label>
                <input type="mobile" class="form-control" id="mobile" name="mobile">
            </div>
            <div>
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-3">Submit</button>
        </form>
        <a href="register.php" class="d-block text-center mt-2">Regiter here?</a>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>