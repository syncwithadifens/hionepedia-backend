<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>

    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/assets/extensions/simple-datatables/style.css" />
    <link rel="stylesheet" href="/assets/compiled/css/table-datatable.css" />
    <link rel="stylesheet" href="/assets/compiled/css/app.css" />
    <link rel="stylesheet" href="/assets/compiled/css/app-dark.css" />
    <link rel="stylesheet" href="/assets/compiled/css/auth.css" />
</head>

<body>

    <?= $this->renderSection('content') ?>

    <script src="/assets/static/js/components/dark.js"></script>
    <script src="/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script src="/assets/compiled/js/app.js"></script>

    <script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="/assets/static/js/pages/simple-datatables.js"></script>

    <script>
        function previewImg() {
            const thumbnail = document.querySelector('#thumbnail');
            const thumbnailLabel = document.querySelector('#thumbnailLabel');
            const imgPreview = document.querySelector('.img-preview');

            // thumbnailLabel.textContent = thumbnail.files[0].name;

            const fileThumbnail = new FileReader();
            fileThumbnail.readAsDataURL(thumbnail.files[0]);

            fileThumbnail.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }

        setTimeout(function() {
            bootstrap.Alert.getOrCreateInstance(document.querySelector(".alert")).close();
        }, 2000)
    </script>
</body>

</html>