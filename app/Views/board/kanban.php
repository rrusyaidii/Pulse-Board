<?= $this->extend('layout/master') ?>


<?= $this->section('main-content') ?>
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>
                    Kanban Board</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url("/") ?>">
                            <svg class="stroke-icon">
                                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item"> Apps</li>
                    <li class="breadcrumb-item active"> Kanban Board</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Container-fluid starts-->
<div class="container-fluid jkanban-container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>< Project Name > </h5>
                </div>
                <div class="card-body">
                    <div id="demo1"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="<?=base_url()?>/assets/js/jkanban/jkanban.js"></script>
<script src="<?=base_url()?>/assets/js/jkanban/custom.js"></script>
<script src="<?=base_url()?>/assets/js/typeahead/handlebars.js"></script>
<script src="<?=base_url()?>/assets/js/typeahead/typeahead.bundle.js"></script>
<script src="<?=base_url()?>/assets/js/typeahead/typeahead.custom.js"></script>
<script src="<?=base_url()?>/assets/js/typeahead-search/handlebars.js"></script>
<script src="<?=base_url()?>/assets/js/typeahead-search/typeahead-custom.js"></script>
<script src="<?=base_url()?>/assets/js/tooltip-init.js"></script>

<?= $this->endSection() ?>

