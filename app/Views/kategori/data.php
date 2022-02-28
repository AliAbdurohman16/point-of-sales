<?= $this->extend('layout/menu') ?>

<?= $this->section('judul') ?>
<h3><i class="fa fa-fw fa-table"></i> Manajemen Data Kategori</h3>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<section class="content">
    <div class="container-fluid">
        <!-- Main content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-sm btn-primary" id="buttonAdd">
                            <i class="fa fa-plus"></i> Tambah Data
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Kategori</th>
                                    <th width="10%">Opsi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $no = 1;
                                    foreach ($kategori as $k) {
                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $k['katnama']; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-outline-info btn-sm" onclick="edit('<?= $k['katid'] ?>')">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="hapus('<?= $k['katid'] ?>', '<?= $k['katnama'] ?>')">
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
<div class="viewmodal" style="display: none;"></div>

<script>
    function hapus(id, nama) {
        Swal.fire({
            title: 'Hapus Kategori!',
            html: `Anda yakin ingin menghapus nama kategori <strong>${nama}</strong> ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('kategori/hapus')?>",
                    data: { idkategori : id },
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

    function edit(id)
    {
        $.ajax({
            url: "<?= site_url('kategori/formEdit')?>",
            dataType: "json",
            data: { idkategori : id },
            success: function(response) {
                if(response.data){
                    $('.viewmodal').html(response.data).show();
                    $('#modalformedit').on('shown.bs.modal', function (event) {
                        $('#namakategori').focus();
                    });
                    $('#modalformedit').modal('show');
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            } 
        });
    }

    $(document).ready(function() {
        $('#buttonAdd').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('kategori/formTambah')?>",
                dataType: "json",
                type: "post",
                data: { aksi: 0 },
                success: function(response) {
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
    });
</script>

<?= $this->endSection() ?>