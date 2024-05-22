<!-- this threads means that on clicking view thread, the greater description opens up 
-->

<!doctype html>
<html lang="en">

<head>
    <!--Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


    <style>
        #ques {
            min-height: 435px;
        }
    </style>


    <title>Thread List</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php';  ?>
    <?php
    $id = $_GET['thread_id'];
    $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
    }
    ?>

    <!-- this is taking from the jumbotron bootstrap code template -->
    <div class="jumbotron">
        <h1 class="display-4"><?php echo $title; ?> forums</h1>
        <p class="lead"><?php echo $desc; ?></p>
        <hr class="my-4">

        <p>Posted by: <b>Ankit</b></p>
    </div>


    <!-- connecting to database usinnf srver method lecture 58 though😁-->
    <?php
    $showalert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    // adding users comments to database
    if ($method == 'POST') {
        // insert into comments database
        // note:-all thesse names i.e comment is taken from below portion where the form is present and inside it, the part where its written name="comment" , that part and remove the semicolon present at the end of the sql query

        $comment = $_POST['comment'];
        // to get the insertion sql, go to threads->in top, the insert tab->write something only and press go...you get the insertion code and remove thread_id and its equivalent number from values section
        $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '0', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showalert = true;
        if ($showalert) {
            // copied from bootstrap the alerts section(dismissable)
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Success!!!!</strong> Your comment have been added successfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        }
    }
    ?>

    <?php

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo '    
        <div class="container">
        <h1>POST A COMMENT</h1>
        <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Type your Comment</label>
            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Post Comment</button>
        </form>
        </div>
        ';
    } 
    else 
    {
        echo '
            <h1 class="my-5">START A DISCUSSION</h1>
            <div class="container">
                <p class="lead">You are not <b>Logged In</b>. Please Log In to be able to post comments.</p>
            </div>';
    }
    ?>
    <!-- the next dev section od code is taken from bootstrap's media object section -->
    <div class="container" id="ques">
        <h1 class="py-3">Discussions</h1>
        <!-- this is lecture 57 where we create a database and store the coment of the user -->
        <?php
        $id = $_GET['thread_id'];
        $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
        $result = mysqli_query($conn, $sql);
        $noResult = true; //this means that if no question is posted in the thread list, then it must pop up that you are the first one to post here hence we have initialized it as true value
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row['comment_id'];
            $content = $row['comment_content'];
            $comment_time = $row['comment_time'];

            // this is lecture 63 upto line number 120
            $thread_user_id=$row['comment_by'];
            $sql2="SELECT user_email FROM `users` WHERE sno='$thread_user_id' ";
            $result2= mysqli_query($conn, $sql2);
            $row2= mysqli_fetch_assoc($result2);
            $name=$row2['user_email'];


            echo '<div class="media my-3">
                            <img class="mr-3" src="img/5034901-200.png" width="34px" alt="Generic placeholder image">
                            <div class="media-body">
                                <p class="font-weight-bold my-0">'. $name .' commented at' . $comment_time . '</p>
                                    ' . $content . '
                            </div>
                     </div>';
        }

        if ($noResult) {
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <h1 class="display-4">NO DISCUSSIONS TILL NOW😕</h1>
              <p class="lead">BE THE FIRST PERSON TO POST IN THIS QUESTION BANK AT THE COMFORT OF YOUR SPACE</p>
            </div>
          </div>';
        }
        ?>

    </div>

    <?php include 'partials/_footer.php'; ?>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>