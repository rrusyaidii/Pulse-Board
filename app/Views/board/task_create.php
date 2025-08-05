<?= $this->extend('layout/master') ?>
<?= $this->section('main-content') ?>

<div class="container-fluid">

  <!-- Breadcrumb -->
  <div class="page-title mb-4">
    <div class="row">
      <div class="col-6">
        <h3><?= $breadcrumbs ?? 'Create Task' ?></h3>
      </div>
      <div class="col-6">
        <ol class="breadcrumb justify-content-end">
          <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('board/task') ?>">Tasks</a></li>
          <li class="breadcrumb-item active">Create Task</li>
        </ol>
      </div>
    </div>
  </div>

  <!-- Form -->
  <form id="sprintForm" class="form theme-form">
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
                <input class="form-control" name="name" type="text" placeholder="Task Name" autocomplete="off" required>
              </div>
            </div>

            <div class="mb-3 row">
              <label class="col-sm-4 col-form-label">Project</label>
              <div class="col-sm-8">
                <select class="form-select" name="projectID" required>
                  <option value="">Select Project</option>
                  <?php foreach ($projects as $project): ?>
                      <option value="<?= $project['projectID'] ?>"><?= esc($project['name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <!-- <div class="mb-3 row">
              <label class="col-sm-4 col-form-label">Task Status</label>
              <div class="col-sm-8">
                <select class="form-select" name="status">
                <option value="">Select Task status</option>
                <option value="To Do">To Do</option>
                <option value="In Progress">In Progress</option>
                <option value="In Review">In Review</option>
                <option value="Blocked">Blocked</option>
                <option value="Completed">Completed</option>
                </select>
              </div>
            </div> -->
          </div>

          <!-- Right Column -->
          <div class="col-md-6">
            <div class="mb-3 row">
              <label class="col-sm-4 col-form-label">Type</label>
              <div class="col-sm-8">
                <select class="form-select" name="type">
                  <option value="">Select Task Type</option>
                  <option value="Feature">Feature</option>
                  <option value="Bug">Bug</option>
                  <option value="Improvement">Improvement</option>
                  <option value="Documentation">Documentation</option>
                  <option value="Testing">Testing</option>
                  <option value="Support">Support</option>
                </select>
              </div>
            </div>

            <div class="mb-3 row">
              <label class="col-sm-4 col-form-label">Priority</label>
              <div class="col-sm-8">
                <select class="form-select" name="priority">
                  <option value="">Select Priority</option>
                  <option value="Low">Low</option>
                  <option value="Normal">Normal</option>
                  <option value="High">High</option>
                  <option value="Blocker">Blocker</option>
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
        <textarea id="taskDescription" name="description"></textarea>
      </div>
    </div>

    <!-- Submit Buttons -->
    <div class="text-end mb-4">
      <button class="btn btn-primary" type="submit">Create Task</button>
      <a href="<?= base_url('board/task') ?>" class="btn btn-secondary">Cancel</a>
    </div>
  </form>

</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function () {
    $('#taskDescription').summernote({
        placeholder: 'Write detailed task description here...',
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

    $('#sprintForm').on('submit', function (e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.set('description', $('#taskDescription').summernote('code'));

        $.ajax({
            url: "<?= base_url('board/task/store') ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            processData: false, 
            contentType: false, 
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = "<?= base_url('board/task') ?>";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        html: '<ul>' + Object.values(response.errors).map(e => `<li>${e}</li>`).join('') + '</ul>'
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
