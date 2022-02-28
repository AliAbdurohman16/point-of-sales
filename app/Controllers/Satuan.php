<?php

namespace App\Controllers;

use App\Models\Modelsatuan;
use App\Models\Modeldatasatuan;
use Config\Services;

class Satuan extends BaseController
{
    public function __construct()
    {
        $this->satuan = new Modelsatuan();
    }
    public function index()
    {
        $data = [
            'satuan' => $this->satuan->findAll()
        ];
        return view('satuan/data', $data);
    }

    function formTambah()
    {
        if ($this->request->isAJAX()) {
            $aksi = $this->request->getPost('aksi');
            $msg = [
                'data' => view('satuan/modalformtambah', ['aksi' => $aksi])
            ];
            echo json_encode($msg);
        }
    }

    function simpandata()
    {
        if ($this->request->isAJAX()) {
            $namasatuan = $this->request->getVar('namasatuan');

            $this->satuan->insert([
                'satnama' => $namasatuan
            ]);

            $msg = [
                'success' => 'Satuan berhasil ditambahkan'
            ];
            echo json_encode($msg);
        }
    }
    function hapus()
    {
        if ($this->request->isAJAX()) {
            $idSatuan = $this->request->getVar('idsatuan');

            $this->satuan->delete($idSatuan);

            $msg = [
                'success' => 'Satuan berhasil dihapus'
            ];
            echo json_encode($msg);
        }
    }

    function formEdit()
    {
        if ($this->request->isAJAX()) {
            $idsatuan =  $this->request->getVar('idsatuan');

            $satuan = $this->satuan->find($idsatuan);
            $data = [
                'idsatuan' => $idsatuan,
                'namasatuan' => $satuan['satnama']
            ];

            $msg = [
                'data' => view('satuan/modalformedit', $data)
            ];
            echo json_encode($msg);
        }
    }

    function updatedata()
    {
        if ($this->request->isAJAX()) {
            $idSatuan = $this->request->getVar('idsatuan');
            $namaSatuan = $this->request->getVar('namasatuan');

            $this->satuan->update($idSatuan, [
                'satnama' => $namaSatuan
            ]);

            $msg = [
                'success' =>  'Data satuan berhasil diubah'
            ];
            echo json_encode($msg);
        }
    }
}