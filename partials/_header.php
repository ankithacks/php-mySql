<?php

session_start();

include 'partials/_loginmodal.php';
include 'partials/_signupmodal.php';

echo '
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">Medic Verse</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contacts.php">Contact</a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Top Categories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">';

          $sql= " SELECT category_id, category_name FROM `categories` LIMIT 5 ";
          $result= mysqli_query($conn, $sql);

          while ($row = mysqli_fetch_assoc($result)){          
              
             echo ' <a class="dropdown-item" href="threadslist.php?catid='. $row['category_id'] .'">'. $row['category_name'] .'</a>';
          }

          echo '</div>
      </li>
    </ul>
  </div>
  <div class="row mx-2">';
  
  if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo '<form class="form-inline my-2 my-lg-0" method="get" action="search.php" >
    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      <p class="text-dark my-0 mx-3">Welcome '. $_SESSION['useremail'] .'</p>
      <a href="partials/_logout.php" type="button" class="btn btn-outline-success ml-2" >
    logout now!
  </a></form>';
  }

  else{
    echo '<form class="form-inline my-2 my-lg-0">
    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#loginmodal">
      login
    </button>
    <button type="button" class="btn btn-primary mx-2" data-toggle="modal" data-target="#signupmodal">
      Signup
    </button>';
  }
    
  echo '</div>
    </div>
    </nav>';
  
  

// wrting this next lines of script from lecture 59
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success!!!</strong> You can now login to your account .
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
}
?>