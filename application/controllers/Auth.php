<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $this->load->view('auth/login');
    }

    public function login()
{
    $nim = $this->input->post('nim');
    $password = $this->input->post('password');

    $user = $this->User_model->get_user($nim);

    if ($user && password_verify($password, $user->password)) {
        $session_data = [
            'user_id' => $user->id,
            'nim' => $user->nim,
            'nama' => $user->nama,
            'role' => $user->role, // Simpan role di session
            'logged_in' => TRUE
        ];
        $this->session->set_userdata($session_data);

        // Redirect berdasarkan role
        if ($user->role == 'admin') {
            redirect('dashboard/admin');
        } else {
            redirect('dashboard/mahasiswa');
        }
    } else {
        $this->session->set_flashdata('error', 'NIM atau Password salah');
        redirect('auth');
    }
}

    public function logout()
    {
        $this->session->unset_userdata(['user_id', 'nim', 'nama', 'role', 'logged_in']);
        redirect('auth');
    }

    public function register()
{
    if ($this->session->userdata('logged_in')) {
        redirect('dashboard');
    }

    $this->load->library('form_validation');
    
    $this->form_validation->set_rules('nim', 'NIM', 'required|min_length[5]');
    $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
    $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,mahasiswa]');
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
    $this->form_validation->set_rules('password_conf', 'Konfirmasi Password', 'required|matches[password]');

    if ($this->form_validation->run() === FALSE) {
        $this->load->view('auth/register');
    } else {
        $nim = $this->input->post('nim');
        
        if ($this->User_model->nim_exists($nim)) {
            $this->session->set_flashdata('error', 'NIM sudah terdaftar');
            redirect('auth/register');
        }

        $data = [
            'nim' => $nim,
            'nama' => $this->input->post('nama'),
            'password' => $this->input->post('password'),
            'role' => $this->input->post('role') // Ambil role dari form
        ];

        if ($this->User_model->register($data)) {
            $this->session->set_flashdata('success', 'Pendaftaran berhasil! Silakan login');
            redirect('auth');
        } else {
            $this->session->set_flashdata('error', 'Gagal melakukan pendaftaran');
            redirect('auth/register');
        }
    }
}
}
?>