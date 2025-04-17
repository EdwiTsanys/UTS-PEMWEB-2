<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alat extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
        $this->load->model('Alat_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['alat'] = $this->Alat_model->get_all_alat();
        $this->load->view('templates/header');
        $this->load->view('templates/navbar');
        $this->load->view('alat/index', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/navbar');
        $this->load->view('alat/create');
        $this->load->view('templates/footer');
    }

    public function store()
    {
        $this->form_validation->set_rules('nama_alat', 'Nama Alat', 'required');
        $this->form_validation->set_rules('stok', 'Stok', 'required|numeric');
        
        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            $data = [
                'nama_alat' => $this->input->post('nama_alat'),
                'deskripsi' => $this->input->post('deskripsi'),
                'stok' => $this->input->post('stok'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $this->Alat_model->create_alat($data);
            $this->session->set_flashdata('success', 'Alat berhasil ditambahkan');
            redirect('alat');
        }
    }

    public function edit($id)
    {
        $data['alat'] = $this->Alat_model->get_alat($id);
        $this->load->view('templates/header');
        $this->load->view('templates/navbar');
        $this->load->view('alat/edit', $data);
        $this->load->view('templates/footer');
    }

    public function update($id)
    {
        $this->form_validation->set_rules('nama_alat', 'Nama Alat', 'required');
        $this->form_validation->set_rules('stok', 'Stok', 'required|numeric');
        
        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
        } else {
            $data = [
                'nama_alat' => $this->input->post('nama_alat'),
                'deskripsi' => $this->input->post('deskripsi'),
                'stok' => $this->input->post('stok')
            ];
            
            $this->Alat_model->update_alat($id, $data);
            $this->session->set_flashdata('success', 'Alat berhasil diperbarui');
            redirect('alat');
        }
    }

    public function delete($id)
    {
        $this->Alat_model->delete_alat($id);
        $this->session->set_flashdata('success', 'Alat berhasil dihapus');
        redirect('alat');
    }
}
?>