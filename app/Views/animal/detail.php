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
                        <h3>Card</h3>
                        <p class="text-subtitle text-muted">
                            Bootstrap’s cards provide a flexible and extensible content
                            container with multiple variants and options.
                        </p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Card
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- Basic card section start -->
            <section id="content-types">
                <div class="row">

                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-content">
                                <img class="card-img-top img-fluid" src="/img/<?= $animal['thumbnail']; ?>" alt="Card image cap" style="height: 20rem; object-fit: contain;" />
                                <div class="card-body">
                                    <h4 class="card-title"><?= $animal['name']; ?></h4>
                                    <p class="card-text">
                                        <?= $animal['description']; ?>
                                    </p>
                                    <p class="card-text">
                                        sound: <?= $animal['sound']; ?>
                                    </p>
                                    <p class="card-text">
                                        model: <?= $animal['model']; ?>
                                    </p>
                                    <a href="/animal/<?= $animal['slug']; ?>/edit" class="btn btn-warning">Ubah</a>
                                    <form action="/animal/<?= $animal['animal_id']; ?>" method="post" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda ingin menghapus?');">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?= $this->include('layouts/footer') ?>

                </div>
        </div>
        <?= $this->endSection(); ?>