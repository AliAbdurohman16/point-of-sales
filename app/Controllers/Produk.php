<?php

namespace App\Controllers;

use App\Models\Modelproduk;
use App\Models\Modelkategori;
use App\Models\Modelsatuan;

class Produk extends BaseController
{
    public function __construct()
    {
        $this->produk = new Modelproduk();
        $this->kategori = new Modelkategori();
        $this->satuan = new Modelsatuan();
    }
    public function index()
    {
        $query = $this->produk
                ->join('kategori', 'produk_katid=katid')
                ->join('satuan', 'produk_satid=satid')
                ->paginate(10, 'produk');
        
        $data = [
            'dataproduk' => $query
        ];
        return view('produk/data', $data);
    }

    public function add()
    {
        return view('produk/formtambah');
    }

    public function getDataKategori()
    {
        if ($this->request->isAJAX()) {
            $datakategori = $this->kategori->findAll();

            $isidata = "<option value='' selected>--Pilih--</option>";

            foreach ($datakategori as $dk) {
                $isidata .= '<option value="' . $dk['katid'] . '">' . $dk['katnama'] . '</option>';
            }

            $msg = [
                'data' => $isidata
            ];

            echo json_encode($msg);
        }
    }

    public function getDataSatuan()
    {
        if ($this->request->isAJAX()) {
            $datasatuan = $this->satuan->findAll();

            $isidata = "<option value='' selected>--Pilih--</option>";

            foreach ($datasatuan as $ds) {
                $isidata .= '<option value="' . $ds['satid'] . '">' . $ds['satnama'] . '</option>';
            }

            $msg = [
                'data' => $isidata
            ];

            echo json_encode($msg);
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $kode = $this->request->getVar('kodebarcode');
            $nama = $this->request->getVar('namaproduk');
            $stok = str_replace( ',', '', $this->request->getVar('stok'));
            $kategori = $this->request->getVar('kategori');
            $satuan = $this->request->getVar('satuan');
            $beli = str_replace( ',', '', $this->request->getVar('hargabeli'));
            $jual = str_replace( ',', '', $this->request->getVar('hargajual'));

            $validation = \Config\Services::validation();

            $doValid = $this->validate([
                'kodebarcode' => [
                    'label' => 'Kode Barcode',
                    'rules' => 'required|is_unique[produk.kodebarcode]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'is_unique' => '{field} sudah ada!'
                    ]
                ],
                'namaproduk' => [
                    'label' => 'Nama Produk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'kategori' => [
                    'label' => 'Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'satuan' => [
                    'label' => 'Satuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'hargajual' => [
                    'label' => 'Harga Jual',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'uploadgambar' => [
                    'label' => 'Upload Gambar',
                    'rules' => 'mime_in[uploadgambar,image/png,image/jpg,image/jpeg]|ext_in[uploadgambar,png,jpg,jpeg]|is_image[uploadgambar]'
                ]
            ]);

            if (!$doValid) {
                $msg = [
                    'error' => [
                        'errorKodeBarcode' => $validation->getError('kodebarcode'),
                        'errorNamaProduk' => $validation->getError('namaproduk'),
                        'errorKategori' => $validation->getError('kategori'),
                        'errorSatuan' => $validation->getError('satuan'),
                        'errorHargaJual' => $validation->getError('hargajual'),
                        'errorUploadGambar' => $validation->getError('uploadgambar')
                    ]
                ];
            } else {
                $fileUploadGambar = $_FILES['uploadgambar']['name'];

                if ($fileUploadGambar != NULL) {
                    $namaFileGambar = "$kode-$nama";
                    $fileGambar = $this->request->getFile('uploadgambar');
                    $fileGambar->move('assets/upload', $namaFileGambar . '.' .$fileGambar->getExtension());

                    $pathGambar = $fileGambar->getName();
                } else {
                    $pathGambar = '';
                }

                $this->produk->insert([
                    'kodebarcode' => $kode,
                    'namaproduk' => $nama,
                    'produk_katid' => $kategori,
                    'produk_satid' => $satuan,
                    'stok_tersedia' => $stok,
                    'harga_beli' => $beli,
                    'harga_jual' => $jual,
                    'gambar' => $pathGambar
                ]);

                $msg = [
                    'success' => 'Produk berhasil ditambahkan!'
                ];
            }

            echo json_encode($msg);
        }
    }
    
    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('kodebarcode');

