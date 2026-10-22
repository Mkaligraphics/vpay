  <link rel="icon" href="src/img/icon.png" type="image/x-icon"/>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<!-- FontAwesome -->
<link rel="stylesheet" href="src/vendor/fontawesome/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<link rel="stylesheet" href="src/output.css?v=<?= filemtime(__DIR__ . '/../output.css') ?>">

<script src="src/scripts/sidebar.js"></script>

<script>
$.ajaxSetup({headers: {'X-CSRF-Token': <?= json_encode($_SESSION['csrf_token']) ?>}});
</script>
