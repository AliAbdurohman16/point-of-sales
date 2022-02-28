<script src="<?= base_url('assets/plugins/autoNumeric.js') ?>"></script>
<!-- Modal -->
<div class="modal fade" id="modalpembayaran" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalpembayaranLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalpembayaranLabel">Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <?= form_open('penjualan/simpanPembayaran', ['class' => 'formpembayaran']) ?>
            <div class="modal-body">
                <input type="hidden" name="nofaktur" value="<?= $nofaktur ?>">
                <input type="hidden" name="kopel" value="<?= $kopel ?>">
                <input type="hidden" name="totalkotor" id="totalkotor" value="<?= $totalbayar ?>">

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="">Disc(%)</label>
                            <input type="text" name="dispersen" id="dispersen" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="">Disc(Rp)</label>
                            <input type="text" name="disuang" id="disuang" class="form-control" autocomplete="off">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="">Total Pembayaran</label>
                    <input type="text" class="form-control form-control-lg" name="totalbersih" id="totalbersih" value="<?= $totalbayar ?>"
                        style="text-align: right; color:blue; font-weight : bold; font-size:24pt;" readonly>
                </div>
                
                <div class="form-group">
                    <label for="">Jumlah Uang</label>
                    <input type="text" class="form-control" name="jmluang" id="jmluang" autocomplete="off"
                        style="text-align: right; color:black; font-weight : bold; font-size:20pt;">
                </div>

                <div class="form-group">
                    <label for="">Sisa Uang</label>
                    <input type="text" class="form-control" name="sisauang" id="sisauang"
                        style="text-align: right; color:blue; font-weight : bold; font-size:24pt;" readonly>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success tombolSimpan">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        $('#dispersen').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '2'
        });

        $('#disuang').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });

        $('#totalbersih').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });

        $('#jmluang').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });

        $('#sisauang').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });

        $('#dispersen').keyup(function (e) { 
            hitungDiskon();
        });

        $('#disuang').keyup(function (e) { 
            hitungDiskon();
        });

        $('#jmluang').keyup(function (e) { 
            hitungSisaUang();
        });

        $('.formpembayaran').submit(function (e) { 
            e.preventDefault();
            
            let jmluang = ($('#jmluang').val() == "") ? 0 : $('#jmluang').autoNumeric('get');
            let sisauang = ($('#sisauang').val() == "") ? 0 : $('#sisauang').autoNumeric('get');

            if (parseFloat(jmluang) == 0 || parseFloat(jmluang) == "" ) {
                Toast.fire({
                    icon: 'warning',
                    title: 'Maaf jumlah uang belum di masukkan....'
                });
            } else if (parseFloat(sisauang) < 0) {
                Toast.fire({
                    icon: 'error',
                    title: 'Maaf jumlah uang belum mencukupi....'
                });
            } else {
                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function() {
                        $('.tombolSimpan').prop('disabled', true);
                        $('.tombolSimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        $('.tombolSimpan').html('Simpan');
                        $('.tombolSimpan').prop('disabled', false);
                    },
                    success: function (response) {
                        if (response.success == 'berhasil') {
                            Swal.fire({
                                title: 'Cetak Struk!',
                                html: 'Anda yakin ingin mencetak struk?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, Cetak!',
                                cancelButtonText: 'Tidak'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        type: "post",
                                        url: "<?= site_url('penjualan/cetakstruk')?>",
                                        data: {
                                            nofaktur: response.nofaktur
                                        },
                                        dataType: "json",
                                        success: function (response) {
                                            alert(response);
                                            location.reload();
                                        },
                                        error: function(xhr, thrownError) {
                                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                                        }
                                    });
                                } else {
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

            return false;
        });
    });

    function hitungDiskon() {
        let totalkotor = $('#totalkotor').val();
        let dispersen = ($('#dispersen').val() == "") ? 0 : $('#dispersen').autoNumeric('get');
        let disuang = ($('#disuang').val() == "") ? 0 : $('#disuang').autoNumeric('get');

        let hasil;
        hasil = parseFloat(totalkotor) - (parseFloat(totalkotor) * parseFloat(dispersen)/100) - parseFloat(disuang);

        $('#totalbersih').val(hasil);

        let totalbersih = $('#totalbersih').val();
        $('#totalbersih').autoNumeric('set', totalbersih);
    }

    function hitungSisaUang()
    {
        let totalpembayaran = $('#totalbersih').autoNumeric('get')
        let jmluang = ($('#jmluang').val() == "") ? 0 : $('#jmluang').autoNumeric('get');

        sisauang = parseFloat(jmluang) - parseFloat(totalpembayaran);

        $('#sisauang').val(sisauang);

        let sisauangx = $('#sisauang').val();
        $('#sisauang').autoNumeric('get', sisauangx);
    }
</script>