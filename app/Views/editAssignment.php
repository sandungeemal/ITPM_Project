<html lang="en">
<head>
    <title>admin</title>
    <link rel="icon" href="<?= base_url('siteimage/site.jpg'); ?>" type="image/ico">

    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    <script src="<?= base_url('assets/js/menu_toggle.js'); ?>"></script>

    <script src="assets/js/jquery.min.js"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/croppie.js'); ?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/croppie.css'); ?>" />

    <link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/stylesheet.css'); ?>">
    <script src="<?= base_url('assets/js/sweetalert.min.js'); ?>"></script>
    <script src="<?= base_url('assets/css/register.js'); ?>"></script>


</head>
<body style="background-image: url('<?= base_url('siteimage/wall.png'); ?>');">

<div class="mainDiv">

    <div class="menu-toggle" id="hamburger">
        <i class="fas fa-bars"></i>
    </div>
    <div class="overlay"></div>
    <div class="container">
        <nav>
            <h1 class="brand"><a href="<?php echo base_url('LmsController/home'); ?>">SLI<span>IT</span> LMS</a></h1>
            <ul>
                <li><a href="<?php echo base_url('LmsController/home'); ?>">Home</a></li>
                <li><a href="<?php echo base_url('LmsController/profile'); ?>">Profile</a></li>
                <li><a href="<?php echo base_url('LmsController/logout'); ?>">Logout</a></li>
            </ul>
        </nav>
    </div>

    <div class="profileLine"></div>
    <div class="profileBox">
        <img src="<?php if(!isset($_SESSION['imagePath'])||$_SESSION['imagePath']==null){echo base_url().'/siteimage/user.png';}else{ echo base_url().base64_decode($_SESSION['imagePath']);} ?>" class="userImage">
        <img src="<?= base_url('siteimage/update.png'); ?>" class="updateImage" onclick="uploadImage()">
        <div class="hiddenfile">
            <input type="file" id="upload_image" name="upload_image" accept="image/*" >
        </div>
        <div class="profile-links">
            <div class="line-rows"><a href="<?php echo base_url('LmsController/coursework'); ?>" >All Courses</a></div>
            <div class="line-rows"><a href="LmsController/assignments" >Courses Details</a></div>
            <div class="line-rows"><a href="<?php echo base_url('LmsController/lecturerRegister'); ?>" >Lecturers</a></div>
            <div class="line-rows"><a href="<?php echo base_url('LmsController/studentRegister'); ?>" >Students</a></div>
            <div class="line-rows"><a href="../assignments" >Assignments</a></div>
            <div class="line-rows"><a href="<?php echo base_url('LmsController/adminSettings'); ?>" >Account Settings</a></div>
        </div>
        <?php

        $session = \Config\Services::session();

        if($session->getFlashdata('success'))
        {
            echo '
            <div class="alert alert-success">'.$session->getFlashdata("success").'</div>
            ';
        }

        ?>
        <div class="user-setting">
           
            <div class="line-rows"><a id="new_assignment">Update <?php echo $edit_assignment["assignmentName"]; ?> Assignment</a></div>
            <div class="" id="div_new_assignment">
                <form action="<?= '../update-assignment/'. $edit_assignment["id"];?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <p>Assignment Name</p>
                            <input type="text" name="assignmentName" value="<?php echo $edit_assignment["assignmentName"]; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <p>Year</p>
                            <input type="text" name="year" value="<?php echo $edit_assignment["year"]; ?>" required> 
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                           <p>Subject</p>
                            <input type="text" name="subject" value="<?php echo $edit_assignment["subject"]; ?>" required> 
                        </div>
                        <div class="col-md-6">
                            <p>Semester</p>
                            <input type="text" name="semester" value="<?php echo $edit_assignment["semester"]; ?>" required> 
                        </div>
                    </div>
                    
                    <p>Upload Document</p>
                    <input type="text" name="assignmentDocument" id="assignmentDocument" style="cursor: pointer" value="<?= $edit_assignment["pdf"]; ?>" readonly>
                    <div class="hiddenDiv">
                        <input type="file" name="pdf" id="assignmentFile" onchange="setAssignmentDocument()" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf">
                    </div>
                    <input type="button" value="Update" onclick="uploadAssignment()">
                    
                    <br><br>
                    <input type="submit" value="Confirm">
                    <input type="hidden" name="addAssignment">
                    <br><br>
                </form>
            </div>

        </div>
    </div>

