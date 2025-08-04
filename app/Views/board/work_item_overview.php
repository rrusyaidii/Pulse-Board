<?= $this->extend('layout/master') ?>

<?= $this->section('main-content') ?>
<div class="container-fluid">

  <div class="page-title mb-4">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h3>Work Items</h3>
      </div>
    </div>
  </div>

  <!-- Filters -->
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
      </div>
    </div>
  </div>

  <!-- Work Items Table -->
  <div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
      <table class="table table-hover align-middle table-striped table-sm" id="workItemTable" style="width:100%">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Task</th>
            <th>Sprint</th>
            <th>Status</th>
            <th>Priority</th>
            <th>Assignee</th>
            <th>Due Date</th>
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

    function loadSprints(projectID) {
        $('#sprintSelect').html('<option value="">Select Sprint</option>');
        if (projectID) {
            $.get('<?= base_url('board/work_item/getSprints') ?>/' + projectID, function (res) {
                if (res.status === 'success') {
                    res.sprints.forEach(sprint => {
                        $('#sprintSelect').append(`<option value="${sprint.sprintID}">${sprint.name}</option>`);
                    });
                }
            }, 'json');
        }
    }

    const statuses = ['Backlog','To Do','In Progress','In Review','Completed','Done'];
    const priorities = ['Low','Normal','Medium','High','Blocker'];
    const users = <?= json_encode($users) ?>; // ✅ Server-side user list

    // DataTable
    let table = $('#workItemTable').DataTable({
        ajax: {
            url: '<?= base_url('board/work_item/getTasks') ?>',
            data: function(d) {
                d.projectID = $('#projectSelect').val();
                d.sprintID = $('#sprintSelect').val();
            },
            dataSrc: 'data'
        },
        pageLength: 10,
        lengthChange: false,
        dom: '<"d-flex justify-content-end mb-2"f>t<"d-flex justify-content-between mt-2"ip>',
        columns: [
            { data: 0 },
            { data: 1 },
            { data: 2 },
            { 
                data: 3,
                render: function(data, type, row) {
                    const taskID = row[0];
                    let html = `<select class="form-select form-select-sm status-select" data-id="${taskID}">`;
                    statuses.forEach(s => { html += `<option value="${s}" ${data === s ? 'selected' : ''}>${s}</option>`; });
                    html += `</select>`;
                    return html;
                }
            },
            { 
                data: 4,
                render: function(data, type, row) {
                    const taskID = row[0];
                    let html = `<select class="form-select form-select-sm priority-select" data-id="${taskID}">`;
                    priorities.forEach(p => { html += `<option value="${p}" ${data === p ? 'selected' : ''}>${p}</option>`; });
                    html += `</select>`;
                    return html;
                }
            },
            { 
                data: 5,
                render: function(data, type, row) {
                    const taskID = row[0];
                    const currentAssigneeID = row[6];
                    let html = `<select class="form-select form-select-sm assignee-select" data-id="${taskID}">`;
                    html += `<option value="">Unassigned</option>`;
                    users.forEach(u => {
                        html += `<option value="${u.userID}" ${currentAssigneeID == u.userID ? 'selected' : ''}>${u.name}</option>`;
                    });
                    html += `</select>`;
                    return html;
                }
            },
            { data: 7 }
        ]
    });

    $('#projectSelect').change(function () {
        loadSprints($(this).val());
        table.ajax.reload();
    });

    $('#sprintSelect').change(function () {
        table.ajax.reload();
    });

    // Update Status
    $('#workItemTable').on('change', '.status-select', function() {
        $.post('<?= base_url('board/work_item/updateStatus') ?>', {
            taskID: $(this).data('id'), status: $(this).val()
        }, function(res) {
            Swal.fire(res.status === 'success' ? 'Updated!' : 'Error!', res.message, res.status);
        }, 'json');
    });

    // Update Priority
    $('#workItemTable').on('change', '.priority-select', function() {
        $.post('<?= base_url('board/work_item/updatePriority') ?>', {
            taskID: $(this).data('id'), priority: $(this).val()
        }, function(res) {
            Swal.fire(res.status === 'success' ? 'Updated!' : 'Error!', res.message, res.status);
        }, 'json');
    });

    // Update Assignee
    $('#workItemTable').on('change', '.assignee-select', function() {
        $.post('<?= base_url('board/work_item/updateAssignee') ?>', {
            taskID: $(this).data('id'), assigneeID: $(this).val()
        }, function(res) {
            Swal.fire(res.status === 'success' ? 'Updated!' : 'Error!', res.message, res.status);
        }, 'json');
    });

});
</script>
<?= $this->endSection() ?>
