<?php

class LmsController extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('LmsModel');
        $this->load->model('UserModel');
        $arr = array();
    }

    public function home(){

        $this->load->view('home');

    }

    public function student(){
        $user=$this->userConfirm();

        if ($user=='student') {
            $this->load->view('student/student');
        }else{
            redirect("LmsController/profile");
        }

    }

    public function logout(){

        if (isset($_SESSION['user_logged'])&&isset($_SESSION['regNum'])){
            $this->UserModel->last_sign($_SESSION['regNum']);
        }

        session_destroy();

        unset($_SESSION);
        redirect("LmsController/home");

    }

    public function stdSettings(){

        $user=$this->userConfirm();

        if ($user == 'student') {

            if (isset($_POST['confirmEmail'])) {
                $this->UserModel->confirmEmail($_POST['email'], $_SESSION['regNum']);
            }

            if (isset($_POST['confirmPhone'])) {
                $this->UserModel->confirmPhone($_POST['phone'], $_SESSION['regNum']);
            }

            if (isset($_POST['confirmPassword'])) {
                $this->UserModel->confirmPassword($_POST['password'], $_POST['currentPassword'], $_SESSION['regNum']);
            }

            $data['user'] = $this->UserModel->userDetails($_SESSION['regNum']);

            $this->load->view('student/settings', $data);
        }else{
            redirect("LmsController/profile");
        }
    }

    public function studentRegister(){

        $user=$this->userConfirm();

        if ($user == 'admin') {
            if(isset($_POST['addStudent'])){
                $this->LmsModel->addStudent($_POST['fname'],$_POST['lname'],$_POST['sname'],$_POST['nic'],$_POST['phone'],$_POST['email']);
            }

            if(isset($_POST['editStudent'])){
                $this->LmsModel->registerUpdate($_POST['regNum'],$_POST['fname'],$_POST['lname'],$_POST['sname'],$_POST['nic'],$_POST['phone'],$_POST['email'],'student');
            }

            if(isset($_POST['deleteStudent'])){
                $this->LmsModel->deleteUser($_POST['regNum']);
            }

            $data['student'] =$this->LmsModel->usersDetails('student');

            $this->load->view('admin/student',$data);
        }else{
            redirect("LmsController/profile");
        }

    }

    public function stdCourse(){
        $user=$this->userConfirm();

        if ($user=='student') {
            if (isset($_SESSION['courseworkId'])) {
                if (isset($_POST['assignment_id'])) {
                    $_SESSION['std_assignment_id'] = $_POST['assignment_id'];
                    redirect('LmsController/stdAssignment');
                }
                $data['material'] = $this->LmsModel->courseMaterialDetails($_SESSION['courseworkId']);

                $data['assignment'] = $this->LmsModel->assignmentDetails($_SESSION['courseworkId']);

                $data['notices'] = $this->LmsModel->courseNotices($_SESSION['courseworkId']);

                $_SESSION['courseName'] = $this->LmsModel->courseInformation($_SESSION['courseworkId']);

                $this->load->view('student/course', $data);
            } else {
                redirect('LmsController/coursework');
            }
        }else{
            redirect("LmsController/profile");
        }
    }

    public function stdAssignment(){
        $user=$this->userConfirm();

        if ($user=='student') {
            if (isset($_SESSION['std_assignment_id'])) {
                if ($this->LmsModel->submissionDateCheck($_SESSION['std_assignment_id'])) {
                    if (isset($_POST['addSubmission'])) {

                        $file = $_FILES['upload_File'];

                        $ext = pathinfo($file['name']);

                        $filename = 'submission/' . $_SESSION['regNum'] . time() . '.' . $ext['extension'];

                        move_uploaded_file($file['tmp_name'], $filename);

                        $this->LmsModel->addSubmission($filename, $_POST['description'], $_SESSION['std_assignment_id'], $_SESSION['regNum']);
                    }
                    $data['submission'] = $this->LmsModel->submissionDetails($_SESSION['std_assignment_id']);

                    $this->load->view('student/addSubmission', $data);
                } else {
                    redirect('LmsController/stdCourse');
                }
            } else {
                redirect('LmsController/profile');
            }
        }else{
            redirect("LmsController/profile");
        }
    }

    public function stdNotification(){
        $user=$this->userConfirm();

        if ($user=='student') {
            $this->LmsModel->notifyUser($_SESSION['regNum']);

            $data['notification'] = $this->LmsModel->notification($_SESSION['regNum']);

            $data['assignments'] = $this->LmsModel->notificationAssignment($_SESSION['regNum']);

            $_SESSION['userNotification'] = null;

            $this->load->view('student/notifications', $data);
        }else{
            redirect("LmsController/profile");
        }
    }

}