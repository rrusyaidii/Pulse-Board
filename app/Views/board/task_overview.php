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
            <a href="<?= base_url('board/task/create') ?>" class="btn btn-primary">
                <i class="fa fa-plus me-1"></i> Create Task
            </a>
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

<?= $this->endSection() ?>


<?= $this->section('script') ?>
<script>
$(document).ready(function () {

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
            '<"d-flex justify-content-end mb-2"f>' +
            't' +
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

    $('#projectSelect').change(function () {
        loadSprints($(this).val(), '#sprintSelect');
        taskTable.ajax.reload();
    });

    $('#sprintSelect').change(function () {
        taskTable.ajax.reload();
    });

    $('#modalProjectSelect').change(function () {
        loadSprints($(this).val(), '#modalSprintSelect');
    });

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
