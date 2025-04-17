<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model extends CI_Model {

    public function create_booking($data)
    {
        $this->db->insert('booking', $data);
        return $this->db->insert_id();
    }

    public function get_booking_by_id($id)
{
    $this->db->select('booking.*, alat.nama_alat, users.nama as nama_mahasiswa');
    $this->db->from('booking');
    $this->db->join('alat', 'alat.id = booking.alat_id');
    $this->db->join('users', 'users.id = booking.user_id');
    $this->db->where('booking.id', $id);
    return $this->db->get()->row();
}
    public function get_booking_by_user($user_id)
{
    $this->db->select('booking.*, alat.nama_alat');
    $this->db->from('booking');
    $this->db->join('alat', 'alat.id = booking.alat_id');
    $this->db->where('booking.user_id', $user_id);
    $this->db->order_by('booking.created_at', 'DESC'); // Urutkan dari yang terbaru
    return $this->db->get()->result();
}   

    public function get_all_bookings()
    {
        $this->db->select('booking.*, alat.nama_alat, users.nama as nama_mahasiswa');
        $this->db->from('booking');
        $this->db->join('alat', 'alat.id = booking.alat_id');
        $this->db->join('users', 'users.id = booking.user_id');
        return $this->db->get()->result();
    }

    public function update_status($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->update('booking', ['status' => $status]);
        return $this->db->affected_rows();
    }

    public function check_availability($alat_id, $tanggal_pinjam)
    {
        $this->db->where('alat_id', $alat_id);
        $this->db->where('tanggal_pinjam', $tanggal_pinjam);
        $this->db->where('status !=', 'ditolak');
        return $this->db->get('booking')->num_rows();
    }
}
?>