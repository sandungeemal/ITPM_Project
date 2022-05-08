<?php

namespace App\Controllers;
use CodeIgniter\Model;

class Admin extends BaseController
{
    public function index()
    {
        return view('dashboard');
    }

    public function course()
    {
        return view('view-all-assignments');
    }
}
