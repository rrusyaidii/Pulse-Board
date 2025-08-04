<?= $this->extend('layout/master') ?>
<?= $this->section('main-content') ?>

<div class="container-fluid">

  <!-- Breadcrumb -->
  <div class="page-title mb-4">
    <div class="row">
      <div class="col-6">
        <h3><?= $breadcrumbs ?? 'Edit Task' ?></h3>
      </div>
      <div class="col-6">
        <ol class="breadcrumb justify-content-end">
          <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('board/task') ?>">Tasks</a></li>
          <li class="breadcrumb-item active">Edit Task</li>
        </ol>
      </div>
    </div>
  </div>

  <!-- Edit Task Form -->
  <form id="editTaskForm" class="form theme-form">
    <?= csrf_field() ?>

    <!-- Card 1: Task Info -->
    <div class="card mb-4">
      <div class="card-header"><h5>Task Information</h5></div>
      <div class="card-body">
        <div class="row g-3">

          <!-- Left Column -->
          <div class="col-md-6">
            <div class="mb-3 row">
              <label class="col-sm-4 col-form-label">Task Name</label>
              <div class="col-sm-8">
                <input class="form-control" name="name" value="<?= esc($task['name']) ?>" required>
              </div>
            </div>

            <div class="mb-3 row">
              <label class="col-sm-4 col-form-label">Project</label>
              <div class="col-sm-8">
                <select class="form-select" name="projectID" required>
                  <?php foreach ($projects as $project): ?>
                    <option value="<?= $project['projectID'] ?>" <?= $project['projectID']==$task['projectID']?'selected':'' ?>>
                      <?= esc($project['name']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <!-- Right Column -->
          <div class="col-md-6">
            <div class="mb-3 row">
              <label class="col-sm-4 col-form-label">Type</label>
              <div class="col-sm-8">
                <select class="form-select" name="type">
                  <?php foreach(['Feature','Bug','Improvement','Documentation','Testing','Support'] as $type): ?>
                    <option value="<?= $type ?>" <?= $type==$task['type']?'selected':'' ?>><?= $type ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="mb-3 row">
              <label class="col-sm-4 col-form-label">Priority</label>
              <div class="col-sm-8">
                <select class="form-select" name="priority">
                  <?php foreach(['Low','Normal','High','Blocker'] as $priority): ?>
                    <option value="<?= $priority ?>" <?= $priority==$task['priority']?'selected':'' ?>><?= $priority ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Card 2: Task Description -->
    <div class="card mb-4">
      <div class="card-header"><h5>Task Description</h5></div>
      <div class="card-body">
        <textarea id="taskDescription" name="description"><?= esc($task['description']) ?></textarea>
      </div>
    </div>

    <!-- Buttons -->
    <div class="text-end mb-4">
      <button class="btn btn-success" type="submit">Save Changes</button>
      <a href="<?= base_url('board/task/view/'.$task['taskID']) ?>" class="btn btn-secondary">Cancel</a>
    </div>
  </form>

</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function () {
  // Initialize Summernote with existing description
  $('#taskDescription').summernote({
    placeholder: 'Edit task description...',
    height: 200,
    tabsize: 2,
    toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['link', 'picture', 'hr']]
    ],
    styleTags: ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6']
  });

  // Submit Update
  $('#editTaskForm').on('submit', function (e) {
    e.preventDefault();

    // Update textarea with Summernote HTML
    $('#taskDescription').val($('#taskDescription').summernote('code'));

    $.ajax({
      url: "<?= base_url('board/task/update/'.$task['taskID']) ?>",
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
            window.location.href = "<?= base_url('board/task/view/'.$task['taskID']) ?>";
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Failed',
            html: '<ul>' + Object.values(response.errors || {0:response.message}).map(e => `<li>${e}</li>`).join('') + '</ul>'
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
