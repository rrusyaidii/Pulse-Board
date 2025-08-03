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

  <!-- Card 1: Project & Sprint Selector -->
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
          <thead class="table table-striped">
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Priority</th>
              <th>Status</th>
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
          <thead class="table table-striped">
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

    // DataTables: Show entries + search top, info + pagination bottom
    const tableOptions = {
        dom:
            // Top row: Length selector + Search
            '<"d-flex justify-content-between align-items-center mb-2"l f>' +
            // Table
            't' +
            // Bottom row: Info + Pagination on one line
            '<"d-flex justify-content-between align-items-center mt-2"i p>',
        pageLength: 5,
        lengthChange:false,
        lengthMenu: [5, 10, 25, 50],
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
                console.log('getSprints response:', res);

                if (res.status === 'success') {
                    res.sprints.forEach(sprint => {
                        $('#sprintSelect').append(
                            `<option value="${sprint.sprintID}">${sprint.name} (${sprint.startDate} - ${sprint.endDate})</option>`
                        );
                    });
                } else {
                    Swal.fire('Error', 'Failed to load sprints', 'error');
                }
            }, 'json');
        }
    });

    // Load tasks on sprint select
    $('#sprintSelect').change(function () {
        let sprintID = $(this).val();
        console.log('Sprint changed:', sprintID);

        if (!sprintID) {
            backlogTable.clear().draw();
            currentSprintTable.clear().draw();
            $('#backlogCount').text('0 Items');
            $('#currentTasksCount').text('0 Tasks');
            return;
        }

        $.get('<?= base_url('board/sprints/getTasks') ?>/' + sprintID, function (res) {
            console.log('getTasks response:', res);

            if (res.status === 'success') {
                backlogTable.clear();
                currentSprintTable.clear();

                // Populate backlog
                if (res.backlog.length > 0) {
                    let backlogRows = res.backlog.map(task => [
                        task.taskID,
                        task.name,
                        `<span class="badge ${task.priority=='High'?'bg-danger':(task.priority=='Medium'?'bg-warning text-dark':'bg-success')}">${task.priority}</span>`,
                        `<span class="badge bg-secondary">${task.status ?? 'Backlog'}</span>`,
                        `<button class="btn btn-sm btn-primary"><i class="fa fa-plus me-1"></i> Add to Sprint</button>`
                    ]);
                    backlogTable.rows.add(backlogRows);
                }
                backlogTable.draw();
                $('#backlogCount').text(res.backlog.length + ' Items');

                // Populate current sprint tasks
                if (res.currentSprintTasks.length > 0) {
                    let sprintRows = res.currentSprintTasks.map(task => [
                        task.taskID,
                        task.name,
                        `<span class="badge ${task.status=='Done'?'bg-success':(task.status=='In Progress'?'bg-warning text-dark':'bg-secondary')}">${task.status}</span>`,
                        `<span class="badge ${task.priority=='High'?'bg-danger':(task.priority=='Medium'?'bg-warning text-dark':'bg-success')}">${task.priority}</span>`,
                        task.assigneeID ?? 'Unassigned',
                        task.endDate ?? '-'
                    ]);
                    currentSprintTable.rows.add(sprintRows);
                }
                currentSprintTable.draw();
                $('#currentTasksCount').text(res.currentSprintTasks.length + ' Tasks');
            } else {
                Swal.fire('Error', 'Failed to load tasks', 'error');
            }
        }, 'json');
    });

});
</script>
<?= $this->endSection() ?>
