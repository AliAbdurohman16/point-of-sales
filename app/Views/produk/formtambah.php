<?= $this->extend('layout/menu') ?>

<?= $this->section('judul') ?>
<h3><i class="fa fa-fw fa-plus"></i> Form Tambah Produk</h3>
<?= $this->endSection() ?>


<?= $this->section('isi') ?>
<script src="<?= base_url('assets/plugins/autoNumeric.js') ?>"></script>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <button type="button" class="btn btn-sm btn-warning"
                    onclick="window.location='<?= site_url('produk') ?>'">
                    <i class="fa fa-backward"></i> Kembali
                </button>
            </h3>
        </div>
        <div class="card-body">
            <?= form_open_multipart('', ['class' => 'formsimpanproduk']) ?>
            <?= csrf_field(); ?>
            <div class="form-group row">
                <label for="kodebarcode" class="col-sm-4 col-form-label">Kode Barcode</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm" id="kodebarcode" name="kodebarcode" autofocus>
                    <div class="invalid-feedback errorKodeBarcode" style="display: none;">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="namaproduk" class="col-sm-4 col-form-label">Nama Produk</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm" id="namaproduk" name="namaproduk">
                    <div class="invalid-feedback errorNamaProduk" style="display: none;">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="stok" class="col-sm-4 col-form-label">Stok Tersedia</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm" id="stok" name="stok" value="0">
                    <div class="invalid-feedback errorStok" style="display: none;">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="kategori" class="col-sm-4 col-form-label">Kategori</label>
                <div class="col-sm-4">
                    <select class="form-control form-control-sm" name="kategori" id="kategori">

                    </select>
                    <div class="invalid-feedback errorKategori" style="display: none;">
                    </div>
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-sm btn-primary tombolTambahKategori">
                        <i class="fa fa-plus-circle"></i>
                    </button>
                </div>
            </div>
            <div class="form-group row">
                <label for="satuan" class="col-sm-4 col-form-label">Satuan</label>
                <div class="col-sm-4">
                    <select class="form-control form-control-sm" name="satuan" id="satuan">

                    </select>
                    <div class="invalid-feedback errorSatuan" style="display: none;">
                    </div>
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-sm btn-primary tombolTambahSatuan">
                        <i class="fa fa-plus-circle"></i>
                    </button>
                </div>
            </div>
            <div class="form-group row">
                <label for="hargabeli" class="col-sm-4 col-form-label">Harga Beli (Rp)</label>
                <div class="col-sm-4">
                    <input style="text-align: right;" type="text" class="form-control form-control-sm" name="hargabeli"
                        id="hargabeli">
                    <div class="invalid-feedback errorHargaBeli" style="display: none;">
                    </div>
                </div>

            </div>
            <div class="form-group row">
                <label for="hargajual" class="col-sm-4 col-form-label">Harga Jual (Rp)</label>
                <div class="col-sm-4">
                    <input style="text-align: right;" type="text" class="form-control form-control-sm" name="hargajual"
                        id="hargajual">
                    <div class="invalid-feedback errorHargaJual" style="display: none;">
                    </div>
                </div>

            </div>
            <div class="form-group row">
                <label for="uploadgambar" class="col-sm-4 col-form-label">Upload Gambar (Jika Ada)</label>
                <div class="col-sm-4">
                    <input type="file" name="uploadgambar" id="uploadgambar" class="form-control form-control-md"
                        accept=".jpg,.jpeg,.png">
                    <div class="invalid-feedback errorUploadGambar" style="display: none;">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="uploadgambar" class="col-sm-4 col-form-label"></label>
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-success tombolSimpanProduk">
                        Simpan
                    </button>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<div class="viewmodal" style="display:none;"></div>
