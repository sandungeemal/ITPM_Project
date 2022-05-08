<?php

namespace App\Controllers;

use App\Models\LmsModel;
use CodeIgniter\Exceptions\AlertError;
use  CodeIgniter\Files\File;

use function PHPUnit\Framework\fileExists;

class LmsController extends BaseController
{
    
    public function home(){

        $this->load->view('home');

    }
    
    public function assignments()
    {
        $viewAssignments = new LmsModel();

        $data['allAssignments'] = $viewAssignments->findAll();
        return view('view-all-assignments', $data);
    }
    // show single user
    function viewAssignment($id)
    {
        $viewAssignment = new LmsModel();

        $data['view_assignment'] = $viewAssignment->where('id', $id)->first();

        return view('viewAssignment', $data);
    }
    
    public function addAssignment(){
        return view('addAssignment');
    }


    public function addNewAssignment(){
         
        $addAssignment = new LmsModel();

        $file = $this->request->getFile('pdf');

        if($file ->isValid() && ! $file->hasMoved()){
            $filename = $file->getClientName();
            $file->move('submission/', $filename);
        }

        $data = [
            'assignmentName' => $this-> request->getPost('assignmentName'),
            'subject' => $this-> request->getPost('subject'),
            'year' => $this-> request->getPost('year'),
            'semester' => $this-> request->getPost('semester'),
            'pdf' => $filename
        ];

        $addAssignment->save($data);
        session()->setFlashdata('status_text', 'Your Assignment Added Successfully..!');
        return redirect()->to(base_url('public/assignments'))
            ->with('status_icon', 'success')
            ->with('status', 'Assignment Added.');
        
    }

    public function viewAllAssignments(){
        $viewAssignments = new LmsModel();

        $data['allAssignments'] = $viewAssignments->findAll();

        $data['pagination_link'] = $viewAssignments->pager;
        return view('view-all-assignments', $data);
    }

    public function editAssignment($id){
        $editAssignments = new LmsModel();
        $data['edit_assignment']=$editAssignments->find($id);
        return view('editAssignment', $data);
    }

    public function updateAssignment($id){
         
        $updateAssignment = new LmsModel();

        $assignment= $updateAssignment->find($id);

        $file = $this->request->getFile('pdf');
        $old_filename = $assignment['pdf'];

        if($file ->isValid() && !$file->hasMoved()){
            
            if(file_exists("submission/".$old_filename)){
                unlink("submission/".$old_filename);
            }
            $filename = $file->getClientName();
            $file->move('submission/', $filename);
        }else{
            $filename=$old_filename;
        }

            $data = [
                'assignmentName' => $this-> request->getPost('assignmentName'),
                'subject' => $this-> request->getPost('subject'),
                'year' => $this-> request->getPost('year'),
                'semester' => $this-> request->getPost('semester'),
                'pdf' => $filename,
            ];

            $updateAssignment->update($id, $data);
            session()->setFlashdata('status_text', 'Your Assignment Update Successfully..!');
            return redirect()->to(base_url('public/assignments'))
                    ->with('status_icon', 'success')
                    ->with('status', 'Update assignment Successfully.');
    }

    public function deleteAssignment($id=null){
        $deleteAssignment = new LmsModel();

        $data= $deleteAssignment->find($id);
        $fname = $data['assignmentName'];
        $file= $data['pdf'];

        if(file_exists("submission/".$file)){
            unlink("submission/".$file);
        }

        $deleteAssignment->delete($id);

        $data = [
            'status' => 'Removed successfully.',
            'status_text' => 'Assignment removed successfully.',
            'status_icon' => 'success'
        ];
        
        return $this->response->setJSON($data);
    }
}
