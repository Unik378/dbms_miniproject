<style>
  h3{
    text-align: center;
    color: blue;
  }
  h2{
    text-align: center;
    color: blue;
  }
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Guest House</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="ghwelcome.php">Home</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="bookingDetail.php">Booking Details</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="checkavailibility.php">Check Availability</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="monthlyexpenditure.php">Monthly Expenditure</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="foodbilllings.php">Food Billings</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="monthlybookings.php">Monthly Bookings</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./../logout.php">Logout</a>
        </li>
      </ul>

      <div class="navbar-collapse collapse">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#"> <img src="https://img.icons8.com/metro/26/000000/guest-male.png"> <?php echo "Welcome " . $_SESSION['username'] ?></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>