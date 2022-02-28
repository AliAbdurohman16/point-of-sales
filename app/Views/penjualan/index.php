<?= $this->extend('layout/menu') ?>

<?= $this->section('judul') ?>
<h3><h3><i class="fa fa-fw fa-list"></i> Menu Penjualan</h3>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h4>Input</h4>
                    <h2>Kasir</h2>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <a href="<?= site_url('penjualan/input') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h4>Data</h4>
                    <h2>Penjualan</h2>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <a href="<?= site_url('penjualan/data') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>