<?= $this->extend('layout/master') ?>

<?= $this->section('main-content') ?>
<div class="container-fluid">

  <!-- Page Title -->
  <div class="page-title mb-4">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h3>Task Overview</h3>
      </div>
    </div>
  </div>

  <!-- Project & Sprint Filters + Create Button -->
  <div class="card mb-4 shadow-sm border-0">
    <div class="card-body">
      <div class="row align-items-center">
        <div class="col-md-4">
          <label class="form-label fw-semibold">Select Project</label>
          <select class="form-select" id="projectSelect">
            <option value="">Select Project</option>
            <?php foreach ($projects as $project): ?>
                <option value="<?= $project['projectID'] ?>"><?= esc($project['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Select Sprint</label>
          <select class="form-select" id="sprintSelect">
            <option value="">Select Sprint</option>
          </select>
        </div>
        <div class="col-md-4 text-end mt-4">
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal">
            <i class="fa fa-plus me-1"></i> Create Task
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Task Table -->
  <div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
      <table class="table table-hover align-middle table-striped table-sm" id="taskTable" style="width:100%">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Task</th>
            <th>Sprint</th>
            <th>Project</th>
            <th>Status</th>
            <th>Assignee</th>
            <th>Priority</th>
            <th>Type</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

</div>

<!-- Create Task Modal -->
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="createTaskForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createTaskLabel">Create Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Task Name</label>
            <input type="text" class="form-control" name="name" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Project</label>
            <select class="form-select" name="projectID" id="modalProjectSelect" required>
              <option value="">Select Project</option>
              <?php foreach ($projects as $project): ?>
                  <option value="<?= $project['projectID'] ?>"><?= esc($project['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Sprint (Optional)</label>
            <select class="form-select" name="sprintID" id="modalSprintSelect">
              <option value="">Backlog</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Assignee</label>
            <select class="form-select" name="assigneeID">
              <option value="">Unassigned</option>
              <?php foreach ($users as $user): ?>
                  <option value="<?= $user['userID'] ?>"><?= esc($user['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Priority</label>
            <select class="form-select" name="priority">
              <option>Low</option>
              <option>Medium</option>
              <option>High</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Type</label>
            <select class="form-select" name="type">
              <option>UI</option>
              <option>Backend</option>
              <option>Frontend</option>
              <option>Infra</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save Task</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>
<?= $this->endSection() ?>


<?= $this->section('script') ?>
<script>
$(document).ready(function () {

    // Initialize DataTable with Sprint Overview style (search right)
    let taskTable = $('#taskTable').DataTable({
        ajax: {
            url: '<?= base_url('board/task/getTasks') ?>',
            data: function(d) {
                d.projectID = $('#projectSelect').val();
                d.sprintID = $('#sprintSelect').val();
            },
            dataSrc: 'data'
        },
        pageLength: 5,
        lengthChange: false,
        dom:
            // Top row: search on the right
            '<"d-flex justify-content-end mb-2"f>' +
            // Table
            't' +
            // Bottom row: info + pagination in one line
            '<"d-flex justify-content-between align-items-center mt-2"i p>',
        columns: [
            { data: 0 },
            { data: 1 },
            { data: 2 },
            { data: 3 },
            { data: 4 },
            { data: 5 },
            { data: 6 },
            { data: 7 }
        ],
        language: {
            emptyTable: "No tasks available",
            search: "_INPUT_",
            searchPlaceholder: "Search..."
        }
    });

    // Load sprints for both main and modal
    function loadSprints(projectID, sprintSelectID) {
        $(sprintSelectID).html('<option value="">Select Sprint</option>');
        if (projectID) {
            $.get('<?= base_url('board/task/getSprints') ?>/' + projectID, function (res) {
                if (res.status === 'success') {
                    res.sprints.forEach(sprint => {
                        $(sprintSelectID).append(
                            `<option value="${sprint.sprintID}">${sprint.name}</option>`
                        );
                    });
                }
            }, 'json');
        }
    }

    // Project filter -> load sprints & reload table
    $('#projectSelect').change(function () {
        loadSprints($(this).val(), '#sprintSelect');
        taskTable.ajax.reload();
    });

    // Sprint filter -> reload table
    $('#sprintSelect').change(function () {
        taskTable.ajax.reload();
    });

    // Modal Project select -> load sprints for modal
    $('#modalProjectSelect').change(function () {
        loadSprints($(this).val(), '#modalSprintSelect');
    });

    // Create Task Form Submit
    $('#createTaskForm').submit(function (e) {
        e.preventDefault();

        $.post('<?= base_url('board/task/store') ?>', $(this).serialize(), function (res) {
            if (res.status === 'success') {
                Swal.fire('Success', res.message, 'success');
                $('#createTaskModal').modal('hide');
                $('#createTaskForm')[0].reset();
                taskTable.ajax.reload();
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        }, 'json');
    });

});
</script>
<?= $this->endSection() ?>
