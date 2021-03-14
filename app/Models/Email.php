<?php

namespace App\Models;

use CodeIgniter\Model;

class Email extends Model
{
    protected $table      = 'email_tugas';
    protected $allowedFields = ['id_emailtugas', 'subject', 'nama_tugas', 'deadline', 'isi_email'];

    public function getEmail($date)
    {
        return $this->getWhere(['send_on' => $date])->getResultArray();
    }

    
}