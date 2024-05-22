<!-- this is lecture 59 in action -->
<?php
    $showError="false";   //initializing the showerror with false only
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        include '_dbconnect.php';
        // create the table based on your needs..like you can have ph no, enail, date ob birth....
        $user_email=$_POST['signupEmail'];
        $pass=$_POST['signupPassword'];
        $cpass=$_POST['csignupPassword'];

        // check whether users exists inside database or not:-
        $existSql="SELECT * FROM `users` WHERE user_email='$user_email'";
        $result=mysqli_query($conn, $existSql);
        $numRows=mysqli_num_rows($result);   //isse number of rows a jati hain
        if($numRows>0){
            // agar present hain then say kaalti maro or bhaag jao
            $showError="Email Already Present";
        }
        else{
            if($pass == $cpass){
                $hash=password_hash($pass, PASSWORD_DEFAULT);
                // if it matches then store in the database created by the name of users
                $sql="INSERT INTO `users` (`user_email`, `user_pass`, `timestamp`) VALUES ( '$user_email', '$hash', current_timestamp())";
                $result=mysqli_query($conn, $sql);
                if ($result) {
                    $showAlert=true;
                    // redirecting the user to the original page
                    header("Location: /forum project/index.php?signupsuccess=true");
                    exit();
                }    
            }
            else{
                $showError="password doesent match";
            }
        }
        header("Location: /forum project/index.php?signupsuccess=false&error=$showError");
    }
?>