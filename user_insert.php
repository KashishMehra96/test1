<?php
session_start();
ob_start();
 ?>
<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
	<title>user insert</title>
    <link rel="icon" type="image/png" href="icon-1.png">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style (2).css">
     <style type="text/css">
    .c1
    {
        background: #fff;
        border-radius: 25px;
        height: 100%;
        padding: 25px;
        padding-left: 50px;
        margin-top: 50px;
        border-radius: 25px;
        -webkit-box-shadow: 0px 10px 40px -10px rgba(0,0,0,0.7);
        -moz-box-shadow: 0px 10px 40px -10px rgba(0,0,0,0.7);
        box-shadow: 0px 10px 40px -10px rgba(0,0,0,0.7);
    }
    .c2
    {
        background-image: linear-gradient(45deg,#f046ff,#9b00e8);
        border-radius: 25px;
        padding: 25px;
        color: #fff;
        margin-bottom: 30px;
    }
    .c3 
    {
        color: blueviolet;
        margin-bottom: 10px;
    }
    .c4
    {
        background: linear-gradient(45deg,#bb36fd,#9b00eb);
        color: #fff;
        max-width: 230px;
        border: none;
        border-radius: 25px;
        padding: 10px;
        -webkit-box-shadow: 0px 10px 41px -11px rgba(0,0,0,0.7);
        -moz-box-shadow: 0px 10px 41px -11px rgba(0,0,0,0.7);
        box-shadow: 0px 10px 41px -11px rgba(0,0,0,0.7);

    }
    .c4:hover
    {
        background: linear-gradient(45deg,#c85bff,#b726ff);
        color: #fff;
    }
    .c4:focus
    {
        outline: none;
    }
    .form-control
    {
        max-width: 650px;
        border-radius: 25px;
        padding: 10px;
        padding-left: 50px;
        border: none;
        -webkit-box-shadow: 0px 10px 30px -12px rgba(0,0,0,0.7);
        -moz-box-shadow: 0px 10px 30px -12px rgba(0,0,0,0.7);
        box-shadow: 0px 10px 30px -12px rgba(0,0,0,0.7);
        outline: none;
    }
    
    </style>
</head>
<body>
    <?php
     
       
       $name="";
       $email="";   
       $pass="";
      
       $gender="";
       function random_password( $length = 8 ) 
        {
                $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
                $password = substr( str_shuffle( $chars ), 0, $length );
                return $password;
        }

        function email_send($to,$sub,$msg)
        {
            $to_email=$to;
            $subject=$sub;
            $message=$msg;
            $heders="From: ";

            if(mail($to_email,$subject,$message,$heders))
            {
              echo "<script> alert('E-Mail Send  To you , Check your inbox '); </script>";
            }
            else
              echo "<script> alert('Your Internet connection is not Working '); </script>";
        }
        function encrypt($string)
       {
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'AA74CDCC2BBRT935136HH7B63C27'; 
        $secret_iv = '5fgf5HJ5g27'; // user define secret key
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
       
        $output = openssl_encrypt($string, $encrypt_method, $key, 0,$iv);
        $output = base64_encode($output);
      
       return $output;
       }


       if(isset($_POST['btnsub']))
       {

            $name=$_POST['txtname'];
            $email=$_POST['txtmail'];
              $pass1=random_password(8);
            $pass=encrypt($pass1);
            // $pass=$_POST['txtpass'];
            $gender=$_POST['rbgen'];
            include "connection.php";
            $dt=date("y-m-d");
 
            $sqlcheck="Select * from tab_user where user_email='".$email."'";

            $result= mysqli_query($con,$sqlcheck);
            $rowcount= mysqli_num_rows($result);

            if($rowcount==0)
            {   

                    $insert="INSERT INTO tab_user(user_name,user_email,user_password,user_gender,creation_date)VALUES('$name','$email','$pass','$gender','$dt')";
                   
                    if(!mysqli_query($con,$insert))
                    {
                        die('Error:'.mysqli_error($con));
                    }
                    else
                    {
                     
                        $msg1= " Hello $name,\n\n Welcome to Stranger Became Arranger for events booking  ,  \n\nYour User login Password is : $pass1  ";
                      email_send($email," Your Password for user Login", $msg1);

                       echo"1 record added";
                   
                    } 
            }
            else
                echo "<h3>$email is already in used . Try with Another !!! </h3>";

            mysqli_close($con);
            // header('location:user_login.php');
        }
   ?>
    <header class="site-header">
    <div class="header-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-10 col-lg-2 order-lg-1">
                    <div class="site-branding">
                        <div class="site-title">
                            <a href="index.php"><img src="image/logo.png" alt="logo"></a>
                        </div><!-- .site-title -->
                    </div><!-- .site-branding -->
                </div><!-- .col -->

                <div class="col-2 col-lg-7 order-3 order-lg-2">
                    <nav class="site-navigation">
                        <div class="hamburger-menu d-lg-none">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div><!-- .hamburger-menu -->

                        <ul>
                           <li><a style="color: #BE90D4;" href="index.php"><b>Home</b></a></li>
                            <li><a style="color: #BE90D4;" href="elements.php"><b>About us </b></a></li>
                            <li><a style="color: #BE90D4;" href="events.php"><b>Events</b></a></li>
                            
                            <li><a style="color: #BE90D4;"href="events-news.php"><b>News</b></a></li>
                            <li><a style="color: #BE90D4;" href="contact.php"><b>Contact</b></a></li>
                        </ul>
                    </nav><!-- .site-navigation -->
                </div><!-- .col -->

                <div class="col-lg-3 d-none d-lg-block order-2 order-lg-3">
                    <div class="buy-tickets">
                        <a class="btn gradient-bg" href="user_login.php">Login</a>
                    </div><!-- .buy-tickets -->
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .container-fluid -->
    </div><!-- .header-bar -->

    <div class="page-header single-event-page-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <header class="entry-header">
                        <h1 class="entry-title">Sign Up/ Login</h1>
                    </header>
                </div>
            </div>
        </div>
    </div>
</header>
	 
	<div class="container-fluid ">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 mb-5 c1">
                <h1 class="text-center c2"> User Creation </h1>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" >
                	<div class="form-group">
                        <label for="txtname" class="c3"><h5>User Name</h5></label>
                        <input type="text" class="form-control" id="txtname" name="txtname"placeholder="user name" required="">
                    </div>
                    <div class="form-group">
                        <label for="txtmail" class="c3"><h5>User Email</h5></label>
                        <input type="email" class="form-control" id="txtmail" name="txtmail"placeholder="enter email" required="">
                    </div>
                    <div class="form-group">
                        <label for="txtpass" class="c3"><h5>User Password</h5></label>
                        <br/>
                         <big> Please use the password which is send to your Gmail</big>
                    </div>
                     <fieldset class="form-group">
                        <legend class="c3"><h5>Gender</h5></legend>
                        <div>
                                <div class="primary-radio">
                                    <input type="radio" name="rbgen" id="rbyes" value="male"checked>
                                    <label for="rbno"><p class="text-dark">Male</p></label>
                                </div>
                            </div>
                        <div class="primary-radio"> 
                           <input type="radio" name="rbgen" id="rbno" value="female">
                                    <label for="rbno"><p class="text-dark">Female</p></label>
                        </div>
                    </fieldset>
                    <div >
                        <div class="row">
                            <div class="col-sm-6">
                                <button type="submit" name="btnsub" class="btn c4 btn-block">Save
                                </button> 
                            </div>
                            <div class="col-sm-6">
                                <button type="reset" class="ml-5 c4 btn btn-block">Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php';
    ?>
</body>
</html>
