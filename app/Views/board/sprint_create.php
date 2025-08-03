<?= $this->extend('layout/master') ?>
<?= $this->section('main-content') ?>

<div class="container-fluid">

  <!-- Breadcrumb -->
  <div class="page-title mb-4">
    <div class="row">
      <div class="col-6">
        <h3><?= $breadcrumbs ?? 'Sprint Planning' ?></h3>
      </div>
      <div class="col-6">
        <ol class="breadcrumb justify-content-end">
          <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('board/sprints') ?>">Sprints</a></li>
          <li class="breadcrumb-item active">Create Sprint</li>
        </ol>
      </div>
    </div>
  </div>
  <!-- End of Breadcrumb -->

  <div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Create Sprint</h5>
                </div>

                <!-- Form -->
                <form id="sprintForm" class="form theme-form">
                    <?= csrf_field() ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">

                                <!-- Sprint Name -->
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Sprint Name</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="name" type="text" placeholder="Sprint 1" required>
                                    </div>
                                </div>

                                <!-- Project Dropdown -->
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Project</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" name="projectID" required>
                                            <option value="">Select Project</option>
                                            <?php if (!empty($projects)): ?>
                                                <?php foreach ($projects as $project): ?>
                                                    <option value="<?= $project['projectID'] ?>">
                                                        <?= esc($project['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Start Date -->
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Start Date</label>
                                    <div class="col-sm-9">
                                        <input class="form-control digits" name="startDate" type="date">
                                    </div>
                                </div>

                                <!-- End Date -->
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">End Date</label>
                                    <div class="col-sm-9">
                                        <input class="form-control digits" name="endDate" type="date">
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Status</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" name="status">
                                            <option value="Planned">Planned</option>
                                            <option value="Active">Active</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="card-footer text-end">
                        <button class="btn btn-primary" type="submit">Create Sprint</button>
                        <a href="<?= base_url('board/sprints') ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
  </div>

</div>



<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
$(document).ready(function () {
    $('#sprintForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: "<?= base_url('board/sprints/store') ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = "<?= base_url('board/sprints') ?>";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        html: '<ul>' + response.errors.join('<li></li>') + '</ul>'
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong, please try again.'
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
