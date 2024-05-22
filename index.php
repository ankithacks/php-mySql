<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <title>your forum</title>
</head>

<body>

  <?php include 'partials/_dbconnect.php'; ?> <!-- this line means that the code is now getting connected to the database -->
  <!-- <?php include 'partials/_header.php'; 
   ?>
  <h2 class="text-center">WELCOME EVERYONE</h2> -->

  <!-- slider starts here for the cariusel and all -->
  <!-- <div id="carouselExampleControls" class="carousel slide my-3" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="d-block w-100" src="https://source.unsplash.com/2400x700?code,python" alt="First slide">
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="https://source.unsplash.com/2400x700?code,python" alt="Second slide">
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="https://source.unsplash.com/2400x700?code,python alt=" Third slide">
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
 -->

  <!-- category container starts here -->

  <div class="container">
    <h3 class="text-center my-5">Your Categories</h3>
    <div class="row my-3">

      <!-- fetch all the categories and also use a for loop to render the categories as added in the database -->
      <!-- copied the sql code from the database from the top -->
      <?php
      $sql = "SELECT * FROM `categories`";
      $result = mysqli_query($conn, $sql);

      //after this you have to write this code to that is mysqli_fetch_assoc($result)
      while ($row = mysqli_fetch_assoc($result)) {
        // copied this section from bootsrap cards section and used an api of unsplash
        $cat = $row['category_name'];
        $desc = $row['category_description'];
        $id = $row['category_id'];
        // copied the below code from card section of bootstrap
        echo '
        <div class="col md-4 my-3">
        <div class="card" style="width: 18rem;">
          <img class="card-img-top" src="https://source.unsplash.com/500x400?' . $cat . ',air quality" alt="Card image cap">
          <div class="card-body">
              <h5 class="card-title"><a href="threadslist.php?catid='  . $id .  '">' . $cat . '</a></h5>
              <p class="card-text">'  . $desc . '</p>
              <a href="threadslist.php?catid='  . $id .  '" class="btn btn-primary">View Threads</a>
            </div>
          </div>
        </div>
      ';
      }
      
    //   echo ' <div class="card" style="width: 18rem;">
    //   <img class="card-img-top" src="..." alt="Card image cap">
    //   <div class="card-body">
    //     <h5 class="card-title">ADD MORE</h5>
    //     <p class="card-text">More of the languages are being added</p>
    //   </div>
    // </div>';
      ?>

    </div>
  </div>
  <?php include 'partials/_footer.php'; ?>



  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>

<!-- the unsplash api resolution when you put online qwill be 500x400  and for the top it will be 2400x700-->