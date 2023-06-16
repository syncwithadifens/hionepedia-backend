<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>
<script src="assets/static/js/initTheme.js"></script>
<div id="app">

    <?= $this->include('layouts/sidebar') ?>

    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3><?= $title; ?></h3>
                        <p class="text-subtitle text-muted">
                            Di halaman ini memuat semua data hewan yang ditampilkan di aplikasi mobile.
                        </p>
                        <?php if (session()->getFlashdata('pesan')) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('pesan') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Data
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Thumbnail</th>
                                    <th>Sound</th>
                                    <th>Model</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($animal as $a) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $a['name']; ?></td>
                                        <td style="text-align: justify;"><?= $a['description']; ?></td>
                                        <td class="align-middle"><img src="/img/<?= $a['thumbnail']; ?>" alt="image" class="thumbnail"></td>
                                        <td class="align-middle"><?= $a['sound']; ?></td>
                                        <td class="align-middle"><?= $a['model']; ?></td>
                                        <td class="align-middle"><a href="/animal/<?= $a['slug']; ?>" class="btn btn-success">Detail</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>

        <?= $this->include('layouts/footer') ?>

    </div>
</div>
<?= $this->endSection(); ?>