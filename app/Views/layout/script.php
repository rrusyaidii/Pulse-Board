<!-- 1️⃣ jQuery FIRST (only one version) -->
<script src="<?= base_url() ?>/assets/js/jquery-3.5.1.min.js"></script>

<!-- 2️⃣ Bootstrap and other core scripts -->
<script src="<?= base_url() ?>/assets/js/bootstrap/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>/assets/js/icons/feather-icon/feather.min.js"></script>
<script src="<?= base_url() ?>/assets/js/icons/feather-icon/feather-icon.js"></script>
<script src="<?= base_url() ?>/assets/js/scrollbar/simplebar.js"></script>
<script src="<?= base_url() ?>/assets/js/scrollbar/custom.js"></script>
<script src="<?= base_url() ?>/assets/js/config.js"></script>
<script src="<?= base_url() ?>/assets/js/sidebar-menu.js"></script>
<script src="<?= base_url() ?>/assets/js/slick/slick.min.js"></script>
<script src="<?= base_url() ?>/assets/js/slick/slick.js"></script>
<script src="<?= base_url() ?>/assets/js/header-slick.js"></script>
<script src="<?= base_url() ?>/assets/js/chart/apex-chart/apex-chart.js"></script>
<script src="<?= base_url() ?>/assets/js/animation/wow/wow.min.js"></script>
<script src="<?= base_url() ?>/assets/js/prism/prism.min.js"></script>

<!-- 3️⃣ DataTables & SweetAlert (AFTER jQuery) -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- quill editor js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>



<!-- 4️⃣ Page-specific scripts -->
<?= $this->renderSection('script') ?>

<!-- 5️⃣ Theme and final scripts -->
<script src="<?= base_url() ?>/assets/js/script.js"></script>

<script>
    new WOW().init();
</script>
