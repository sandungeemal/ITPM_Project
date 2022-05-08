<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="icon" href="<?php echo base_url(); ?>siteimage/site.jpg" type="image/ico">

    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/menu_toggle.js"></script>

    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/croppie.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/croppie.css" />

    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
    <script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/stylesheet.css">
    <script src="<?php echo base_url(); ?>assets/js/login.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/profile.js"></script>
</head>
<body style="background-image: url('<?php echo base_url(); ?>siteimage/wall.png');">
    <div class="mainDiv">
        <div class="menu-toggle" id="hamburger">
            <i class="fas fa-bars"></i>
        </div>
        <div class="overlay"></div>
        <div class="container">
            <nav>
                <h1 class="brand"><a href="<?php echo base_url('LmsController/home'); ?>">LMS<span> </span>Portal</a></h1>
                <ul>
                    <?php
                    if (isset($_SESSION['userType'])){
                        echo '
                            <li><a href="'.base_url('LmsController/home').'">Home</a></li>
                            <li><a href="'.base_url('LmsController/profile').'">Profile</a></li>
                            <li><a href="'.base_url('LmsController/logout').'">Logout</a></li>
                            ';
                    }else{
                        echo '
                            <li><a href="'.base_url('LmsController/home').'">Home</a></li>
                            <li><a href="'.base_url('UserController/Login').'">Login</a></li>
                            <li><a href="'.base_url('UserController/register').'">Register</a></li>
                            ';
                    }
                    ?>
                </ul>
            </nav>
        </div>
        <div class="loginBox">
            <img src="<?php echo base_url(); ?>siteimage/user.png" class="userImage">
            <h2>Log In Here</h2>
            <form action="login" method="post" onsubmit="return checkLogin(this);">
                <p>Registration No</p>
                <input type="text" name="regNo" id="regNum" placeholder="Enter Your Registration No." required>
                <p>Password</p>
                <input type="password" name="password" placeholder="••••••••" required>
                <input type="submit" name="login" value="Sign in">
                <a href="<?php echo site_url('UserController/register'); ?>">Register</a>
            </form>
        </div>
    </div>
    <div class="headDiv">
    </div>
</body>
</html>

<script>

    window.onload = function(e){
        var x="<?php if(isset($_SESSION['success'])){ echo $_SESSION['success'];}?>";
        if("1"==x){
            swal("Success!", "Registration Successful!", "success");
            <?php $this->session->set_flashdata("success",null); ?>
        }

        var y="<?php if(isset($_SESSION['error'])){ echo $_SESSION['error'];}?>";

        if("1"==y){
            showErrorMsg("This Registration No Unavailable In The System !");
            <?php $this->session->set_flashdata("error",null); ?>
        }else if("2"==y){
            showErrorMsg("Your Password Is Incorrect !");
            <?php $this->session->set_flashdata("error",null); ?>
        }else if("3"==y){
            showErrorMsg("Please Register First & After Try Again !");
            <?php $this->session->set_flashdata("error",null); ?>
        }
    }

</script>