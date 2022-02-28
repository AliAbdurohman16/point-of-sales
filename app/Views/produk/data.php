<?= $this->extend('layout/menu') ?>

<?= $this->section('judul') ?>
<h3><i class="fa fa-fw fa-table"></i> Manajemen Data Produk</h3>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<section class="content">
    <div class="container-fluid">
        <!-- Main content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-sm btn-primary" onclick="window.location = '<?= site_url('produk/add') ?>'">
                            <i class="fa fa-plus"></i> Tambah Data
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Kode Barcode</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Satuan</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Stok</th>
                                    <th width="10%">Opsi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $no = 1;
                                    foreach ($dataproduk as $dp) {
                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $dp['kodebarcode']; ?></td>
                                    <td><?= $dp['namaproduk']; ?></td>
                                    <td><?= $dp['katnama']; ?></td>
                                    <td><?= $dp['satnama']; ?></td>
                                    <td><?= number_format($dp['harga_beli'], 2, ",", "."); ?></td>
                                    <td><?= number_format($dp['harga_jual'], 2, ",", "."); ?></td>
                                    <td><?= number_format($dp['stok_tersedia'], 0, ",", "."); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-outline-info btn-sm" onclick="window.location = '/produk/edit/<?= $dp['kodebarcode'] ?>'">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="hapus('<?= $dp['kodebarcode'] ?>', '<?= $dp['namaproduk'] ?>')">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
</section>
<!-- /.content -->
<script>
    function hapus(id, nama) {
        Swal.fire({
            title: 'Hapus Satuan!',
            html: `Anda yakin ingin menghapus nama produk <strong>${nama}</strong> ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('produk/hapus')?>",
                    data: { kodebarcode : id },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Berhasil!',
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
                });
            }
        });
    }
</script>

<?= $this->endSection() ?>