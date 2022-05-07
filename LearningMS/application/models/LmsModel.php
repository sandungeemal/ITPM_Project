<?php

class LmsModel extends CI_Model{

    public function addStudent($fname,$lname,$sname,$nic,$phone,$email){

        $query =$this->db->query("SELECT regNum FROM register WHERE student = true ORDER BY id DESC LIMIT 1");

        if($query->result()){

            $student = $query->row();

            $regNum = $student->regNum;

            $number = preg_replace("/[^0-9]/", '', $regNum) + 8;

            $this->db->select('*');
            $this->db->from('register');
            $this->db->where(array('regNum'=> 'IT'.str_pad($number, 8, '0', STR_PAD_LEFT)));
            $query = $this->db->get();

            if($query->result()){

                $number = preg_replace("/[^0-9]/", '', $regNum) + 9;

                $this->register($fname,$lname,$sname,$nic,$phone,$email,'IT'.str_pad($number, 8, '0', STR_PAD_LEFT),'student');

            }else{

                $this->register($fname,$lname,$sname,$nic,$phone,$email,'IT'.str_pad($number, 8, '0', STR_PAD_LEFT),'student');

            }

        }else{

            $regNum = 'IT0000008';

            $this->register($fname,$lname,$sname,$nic,$phone,$email,$regNum,'student');

        }

    }

    private function register($fname,$lname,$sname,$nic,$phone,$email,$regNum,$type){

        if($this->checkNic($nic)){
            $this->session->set_flashdata("error", "1");
        }else {

            if ($this->checkEmail($email)) {
                $this->session->set_flashdata("error", "2");
            } else {
                if ($type == 'student') {

                    $data = array(

                        'fname' => $fname,
                        'lname' => $lname,
                        'sname' => $sname,
                        'nic' => $nic,
                        'regNum' => $regNum,
                        'phone' => $phone,
                        'email' => $email,
                        'student' => true

                    );

                    $this->db->insert('register', $data);

                    $this->session->set_flashdata("success", "1");

                    $this->session->set_flashdata("reg_No", $regNum);

            }
        }

    }

    private function updateDetails($regNum,$fname,$lname,$sname,$nic,$phone,$email,$type){

        if ($type=='student'){

            $data = array(

                'fname' => $fname,
                'lname' => $lname,
                'sname' => $sname,
                'nic' => $nic,
                'regNum' => $regNum,
                'phone' => $phone,
                'email' => $email,
                'student' => true

            );

            $this->db->where(array('regNum'=> $regNum));
            $this->db->set($data);
            $this->db->update('register');

            $this->session->set_flashdata("success", "2");

            $this->db->where(array('regNum'=> $regNum));
            $this->db->set($data);
            $this->db->update('register');

            $this->session->set_flashdata("success", "2");

        }

    }


    public function enrollCourse($id,$key,$regNum){

        $this->db->select('*');
        $this->db->from('course');
        $this->db->where(array('id'=>$id,'enrollment'=>$key));
        $query = $this->db->get();

        if($query->result()){

            $course=$query->row();

            $data = array(
                'course' => $course->course_id,
                'c_id' => $id,
                'regNum' => $regNum
            );

            $this->db->insert('enrollment', $data);

            if ($_SESSION['userType'] == 'student'){
                redirect('LmsController/stdCourse');
            }else if ($_SESSION['userType'] == 'lecturer'){
                redirect('LmsController/courseView');
            }

        }else{
            $this->session->set_flashdata("error", "1");
        }

    }


    public function notification($regNum){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where(array('regNum'=>$regNum));
        $query = $this->db->get();

        $user= $query->row();

        if($user->notifications==1){
            $last_day = $user->last_sign;

            $query =$this->db->query("SELECT * FROM course where date >'".$last_day."' or DATE_ADD(date, INTERVAL 14 DAY)>'".date('Y-m-d')."'");

            return $query->result();

        }else{
            return array();
        }
    }


    public function notifyUser($regNum){
        $this->db->set('notifications', null);
        $this->db->where('regNum', $regNum);
        $this->db->update('users');
    }


    public function notificationCheck($id){
        $query =$this->db->query("SELECT * FROM users WHERE regNum='".$id."'");

        $user = $query->row();

        return $user->notifications;
    }

}