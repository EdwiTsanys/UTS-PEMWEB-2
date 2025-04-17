<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index()
    {
        if ($this->session->userdata('role') == 'admin') {
            redirect('dashboard/admin');
        } else {
            redirect('dashboard/mahasiswa');
        }
    }

    public function mahasiswa()
{
    if ($this->session->userdata('role') != 'mahasiswa') {
        show_404();
    }
    
    $this->load->model('Booking_model');
    $user_id = $this->session->userdata('user_id');
    
    // Ambil data peminjaman khusus user yang login
    $data['bookings'] = $this->Booking_model->get_booking_by_user($user_id);
    
    $this->load->view('templates/header');
    $this->load->view('templates/navbar');
    $this->load->view('dashboard/mahasiswa', $data);
    $this->load->view('templates/footer');
}

    public function admin()
    {
        if ($this->session->userdata('role') != 'admin') {
            show_404();
        }
        $this->load->model('Booking_model');
        $data['bookings'] = $this->Booking_model->get_all_bookings();
        
        $this->load->view('templates/header');
        $this->load->view('templates/navbar');
        $this->load->view('dashboard/admin', $data);
        $this->load->view('templates/footer');
    }
}
?>