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
          <li class="breadcrumb-item active">Sprint Planning</li>
        </ol>
      </div>
    </div>
  </div>

  <!-- Project & Sprint Selector -->
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
            <a href="<?= base_url('board/sprints/create') ?>" class="btn btn-primary">
                <i class="fa fa-plus me-1"></i> Create Sprint
            </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Product Backlog -->
  <div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
      <h5 class="fw-semibold text-dark mb-0">
        <i class="fa fa-list me-2 text-primary"></i> Product Backlog
      </h5>
      <span class="badge bg-light text-dark" id="backlogCount">0 Items</span>
    </div>
    <div class="card-body p-3">
      <div class="table-responsive">
        <table class="table table-hover align-middle table-striped table-sm" id="backlogTable" style="width:100%">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Priority</th>
              <th>Status</th>
              <th>Assignee</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Current Sprint Tasks -->
  <div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
      <h5 class="fw-semibold text-dark mb-0">
        <i class="fa fa-tasks me-2 text-success"></i> Current Sprint Tasks
      </h5>
      <span class="badge bg-light text-dark" id="currentTasksCount">0 Tasks</span>
    </div>
    <div class="card-body p-3">
      <div class="table-responsive">
        <table class="table table-hover align-middle table-striped table-sm" id="currentSprintTable" style="width:100%">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Status</th>
              <th>Priority</th>
              <th>Assignee</th>
              <th>Due</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<?= $this->endSection() ?>


<?= $this->section('script') ?>
<script>
$(document).ready(function () {
    const tableOptions = {
        dom: '<"d-flex justify-content-between align-items-center mb-2"l f>t<"d-flex justify-content-between align-items-center mt-2"i p>',
        pageLength: 5,
        lengthChange: false,
        language: {
            emptyTable: "No data available",
            search: "_INPUT_",
            searchPlaceholder: "Search..."
        }
    };

    let backlogTable = $('#backlogTable').DataTable(tableOptions);
    let currentSprintTable = $('#currentSprintTable').DataTable(tableOptions);

    // Load sprints on project select
    $('#projectSelect').change(function () {
        let projectID = $(this).val();
        $('#sprintSelect').html('<option value="">Select Sprint</option>');

        backlogTable.clear().draw();
        currentSprintTable.clear().draw();
        $('#backlogCount').text('0 Items');
        $('#currentTasksCount').text('0 Tasks');

        if (projectID) {
            $.get('<?= base_url('board/sprints/getSprints') ?>/' + projectID, function (res) {
                if (res.status === 'success') {
                    res.sprints.forEach(sprint => {
                        $('#sprintSelect').append(
                            `<option value="${sprint.sprintID}">${sprint.name} (${sprint.startDate} - ${sprint.endDate})</option>`
                        );
                    });
                }
            }, 'json');

            loadTasks(projectID, '');
        }
    });

    // Load tasks when sprint changes
    $('#sprintSelect').change(function () {
        let projectID = $('#projectSelect').val();
        let sprintID = $(this).val();
        loadTasks(projectID, sprintID);
    });

    // Load tasks into tables
    function loadTasks(projectID, sprintID) {
        $.get('<?= base_url('board/sprints/getTasks') ?>/' + projectID + '/' + (sprintID || ''), function (res) {
            if (res.status === 'success') {
                backlogTable.clear();
                currentSprintTable.clear();

                // Backlog
                if (res.backlog.length > 0) {
                    let backlogRows = res.backlog.map(task => [
                        task.taskID,
                        `<a href="<?= base_url('board/task/view/') ?>${task.taskID}" target="_blank" class="fw-semibold text-primary">${task.name}</a>`,
                        `<span class="badge ${task.priority=='High'?'bg-danger':(task.priority=='Normal'?'bg-warning text-dark':'bg-success')}">${task.priority}</span>`,
                        `<span class="badge bg-secondary">Backlog</span>`,
                        task.assigneeName ?? 'Unassigned',
                        `<button class="btn btn-sm btn-primary add-to-sprint"><i class="fa fa-plus me-1"></i> Add to Sprint</button>`
                    ]);
                    backlogTable.rows.add(backlogRows);
                }
                backlogTable.draw();
                $('#backlogCount').text(res.backlog.length + ' Items');

                // Current Sprint Tasks
                if (res.currentSprintTasks.length > 0) {
                    let sprintRows = res.currentSprintTasks.map(task => [
                        task.taskID,
                        `<a href="<?= base_url('board/task/view/') ?>${task.taskID}" target="_blank" class="fw-semibold text-primary">${task.name}</a>`,
                        `<span class="badge ${task.status=='Completed'?'bg-success':(task.status=='In Progress'?'bg-warning text-dark':'bg-secondary')}">${task.status}</span>`,
                        `<span class="badge ${task.priority=='High'?'bg-danger':(task.priority=='Normal'?'bg-warning text-dark':'bg-success')}">${task.priority}</span>`,
                        task.assigneeName ?? 'Unassigned',
                        task.endDate ?? '-'
                    ]);
                    currentSprintTable.rows.add(sprintRows);
                }
                currentSprintTable.draw();
                $('#currentTasksCount').text(res.currentSprintTasks.length + ' Tasks');
            }
        }, 'json');
    }

    // Add to Sprint button
    $('#backlogTable').on('click', '.add-to-sprint', function () {
        const row = backlogTable.row($(this).closest('tr')).data();
        const taskID = row[0];
        const sprintID = $('#sprintSelect').val();

        if (!sprintID) {
            Swal.fire('Warning', 'Please select a sprint first!', 'warning');
            return;
        }

        $.post('<?= base_url('board/sprints/addToSprint') ?>', 
            { taskID: taskID, sprintID: sprintID }, 
            function (res) {
                if (res.status === 'success') {
                    Swal.fire('Success', res.message, 'success');
                    $('#sprintSelect').trigger('change');
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }, 
        'json');
    });
});
</script>
<?= $this->endSection() ?>
