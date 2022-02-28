<?= $this->extend('layout/menu') ?>

<?= $this->section('judul') ?>
<h3><i class="fa fa-fw fa-table"></i> Manajemen Kasir</h3>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>

<div class="card card-default color-palette-box">
    <div class="card-header">
        <h3 class="card-title">
            <button type="button" class="btn btn-warning btn-sm" onclick="window.location='<?= site_url('penjualan/index') ?>'">
            <i class="fa fa-backward"></i> Kembali</button>
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="nofaktur">Faktur</label>
                    <input type="text" class="form-control form-control-sm" style="font-weight:bold;"
                        name="nofaktur" id="nofaktur" value="<?= $nofaktur; ?>" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control form-control-sm" style="font-weight:bold;" name="tanggal" id="tanggal" readonly
                        value="<?= date('Y-m-d'); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="napel">Pelanggan</label>
                    <div class="input-group mb-3">
                        <input type="text" value="-" class="form-control form-control-sm" name="napel" id="napel"
                            readonly>
                        <input type="hidden" name="kopel" id="kopel" value="0">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-primary" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="tanggal">Aksi</label>
                    <div class="input-group">
                        <button class="btn btn-danger btn-sm" type="button" id="btnHapusTransaksi">
                            <i class="fa fa-trash-alt"></i>
                        </button>&nbsp;
                        <button class="btn btn-success" type="button" id="btnSimpanTransaksi">
                            <i class="fa fa-save"></i>
                        </button>&nbsp;
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="kodebarcode">Kode Produk</label>
                    <input type="text" class="form-control form-control-sm" name="kodebarcode" id="kodebarcode"
                        autofocus>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Nama Produk</label>
                    <input type="text" class="form-control form-control-sm" style="font-weight : bold;" name="namaproduk" id="namaproduk" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="jml">Jumlah</label>
                    <input type="number" class="form-control form-control-sm" name="jumlah" id="jumlah" value="1">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="jml">Total Bayar</label>
                    <input type="text" class="form-control form-control-lg" name="totalbayar" id="totalbayar"
                        style="text-align: right; color:blue; font-weight : bold; font-size:30pt;" value="0" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 dataDetailPenjualan">
 
            </div>
        </div>
    </div>
</div>
<div class="viewmodal" style="display:none;"></div>

<script>
    $(document).ready(function() {
        $('body').addClass('sidebar-collapse');

        dataDetailPenjualan();
        hitungTotalBayar();

        $('#kodebarcode').keydown(function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                cekKode();
            }
        });

        $('#btnHapusTransaksi').click(function (e) { 
            e.preventDefault();
            batalTransaksi();
        });

        $('#btnSimpanTransaksi').click(function (e) { 
            e.preventDefault();
            pembayaran();
        });

        $('#jumlah').keydown(function (e) { 
            if (e.keyCode == 27) {
                e.preventDefault();
                $('#kodebarcode').focus();
            }
        });

        $(this).keydown(function (e) { 
            if (e.keyCode == 27) {
                e.preventDefault();
                $('#kodebarcode').focus();
            }

            if (e.keyCode == 115) {
                e.preventDefault();
                batalTransaksi();
            }

            if (e.keyCode == 119) {
                e.preventDefault();
                pembayaran();
            }
        });
    })

    function dataDetailPenjualan() {
        $.ajax({
            type: "post",
            url: "<?= site_url('penjualan/dataDetail') ?>",
            data: {
                nofaktur : $('#nofaktur').val()
            },
            dataType: "json",
            beforeSend: function() {
                $('.dataDetailPenjualan').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            success: function (response) {
                if (response.data) {
                    $('.dataDetailPenjualan').html(response.data);
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function cekKode()
    {
        let kode = $('#kodebarcode').val();

        if (kode.length == 0) {
            $.ajax({
                url: "<?= site_url('penjualan/viewDataProduk') ?>",
                dataType: "json",
                success: function (response) {
                    $('.viewmodal').html(response.viewmodal).show();
                    $('#modalproduk').modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        } else {
            $.ajax({
                type: "post",
                url: "<?= site_url('penjualan/simpanTemp'); ?>",
                data: {
                    kodebarcode : kode,
                    namaproduk : $('#namaproduk').val(),
                    jumlah : $('#jumlah').val(),
                    nofaktur : $('#nofaktur').val()
                },
                dataType: "json",
                success: function (response) {
                    if (response.total == 'banyak') {
                        $.ajax({
                            url: "<?= site_url('penjualan/viewDataProduk') ?>",
                            data : {
                                keyword : kode
                            },
                            dataType: "json",
                            type: "post",
                            success: function (response) {
                                $('.viewmodal').html(response.viewmodal).show();
                                $('#modalproduk').modal('show');
                            },
                            error: function(xhr, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }
                        });
                    }

                    if (response.sukses == 'berhasil') {
                        dataDetailPenjualan();
                        kosong();
                    }

                    if (response.error) {
                        Swal.fire(
                            'Gagal!',
                            response.error,
                            'error'
                        )
                        dataDetailPenjualan();
                        kosong();
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        }
    }

    function kosong()
    {
        $('#kodebarcode').val('');
        $('#namaproduk').val('');
        $('#jumlah').val('1');
        $('#kodebarcode').focus();

        hitungTotalBayar();
    }

    function hitungTotalBayar()
    {
        $.ajax({
            url: "<?= site_url('penjualan/hitungTotalBayar') ?>",
            data : {
                nofaktur : $('#nofaktur').val()
            },
            dataType: "json",
            type: "post",
            success: function (response) {
                if (response.totalbayar) {
                    $('#totalbayar').val(response.totalbayar);
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function batalTransaksi()
    {
        Swal.fire({
            title: 'Batal Transaksi!',
            html: "Anda yakin ingin membatalkan transaksi?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Batal!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('penjualan/batalTransaksi')?>",
                    data: { 
                        nofaktur : $('#nofaktur').val() 
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success == 'berhasil') {
                            location.reload();
                        }
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        });
    }

    function pembayaran() {
        let nofaktur = $('#nofaktur').val();

        $.ajax({
            type: "post",
            url: "<?= site_url('penjualan/pembayaran') ?>",
            data: {
                nofaktur: nofaktur,
                tanggal: $('#tanggal').val(),
                kopel: $('#kopel').val(),
            },
            dataType: "json",
            success: function (response) {
                if (response.error) {
                    Swal.fire(
                        'Maaf!',
                        response.error,
                        'warning'
                    )
                }

                if(response.data)
                {
                    $('.viewmodal').html(response.data).show();
                    $('#modalpembayaran').on('shown.bs.modal', function (event) {
                        $('#jmluang').focus();
                    });
                    $('#modalpembayaran').modal('show');
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
</script>
<?= $this->endSection() ?>