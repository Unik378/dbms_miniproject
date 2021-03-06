<?php
$emptyerror = false;
$sucess = false;
$alreadyExist = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require("db.php");
    $tablename = 'gardener';
    $mobile = mysqli_real_escape_string($db, $_POST["mobile"]);
    $name = mysqli_real_escape_string($db, $_POST["name"]);
    $password = mysqli_real_escape_string($db, $_POST["password"]);

    if (empty($name) || empty($mobile) || empty($password))
    {
        $emptyerror = true;
    } 
    else 
    {
        $query = "SELECT * from gardener WHERE mobile = '$mobile'";
        $result = mysqli_query($db, $query) or die(mysqli_error($db));
        $num_rows = mysqli_num_rows($result);

        if ($num_rows > 0) {
            $alreadyExist = true;
        } else {
            $query = "SELECT max(empid) as id FROM gardener";
            $result = mysqli_query($db, $query) or die(mysqli_error($db));
            $id = mysqli_fetch_assoc($result);
            $id = $id['id'];
            $id = $id + 1;

            $query = "INSERT INTO $tablename (empid, name, mobile, password) VALUES ($id,'$name','$mobile','$password')";
            mysqli_query($db, $query) or die(mysqli_error($db));

            $sucess = true;
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

    <title>Register</title>
</head>

<body>
    <div class="col-md-4 container">
        <h1 style="text-align: center;">Register</h1>
        <?php
        if ($sucess) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Registeration successful
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
        if ($emptyerror) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Enter all feilds!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
        if ($alreadyExist) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    mobile already registered. Try another!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
        ?>
        <form action="register.php" method="post">
            <div>
                <label for="mobile" class="form-label">Mobile:</label>
                <input type="tel" class="form-control" name="mobile" id="mobile">
            </div>
            <div>
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" name="name" id="name">
            </div>
            <div>
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-3">Submit</button>
        </form>
        <a href="login.php" class="d-block text-center mt-2">Login here?</a>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>