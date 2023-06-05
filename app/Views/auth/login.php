<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>
<script src="assets/static/js/initTheme.js"></script>
<div id="auth">
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <h1 class="auth-title">Log in.</h1>
                <p class="auth-subtitle mb-5">
                    Log in with your data that you entered during registration.
                </p>

                <form action="/login" method="post">
                    <?= csrf_field(); ?>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" class="form-control form-control-xl <?= (session('validation') && session('validation')->hasError('username')) ? 'is-invalid' : ''; ?>" placeholder="Username" name="username" value="<?= old('username'); ?>" />
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        <?php if (session('validation') && session('validation')->hasError('username')) : ?>
                            <div class="invalid-feedback">
                                <?= session('validation')->getError('username'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" class="form-control form-control-xl <?= (session('validation') && session('validation')->hasError('pin')) ? 'is-invalid' : ''; ?>" placeholder="Password" name="pin" value="<?= old('pin'); ?>" />
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <?php if (session('validation') && session('validation')->hasError('pin')) : ?>
                            <div class="invalid-feedback">
                                <?= session('validation')->getError('pin'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('pesan') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
                        Log in
                    </button>
                </form>
                <div class="text-center mt-5 text-lg fs-3">
                    <p class="text-gray-600">
                        Don't have an account?
                        <a href="/register" class="font-bold">Sign up</a>.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right"></div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>