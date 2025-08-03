<?= $this->extend('layout/master') ?>
<?= $this->section('main-content') ?>

<div class="container-fluid">

  <!-- Page Title -->
  <div class="page-title mb-4">
    <div class="row">
      <div class="col-12">
        <h3>Project Work Items</h3>
      </div>
    </div>
  </div>

  <!-- Filters Card -->
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
            <th>Title</th>
            <th>Type</th>
            <th>Status</th>
            <th>Priority</th>
            <th>Assignee</th>
            <th>Due</th>
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

    // Initialize DataTable
    let workItemTable = $('#workItemTable').DataTable({
        ajax: {
            url: '<?= base_url('board/work_item/getTasks') ?>',
            data: function(d) {
                d.projectID = $('#projectSelect').val();
                d.sprintID  = $('#sprintSelect').val();
            },
            dataSrc: 'data'
        },
        pageLength: 5,
        lengthChange: false,
        dom:
            '<"d-flex justify-content-end mb-2"f>' + // Search on top right
            't' +
            '<"d-flex justify-content-between align-items-center mt-2"i p>', // Info + Pagination bottom
        columns: [
            { data: 0 },
            { data: 1 },
            { data: 2 },
            { data: 3 },
            { data: 4 },
            { data: 5 },
            { data: 6 }
        ],
        language: {
            emptyTable: "No work items available",
            search: "_INPUT_",
            searchPlaceholder: "Search..."
        }
    });

    // Load sprints when a project is selected
    $('#projectSelect').change(function () {
        let projectID = $(this).val();
        $('#sprintSelect').html('<option value="">Select Sprint</option>');

        if (projectID) {
            $.get('<?= base_url('board/work_item/getSprints') ?>/' + projectID, function (res) {
                if (res.status === 'success') {
                    res.sprints.forEach(sprint => {
                        $('#sprintSelect').append(
                            `<option value="${sprint.sprintID}">${sprint.name} (${sprint.startDate} - ${sprint.endDate})</option>`
                        );
                    });
                }
            }, 'json');
        }

        workItemTable.ajax.reload();
    });

    // Reload table when sprint is selected
    $('#sprintSelect').change(function () {
        workItemTable.ajax.reload();
    });

});
</script>
<?= $this->endSection() ?>
