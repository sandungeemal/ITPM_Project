<?php namespace App\Models;

use CodeIgniter\Model;

class LmsModel extends Model{
    protected $table = 'assignments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['assignmentName', 'subject', 'year', 'semester', 'pdf'];

    
}