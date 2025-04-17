<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        $this->load->model('Alat_model');
        $this->load->model('Booking_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['alat'] = $this->Alat_model->get_all_alat();
        
        $this->load->view('templates/header');
        $this->load->view('templates/navbar');
        $this->load->view('booking/index', $data);
        $this->load->view('templates/footer');
    }

    public function create($alat_id)
    {
        $data['alat'] = $this->Alat_model->get_alat($alat_id);
        
        $this->load->view('templates/header');
        $this->load->view('templates/navbar');
        $this->load->view('booking/create', $data);
        $this->load->view('templates/footer');
    }

    public function store()
    {
        $this->form_validation->set_rules('tanggal_pinjam', 'Tanggal Pinjam', 'required');
        $this->form_validation->set_rules('tanggal_kembali', 'Tanggal Kembali', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->create($this->input->post('alat_id'));
        } else {
            $alat_id = $this->input->post('alat_id');
            $tanggal_pinjam = $this->input->post('tanggal_pinjam');

            // Cek ketersediaan
            $booked = $this->Booking_model->check_availability($alat_id, $tanggal_pinjam);
            $alat = $this->Alat_model->get_alat($alat_id);

            if ($booked >= $alat->stok) {
                $this->session->set_flashdata('error', 'Alat sudah habis dipinjam untuk tanggal tersebut');
                redirect('booking/create/'.$alat_id);
            }

            $booked_count = $this->Booking_model->check_availability($alat_id, $tanggal_pinjam);
    
    if ($booked_count >= $alat->stok) {
        $this->session->set_flashdata('error', 'Maaf, stok alat "'.$alat->nama_alat.'" sudah habis untuk tanggal '.date('d/m/Y', strtotime($tanggal_pinjam)));
        redirect('booking/create/'.$alat_id);
    }

            $data = array(
                'user_id' => $this->session->userdata('user_id'),
                'alat_id' => $alat_id,
                'tanggal_pinjam' => $tanggal_pinjam,
                'tanggal_kembali' => $this->input->post('tanggal_kembali'),
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            );

            $this->Booking_model->create_booking($data);
            $this->session->set_flashdata('success', 'Booking berhasil dibuat, menunggu verifikasi admin');
            redirect('dashboard/mahasiswa');
        }
    }

    public function approve($id)
{
    if ($this->session->userdata('role') != 'admin') {
        show_404();
    }

    $this->load->model(['Booking_model', 'Alat_model']);
    
    // Dapatkan data peminjaman
    $booking = $this->Booking_model->get_booking_by_id($id);
    
    if (!$booking) {
        $this->session->set_flashdata('error', 'Data peminjaman tidak ditemukan');
        redirect('dashboard/admin');
    }

    // Dapatkan data alat
    $alat = $this->Alat_model->get_alat($booking->alat_id);
    
    if (!$alat) {
        $this->session->set_flashdata('error', 'Data alat tidak ditemukan');
        redirect('dashboard/admin');
    }

    // Cek stok tersedia
    if ($alat->stok <= 0) {
        $this->session->set_flashdata('error', 'Stok alat sudah habis');
        redirect('dashboard/admin');
    }

    // Kurangi stok alat
    $new_stok = $alat->stok - 1;
    $this->Alat_model->update_stok($booking->alat_id, $new_stok);

    // Update status peminjaman
    if ($this->Booking_model->update_status($id, 'disetujui')) {
        $this->session->set_flashdata('success', 'Peminjaman disetujui dan stok berkurang');
    } else {
        $this->session->set_flashdata('error', 'Gagal menyetujui peminjaman');
    }

    redirect('dashboard/admin');
}

    public function reject($id)
    {
        if ($this->session->userdata('role') != 'admin') {
            show_404();
        }

        $this->Booking_model->update_status($id, 'ditolak');
        $this->session->set_flashdata('success', 'Booking ditolak');
        redirect('dashboard/admin');
    }

    public function complete($id)
{
    if ($this->session->userdata('role') != 'admin') {
        show_404();
    }

    $this->load->model(['Booking_model', 'Alat_model']);
    
    // Dapatkan data peminjaman
    $booking = $this->Booking_model->get_booking_by_id($id);
    
    if (!$booking) {
        $this->session->set_flashdata('error', 'Data peminjaman tidak ditemukan');
        redirect('dashboard/admin');
    }

    // Kembalikan stok alat
    $alat = $this->Alat_model->get_alat($booking->alat_id);
    $new_stok = $alat->stok + 1;
    $this->Alat_model->update_stok($booking->alat_id, $new_stok);

    // Update status peminjaman
    if ($this->Booking_model->update_status($id, 'selesai')) {
        $this->session->set_flashdata('success', 'Peminjaman selesai dan stok dikembalikan');
    } else {
        $this->session->set_flashdata('error', 'Gagal menyelesaikan peminjaman');
    }

    redirect('dashboard/admin');
}
}
?>