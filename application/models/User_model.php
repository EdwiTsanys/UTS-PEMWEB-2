<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function get_user($nim)
    {
        return $this->db->get_where('users', ['nim' => $nim])->row();
    }

    public function create_user($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function get_all_users()
    {
        return $this->db->get('users')->result();
    }

    public function register($data)
{
    // Hash password sebelum disimpan
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    $data['created_at'] = date('Y-m-d H:i:s');
    
    // Default role jika tidak diset
    if (!isset($data['role'])) {
        $data['role'] = 'mahasiswa';
    }
    
    $this->db->insert('users', $data);
    return $this->db->insert_id();
}

    public function nim_exists($nim){
        return $this->db->get_where('users', ['nim' => $nim])->num_rows() > 0;
    }
}
?>