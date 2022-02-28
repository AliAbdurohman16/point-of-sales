<?php

namespace App\Controllers;

use App\Models\Modelkategori;

class Kategori extends BaseController
{
    public function __construct()
    {
        $this->kategori = new Modelkategori();
    }

    public function index()
    {
        $data = [
            'kategori' => $this->kategori->findAll()
        ];
        return view('kategori/data', $data);
    }

    function formTambah()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'aksi' => $this->request->getPost('aksi')
            ];

            $msg = [
                'data' => view('kategori/modalformtambah', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak ada halaman yang ditampilakn');
        }
    }

    function simpanData()
    {
        if ($this->request->isAJAX()) {

            $namakategori = $this->request->getVar('namakategori');
            
            $this->kategori->insert([
                'katnama' => $namakategori
            ]);
    
            $msg = [
                'success' => 'Kategori berhasil ditambahkan'
            ];
    
            echo json_encode($msg);
        }
    }

    function hapus()
    {
        if ($this->request->isAJAX()) {

            $idKategori = $this->request->getVar('idkategori');

            $this->kategori->delete($idKategori);

            $msg = [
                'success' => 'Kategori berhasil dihapus'
            ];
    
            echo json_encode($msg);
        }
    }

    function formEdit()
    {
        if ($this->request->isAJAX()) {
            $idKategori = $this->request->getVar('idkategori');

            $kategori = $this->kategori->find($idKategori);
            $data = [
                'idkategori' => $idKategori,
                'namakategori' => $kategori['katnama']
            ];

            $msg = [
                'data' => view('kategori/modalformedit', $data)
            ];

            echo json_encode($msg);
        }
    }

    function updateData()
    {
        if ($this->request->isAJAX()) {
            $idKategori = $this->request->getVar('idkategori');
            $namaKategori = $this->request->getVar('namakategori');

            $this->kategori->update($idKategori, [
                'katnama' => $namaKategori
            ]);

            $msg = [
                'success' => "Data kategori berhasil diubah"
            ];

            echo json_encode($msg);
        }
    }
}