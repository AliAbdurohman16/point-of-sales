<table class="table table-striped table-sm table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Produk</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Sub Total</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $no = 1;
            foreach ($datadetail->getResultArray() as $r) {
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $r['kode']; ?></td>
            <td><?= $r['namaproduk']; ?></td>
            <td><?= number_format($r['qty'], 0, ",", "."); ?></td>
            <td><?= number_format($r['harga'], 0, ",", "."); ?></td>
            <td><?= number_format($r['subtotal'], 0, ",", "."); ?></td>
            <td>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="hapusItem('<?= $r['id'] ?>', '<?= $r['namaproduk'] ?>')">
                    <i class="fa fa-trash-alt"></i>
                </button>
            </td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>

<script>
    function hapusItem(id, nama)
    {
        Swal.fire({
            title: 'Hapus Data!',
            html: `Anda yakin ingin menghapus data produk <strong>${nama}</strong> ini?`,
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
                    url: "<?= site_url('penjualan/hapusItem')?>",
                    data: { id : id },
                    dataType: "json",
                    success: function(response) {
                        if (response.success == 'berhasil') {
                            dataDetailPenjualan();
                            kosong();
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