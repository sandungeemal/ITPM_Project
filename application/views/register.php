<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
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
    <script src="<?php echo base_url(); ?>assets/js/register.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/stylesheet.css">
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

        <div class="registerBox">
            <img src="<?php echo base_url(); ?>siteimage/user.png" class="userImage">
            <h3>Register In Here</h3>
            <form action="register" method="post" onsubmit="return checkForm(this);">
                <p>Registration No</p>
                <input type="text" name="regNo" id="reg" placeholder="Enter Your Registration No." required>
                <p>NIC No</p>
                <input type="text" name="nic" id="nic" placeholder="Enter Your NIC No." required>
                <p>Password</p>
                <input type="password" name="password" id="password" placeholder="••••••••" required>
                <p>Confirm Password</p>
                <input type="password" name="cpassword" id="cpassword" placeholder="••••••••" required>
                <br><br>
                <input type="submit" name="submit" value="Register"><br>
                <a href="<?php echo site_url('UserController/login'); ?>">Login</a>
                <input type="hidden" name="register">
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
            swal("Success!", "Your Change Successful!", "success");
            <?php $this->session->set_flashdata("success",null); ?>
        }

        var y="<?php if(isset($_SESSION['error'])){ echo $_SESSION['error'];}?>";

        if("1"==y){
            swal({
                title: "Error",
                text: "Something Is Wrong !",
                icon: "warning",
                dangerMode: true,
            });
            <?php $this->session->set_flashdata("error",null); ?>
        }else if("2"==y){
            swal({
                title: "Error",
                text: "This NIC Number Is Wrong !",
                icon: "warning",
                dangerMode: true,
            });
            <?php $this->session->set_flashdata("error",null); ?>
        }else if("3"==y){
            swal({
                title: "Error",
                text: "This Registration No Is Invalid !",
                icon: "warning",
                dangerMode: true,
            });
            <?php $this->session->set_flashdata("error",null); ?>
        }
    }

</script>