            $del = $this->produk->delete($id);

            $msg = [
                'success' => 'Produk berhasil dihapus'
            ];
    
            echo json_encode($msg);
        }
    }

    public function edit($id)
    {
        $produk = $this->produk->find($id);

        if ($produk) {
            $data = [
                'barcode' => $produk['kodebarcode'],
                'nama' => $produk['namaproduk'],
                'stok' => $produk['stok_tersedia'],
                'kategori' => $produk['produk_katid'],
                'datakategori' => $this->kategori->findAll(),
                'satuan' => $produk['produk_satid'],
                'datasatuan' => $this->satuan->findAll(),
                'hargabeli' => $produk['harga_beli'],
                'hargajual' => $produk['harga_jual'],
                'gambar' => $produk['gambar']
            ];

            return view('produk/formedit', $data);
        } else {
            exit('Data tidak ditemukan');
        }
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $kode = $this->request->getVar('kodebarcode');
            $nama = $this->request->getVar('namaproduk');
            $stok = str_replace( ',', '', $this->request->getVar('stok'));
            $kategori = $this->request->getVar('kategori');
            $satuan = $this->request->getVar('satuan');
            $beli = str_replace( ',', '', $this->request->getVar('hargabeli'));
            $jual = str_replace( ',', '', $this->request->getVar('hargajual'));

            $validation = \Config\Services::validation();

            $doValid = $this->validate([
                'namaproduk' => [
                    'label' => 'Nama Produk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'hargajual' => [
                    'label' => 'Harga Jual',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!'
                    ]
                ],
                'uploadgambar' => [
                    'label' => 'Upload Gambar',
                    'rules' => 'mime_in[uploadgambar,image/png,image/jpg,image/jpeg]|ext_in[uploadgambar,png,jpg,jpeg]|is_image[uploadgambar]'
                ]
            ]);

            if (!$doValid) {
                $msg = [
                    'error' => [
                        'errorNamaProduk' => $validation->getError('namaproduk'),
                        'errorHargaJual' => $validation->getError('hargajual'),
                        'errorUploadGambar' => $validation->getError('uploadgambar')
                    ]
                ];
            } else {
                $fileUploadGambar = $_FILES['uploadgambar']['name'];

                $dataProduk = $this->produk->find($kode);

                if ($fileUploadGambar != NULL) {
                    if ($dataProduk['gambar'] == "") {
                        $namaFileGambar = "$kode-$nama";
                        $fileGambar = $this->request->getFile('uploadgambar');
                        $fileGambar->move('assets/upload', $namaFileGambar . '.' .$fileGambar->getExtension());
    
                        $pathGambar = $fileGambar->getName();
                    }else {
                        unlink('assets/upload/' . $dataProduk['gambar']);
                        $namaFileGambar = "$kode-$nama";
                        $fileGambar = $this->request->getFile('uploadgambar');
                        $fileGambar->move('assets/upload', $namaFileGambar . '.' .$fileGambar->getExtension());
    
                        $pathGambar = $fileGambar->getName();
                    }
                } else {
                    $pathGambar = $dataProduk['gambar'];
                }

                $this->produk->update($kode, [
                    'namaproduk' => $nama,
                    'produk_katid' => $kategori,
                    'produk_satid' => $satuan,
                    'stok_tersedia' => $stok,
                    'harga_beli' => $beli,
                    'harga_jual' => $jual,
                    'gambar' => $pathGambar
                ]);

                $msg = [
                    'success' => 'Produk berhasil diubah!'
                ];
            }

            echo json_encode($msg);
        }
    }
}