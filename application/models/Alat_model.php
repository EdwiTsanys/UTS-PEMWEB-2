<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alat_model extends CI_Model {

    public function get_all_alat()
    {
        return $this->db->get('alat')->result();
    }

    public function get_alat($id)
    {
        return $this->db->get_where('alat', ['id' => $id])->row();
    }

    public function update_stok($id, $stok)
{
    $this->db->where('id', $id);
    $this->db->update('alat', ['stok' => $stok]);
    return $this->db->affected_rows();
}
    public function create_alat($data)
{
    $this->db->insert('alat', $data);
    return $this->db->insert_id();
}

public function update_alat($id, $data)
{
    $this->db->where('id', $id);
    $this->db->update('alat', $data);
    return $this->db->affected_rows();
}

public function delete_alat($id)
{
    $this->db->where('id', $id);
    $this->db->delete('alat');
    return $this->db->affected_rows();
}
}
?>