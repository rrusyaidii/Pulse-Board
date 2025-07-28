<?= $this->extend('layout/master') ?>
<?= $this->section('main-content') ?>

<div class="container-fluid">
  <div class="page-title mb-4">
    <div class="row">
      <div class="col-12">
        <h3>Project Work Items</h3>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body">

      <!-- Selectors -->
      <div class="row mb-4">
        <div class="col-md-4">
          <label class="form-label fw-semibold">Project</label>
          <select class="form-select" disabled>
            <option selected>Pulse Board</option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Sprint</label>
          <select class="form-select" disabled>
            <option selected>Sprint 1 - 01 Aug to 14 Aug</option>
          </select>
        </div>
      </div>

      <!-- User Story 1 -->
      <div class="mb-4">
        <div class="fw-bold text-dark mb-2" style="cursor: pointer;" onclick="toggleTasks('tasks1')">
          <i class="fa fa-chevron-down me-1" id="icon-tasks1"></i> User Story: As a user, I want to login to the system
        </div>
        <div id="tasks1" style="display: block;">
          <table class="table table-sm table-borderless align-middle mb-0">
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
            <tbody>
              <tr>
                <td>1</td>
                <td>Design login UI</td>
                <td><span class="badge bg-info text-dark">Task</span></td>
                <td><span class="badge bg-warning text-dark">In Progress</span></td>
                <td><span class="badge bg-danger">High</span></td>
                <td>Aiman</td>
                <td>03 Aug</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Setup login API</td>
                <td><span class="badge bg-info text-dark">Task</span></td>
                <td><span class="badge bg-success">Done</span></td>
                <td><span class="badge bg-warning text-dark">Medium</span></td>
                <td>Sara</td>
                <td>05 Aug</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- User Story 2 -->
      <div class="mb-4">
        <div class="fw-bold text-dark mb-2" style="cursor: pointer;" onclick="toggleTasks('tasks2')">
          <i class="fa fa-chevron-down me-1" id="icon-tasks2"></i> User Story: As an admin, I want to manage users
        </div>
        <div id="tasks2" style="display: block;">
          <table class="table table-sm table-borderless align-middle mb-0">
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
            <tbody>
              <tr>
                <td>3</td>
                <td>Create user CRUD UI</td>
                <td><span class="badge bg-info text-dark">Task</span></td>
                <td><span class="badge bg-secondary">To-do</span></td>
                <td><span class="badge bg-danger">High</span></td>
                <td>Fatin</td>
                <td>06 Aug</td>
              </tr>
              <tr>
                <td>4</td>
                <td>Validate role permissions</td>
                <td><span class="badge bg-info text-dark">Task</span></td>
                <td><span class="badge bg-warning text-dark">In Progress</span></td>
                <td><span class="badge bg-success">Low</span></td>
                <td>Arif</td>
                <td>07 Aug</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- User Story 3 -->
      <div class="mb-4">
        <div class="fw-bold text-dark mb-2" style="cursor: pointer;" onclick="toggleTasks('tasks3')">
          <i class="fa fa-chevron-down me-1" id="icon-tasks3"></i> User Story: As a user, I want to reset my password
        </div>
        <div id="tasks3" style="display: block;">
          <table class="table table-sm table-borderless align-middle mb-0">
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
            <tbody>
              <tr>
                <td>5</td>
                <td>Add forgot password flow</td>
                <td><span class="badge bg-info text-dark">Task</span></td>
                <td><span class="badge bg-secondary">To-do</span></td>
                <td><span class="badge bg-warning text-dark">Medium</span></td>
                <td>Alia</td>
                <td>08 Aug</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Toggle Script -->
<script>
  function toggleTasks(id) {
    const section = document.getElementById(id);
    const icon = document.getElementById('icon-' + id);
    const isVisible = section.style.display === 'block';
    section.style.display = isVisible ? 'none' : 'block';
    icon.className = isVisible ? 'fa fa-chevron-down me-1' : 'fa fa-chevron-up me-1';
  }
</script>

<?= $this->endSection() ?>