<script>
    function tampilKategori()
    {
        $.ajax({
            url: "<?= site_url('produk/getDataKategori') ?>",
            dataType: "json",
            success: function (response) {
              if (response.data) {
                  $('#kategori').html(response.data)
              }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function tampilSatuan() {
        $.ajax({
            url: "<?= site_url('produk/getDataSatuan') ?>",
            dataType: "json",
            success: function (response) {
              if (response.data) {
                  $('#satuan').html(response.data)
              }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $(document).ready(function () {
        tampilKategori();

        $('.tombolTambahKategori').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('kategori/formTambah') ?>",
                dataType: "json",
                type: "post",
                data: { aksi: 1 },
                success: function (response) {
                    if(response.data){
                        $('.viewmodal').html(response.data).show();
                        $('#modaltambahkategori').on('shown.bs.modal', function (event) {
                            $('#namakategori').focus();
                        });
                        $('#modaltambahkategori').modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        tampilSatuan();

        $('.tombolTambahSatuan').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('satuan/formTambah')?>",
                dataType: "json",
                type: "post",
                data: { aksi: 1 },
                success: function(response) {
                    if(response.data){
                        $('.viewmodal').html(response.data).show();
                        $('#modaltambahsatuan').on('shown.bs.modal', function (event) {
                            $('#namasatuan').focus();
                        });
                        $('#modaltambahsatuan').modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                } 
            });
        })

        $('#hargabeli').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '2'
        });

        $('#hargajual').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });

        $('#stok').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });


        $('.tombolSimpanProduk').click(function (e) {
            e.preventDefault();

            let form = $('.formsimpanproduk')[0];

            let data = new FormData(form);

            $.ajax({
                type: "post",
                url: "<?= site_url('produk/simpandata') ?>",
                data: data,
                dataType: "json",
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('.tombolSimpanProduk').html('<i class="fa fa-spin fa-spinner"></i>');
                    $('.tombolSimpanProduk').prop('disabled', true);
                },
                complete: function() {
                    $('.tombolSimpanProduk').html('Simpan');
                    $('.tombolSimpanProduk').prop('disabled', false);
                },
                success: function (response) {
                    if (response.error) {
                        let dataError = response.error;
                        if (dataError.errorKodeBarcode) {
                            $('.errorKodeBarcode').html(dataError.errorKodeBarcode).show();
                            $('#kodebarcode').addClass('is-invalid');
                        } else {
                            $('.errorKodeBarcode').fadeOut();
                            $('#kodebarcode').removeClass('is-invalid');
                            $('#kodebarcode').addClass('is-valid');
                        }

                        if (dataError.errorNamaProduk) {
                            $('.errorNamaProduk').html(dataError.errorNamaProduk).show();
                            $('#namaproduk').addClass('is-invalid');
                        } else {
                            $('.errorNamaProduk').fadeOut();
                            $('#namaproduk').removeClass('is-invalid');
                            $('#namaproduk').addClass('is-valid');
                        }

                        if (dataError.errorKategori) {
                            $('.errorKategori').html(dataError.errorKategori).show();
                            $('#kategori').addClass('is-invalid');
                        } else {
                            $('.errorKategori').fadeOut();
                            $('#kategori').removeClass('is-invalid');
                            $('#kategori').addClass('is-valid');
                        }

                        if (dataError.errorSatuan) {
                            $('.errorSatuan').html(dataError.errorSatuan).show();
                            $('#satuan').addClass('is-invalid');
                        } else {
                            $('.errorSatuan').fadeOut();
                            $('#satuan').removeClass('is-invalid');
                            $('#satuan').addClass('is-valid');
                        }

                        if (dataError.errorHargaJual) {
                            $('.errorHargaJual').html(dataError.errorHargaJual).show();
                            $('#hargajual').addClass('is-invalid');
                        } else {
                            $('.errorHargaJual').fadeOut();
                            $('#hargajual').removeClass('is-invalid');
                            $('#hargajual').addClass('is-valid');
                        }

                        if (dataError.errorUploadGambar) {
                            $('.errorUploadGambar').html(dataError.errorUploadGambar).show();
                            $('#uploadgambar').addClass('is-invalid');
                        }
                    } else {
                        $('.errorKodeBarcode').fadeOut();
                        $('#kodebarcode').removeClass('is-invalid');
                        $('#kodebarcode').addClass('is-valid');

                        $('.errorNamaProduk').fadeOut();
                        $('#namaproduk').removeClass('is-invalid');
                        $('#namaproduk').addClass('is-valid');
                        
                        $('#stok').addClass('is-valid');

                        $('.errorKategori').fadeOut();
                        $('#kategori').removeClass('is-invalid');
                        $('#kategori').addClass('is-valid');

                        $('.errorSatuan').fadeOut();
                        $('#satuan').removeClass('is-invalid');
                        $('#satuan').addClass('is-valid');

                        $('#hargabeli').addClass('is-valid');

                        $('.errorHargaJual').fadeOut();
                        $('#hargajual').removeClass('is-invalid');
                        $('#hargajual').addClass('is-valid');

                        $('.errorUploadGambar').fadeOut();
                        $('#uploadgambar').removeClass('is-invalid');
                        $('#uploadgambar').addClass('is-valid');

                        Swal.fire(
                            'Berhasil',
                            response.success,
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        })
    })
</script>
<?= $this->endSection() ?>