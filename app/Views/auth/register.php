<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>
<script src="assets/static/js/initTheme.js"></script>
<div class="container my-5">
    <div class="row h-100">
        <div class="col-8 ">
            <h1 class="auth-title">Sign Up</h1>
            <p class="auth-subtitle mb-5">
                Input your data to register to our website.
            </p>
            <form action="/register" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="text" name="username" class="form-control form-control-xl <?= (session('validation') && session('validation')->hasError('username')) ? 'is-invalid' : ''; ?>" placeholder="Username" value="<?= old('username'); ?>" />
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
                    <input type="password" name="pin" class="form-control form-control-xl <?= (session('validation') && session('validation')->hasError('pin')) ? 'is-invalid' : ''; ?>" placeholder="Pin" value="<?= old('pin'); ?>" />
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <?php if (session('validation') && session('validation')->hasError('pin')) : ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('pin'); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="number" name="age" class="form-control form-control-xl <?= (session('validation') && session('validation')->hasError('age')) ? 'is-invalid' : ''; ?>" placeholder="Umur" value="<?= old('age'); ?>" />
                    <div class="form-control-icon">
                        <i class="bi bi-calendar-date"></i>
                    </div>
                    <?php if (session('validation') && session('validation')->hasError('age')) : ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('age'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="text" name="hobby" class="form-control form-control-xl <?= (session('validation') && session('validation')->hasError('hobby')) ? 'is-invalid' : ''; ?>" placeholder="Hobi" value="<?= old('hobby'); ?>" />
                    <div class="form-control-icon">
                        <i class="bi bi-controller"></i>
                    </div>
                    <?php if (session('validation') && session('validation')->hasError('hobby')) : ?>
                        <div class="invalid-feedback">
                            <?= session('validation')->getError('hobby'); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
                    Sign Up
                </button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                <p class="text-gray-600">
                    Already have an account?
                    <a href="/login" class="font-bold">Log in</a>.
                </p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>