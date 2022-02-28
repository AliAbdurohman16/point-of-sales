<!-- Modal -->
<div class="modal fade" id="modalproduk" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalprodukLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalprodukLabel">Data Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="keywordkode" id="keywordkode" value="<?= $keyword; ?>">
                <table id="example1" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barcode</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Harga Jual</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready( function () {
        var table = $('#example1').DataTable({ 
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= site_url('penjualan/listDataProduk')?>",
                "type": "POST",
                "data": {
                    keywordkode : $('#keywordkode').val()
                }
            },
            "columnDefs": [
                { 
                    "targets": [],
                    "orderable": false,
                },
            ],
        });
    });

    function pilihitem(kode, nama) {
        $('#kodebarcode').val(kode);
        $('#namaproduk').val(nama);
        $('#modalproduk').on('hidden.bs.modal', function (event) {
            $('#kodebarcode').focus();
            cekKode();
        });
        $('#modalproduk').modal('hide');
    }
</script>