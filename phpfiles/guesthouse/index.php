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
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Guest House</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
      </ul>
    </div>
  </nav>

  <h1 style="text-align: center;">Welcome to IITP Guest house</h1>

  <div class="about">
  <div>
      <h3>About Guest House</h3>
      The Guest House in IITP has excellent hospitality services. Only IITP members are allowed to book rooms here. It has various types of rooms which you can book according to your requirements. Food Services are also provided here. We make every possible effort to make your stay here merry.
  </div>
  <br><br>
  <div>
      <h3>About IITP Campus</h3>
      IIT Patna is a college of National importance. It is one of the best engineering college, India has got to present. Remarkable and Competent Staff teaches the most refined students that come accross here from all over the nation.
  </div>
  </div>
<br><br>
  <h2>Types of rooms</h2>
  <?php require('cards.php'); ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>