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
                        <h3>Form Layout</h3>
                        <p class="text-subtitle text-muted">
                            Multiple form layouts, you can use.
                        </p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Form Layout
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Basic Vertical form layout section start -->
            <section id="basic-vertical-layouts">
                <div class="row match-height">
                    <div class=" col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Vertical Form with Icons</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form form-vertical" action="/animal" method="post" enctype="multipart/form-data">
                                        <?= csrf_field(); ?>
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group has-icon-left">
                                                        <label for="first-name-icon">Nama Hewan</label>
                                                        <div class="position-relative">
                                                            <input type="text" name="name" class="form-control <?= (session('validation') && session('validation')->hasError('name')) ? 'is-invalid' : ''; ?>" placeholder="Nama hewan langka" id="first-name-icon" value="<?= old('name'); ?>" />
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-person"></i>
                                                            </div>
                                                            <?php if (session('validation') && session('validation')->hasError('name')) : ?>
                                                                <div class="invalid-feedback">
                                                                    <?= session('validation')->getError('name'); ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group has-icon-left">
                                                        <label for="email-id-icon">Deskripsi</label>
                                                        <div class="position-relative">
                                                            <input type="text" name="description" class="form-control <?= (session('validation') && session('validation')->hasError('description')) ? 'is-invalid' : ''; ?>" placeholder="Deskripsi mengenai hewan" id="email-id-icon" value="<?= old('description'); ?>" />
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-blockquote-left"></i>
                                                            </div>
                                                            <?php if (session('validation') && session('validation')->hasError('description')) : ?>
                                                                <div class="invalid-feedback">
                                                                    <?= session('validation')->getError('description'); ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-3">
                                                    <label for="thumbnail" class="col-sm-2 col-form-label" id="thumbnailLabel">Thumbnail</label>
                                                    <div class="col-sm-8 input-group mb-3">
                                                        <input type="file" class="form-control" name="thumbnail" id="thumbnail" aria-describedby="thumbnail" onchange="previewImg()">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <img src="/img/default_thumbnail.jpg" alt="..." class="img-thumbnail img-preview">
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-3">
                                                    <label for="sound" class="col-sm-2 col-form-label" id="soundLabel">Sound</label>
                                                    <div class="col-sm-8 input-group mb-3">
                                                        <input type="file" class="form-control" name="sound" id="sound" aria-describedby="sound">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <label for="model" class="col-sm-2 col-form-label" id="modelLabel">Model</label>
                                                    <div class="col-sm-8 input-group mb-3">
                                                        <input type="file" class="form-control" name="model" id="model" aria-describedby="model">
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary me-1 mb-1">
                                                        Submit
                                                    </button>
                                                    <input type="reset" class="btn btn-light-secondary me-1 mb-1"></input>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- // Basic Vertical form layout section end -->
        </div>

        <?= $this->include('layouts/footer') ?>

    </div>
</div>
<?= $this->endSection(); ?>