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
    // to udestand the next few lines, in phpmyadmin, go to categories->then SQL->then in top where its writen selct from `categories` where 1, remove 1 and in place of 1 write category_id=1, it will fetch python..now copy the sql code and paste here. And we get the catid if we do get request from the page only
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id=$id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }
    ?>

    <!-- connecting to database usinnf srver method lecture 56-->
    <?php
    $showalert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    // echo $method;
    // adding questions to database
    if ($method == 'POST') {
        // insert into database
        // note:-all thesse names i.e title, desc is taken from below portion where the form is present and inside it, the part where its written name="title" and name="desc", that part and remove the semicolon present at the end

        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];
        // to get the insertion sql, go to threads->in top, the insert tab->write something only and press go...you get the insertion code and remove thread_id and its equivalent number from values section
        $sql = "INSERT INTO `threads` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `stamp`) VALUES ( '$th_title', '$th_desc', '$id', '0', current_timestamp()) ";
        $result = mysqli_query($conn, $sql);
        $showalert = true;
        if ($showalert) {
            // copied from bootstrap the alerts section(dismissable)
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Success!!!!</strong> Your Threads have been added successfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        }
    }
    ?>

    <!-- this is taking from the jumbotron bootstrap code template -->
    <!-- the catname and catdec is fetched from above php code and the masala has been coded there itself -->
    <div class="jumbotron">
        <h1 class="display-4">welcome to <?php echo $catname; ?> forums</h1>
        <p class="lead"><?php echo $catdesc; ?></p>
        <hr class="my-4">
        <p>No Spam / Advertising / Self-promote in the forums.
            DO NOT ASK for email addresses or phone numbers.
            Do not post copyright-infringing material.
            Do not post “offensive” posts, links or images.
            Do not cross post questions.
            Do not PM users asking for help.
            Remain respectful of other members at all times.</p>
        <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
    </div>

    <!-- the next dev section od code is taken from bootstrap's media object section -->
    <div class="container" id="ques">
        <h1 class="py-3">Browse questions</h1>
        <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
        $result = mysqli_query($conn, $sql);
        $noResult = true; //this means that if no question is posted in the thread list, then it must pop up that you are the first one to post here hence we have initialized it as true value
        
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            // the next lines of code is from the lecture 59
            $thread_time=$row['stamp'];
            
            // this is lecture 63 code from here upto line 107 
            $thread_user_id=$row['thread_user_id'];
            $sql2="SELECT user_email FROM `users` WHERE sno='$thread_user_id' ";
            $result2= mysqli_query($conn, $sql2);
            $row2= mysqli_fetch_assoc($result2);
            // $name=$row2['user_email'];

            echo '<div class="media my-3">
                            <img class="mr-3" src="img/5034901-200.png" width="34px" alt="Generic placeholder image">
                            <div class="media-body">
                            <p class="font-weight-bold my-0"> commented at :---' . $thread_time . '</p><h5 class="mt-0"><a href="thread.php?thread_id=' . $id . '">' . $title . '</a></h5>
                                    ' . $desc . '
                            </div>
                     </div>';
        }

        if ($noResult) {
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <h1 class="display-4">NO QUESTIONS TILL NOW😕</h1>
              <p class="lead">BE THE FIRST PERSON TO POST IN THIS QUESTION BANK AT THE COMFORT OF YOUR SPACE</p>
            </div>
          </div>';
        }
        ?>

        <?php  

        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
        echo '<div class="container">
            <h1 class="my-5">START A DISCUSSION</h1>
            <!-- you have to write this $_SERVER code as it is and this is from lecture 56-->
            <form action=" '. $_SERVER["REQUEST_URI"] . '" method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">Entr The Thread To Ask</label>
                    <input type="text" class="form-control" id="title" name="title" aria-describedby="title" placeholder="Enter title">
                    <small id="emailHelp" class="form-text text-muted">Keep your problem as crisp as possible</small>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Ellaborate your statement please</label>
                    <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>';
        }
        else{
            echo '
            <h1 class="my-5">START A DISCUSSION</h1>
            <div class="container">
                <p class="lead">You are not <b>Logged In</b>. Please Log In to be able to start a Discussion</p>
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