</div>

<div class="headDiv">
</div>
</body>
</html>

<div id="uploadimageModal" class="modal" role="dialog" style="margin-top: 5%">
    <div class="modal-dialog" style="width: 535px;height: 500px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Upload & Crop Image</h4>
            </div>
            <div class="modal-body" >
                <div class="row" >
                    <div class="col-md-12 text-center" >
                        <div id="image_demo" style="width:150px;"></div>
                    </div>
                    <div class="col-md-12" style="padding-top:30px;margin-top: -4%;margin-left: 63.5%">
                        <button class="btn btn-primary crop_image">Crop & Upload Image</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){

        $image_crop = $('#image_demo').croppie({
            enableExif: true,
            viewport: {
                width:400,
                height:400,
                type:'square' //circle
            },
            crop_size: {
                width:600,
                height:600,
                type:'square' //circle
            },
            boundary:{
                width:500,
                height:500
            }
        });

        $('#upload_image').on('change', function(){
            var reader = new FileReader();
            reader.onload = function (event) {
                $image_crop.croppie('bind', {
                    url: event.target.result
                }).then(function(){
                    console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(this.files[0]);
            $('#uploadimageModal').modal('show');
        });

        $('.crop_image').click(function(event){
            $image_crop.croppie('result', {
                type: 'canvas',
                size: 'crop_size'
            }).then(function(response){
                $.ajax({
                    url:'<?php echo site_url('UserController/image'); ?>',
                    type: "POST",
                    data:{"image": response},
                    success:function(data)
                    {
                        $('#uploadimageModal').modal('hide');
                        location.reload();
                    }
                });
            })
        });

    });

    function uploadImage() {
        $('#upload_image').trigger('click');
    }

    function uploadCourseFile() {
        $('#upload_File').trigger('click');
    }

    function uploadAssignment() {
        $('#assignmentFile').trigger('click');
    }

    function uploadAssignmentEdit() {
        $('#editAssignmentFile').trigger('click');
    }

    function uploadCourseFileChange() {
        var id = document.getElementById("old_id").value;
        if (id != ""){
            $('#upload_File_Change').trigger('click');
        }
    }

    function setFileName() {

        var fileInput = document.getElementById('upload_File');
        var filename = fileInput.files[0].name;

        document.getElementById("file_name").innerHTML = filename;

    }

    function setChangeFileName() {

        var fileInput = document.getElementById('upload_File_Change');
        var filename = fileInput.files[0].name;

        document.getElementById('filePath').value = filename;

        document.getElementById("editUrl").value = "";

    }

    function setAssignmentDocument() {

        var fileInput = document.getElementById('assignmentFile');
        var filename = fileInput.files[0].name;

        document.getElementById('assignmentDocument').value = filename;

    }

    function setAssignmentDocumentEdit() {

        var fileInput = document.getElementById('editAssignmentFile');
        var filename = fileInput.files[0].name;

        document.getElementById('editAssignmentDocument').value = filename;

        document.getElementById("assignmentFileUrl").value = "";

    }

    function clickUrl() {

        var url = document.getElementById("editUrl").value;

        if(url != ""){
            window.open(url, '_blank');
        }

    }

    function removeClickUrl() {

        var url = document.getElementById("removeUrl").value;

        if(url != ""){
            window.open(url, '_blank');
        }

    }

    function assignmentClickUrl() {

        var url = document.getElementById("assignmentFileUrl").value;

        if(url != ""){
            window.open(url, '_blank');
        }

    }

    function assignmentRemoveClickUrl() {

        var url = document.getElementById("assignmentFileUrlRemove").value;

        if(url != ""){
            window.open(url, '_blank');
        }

    }

</script>