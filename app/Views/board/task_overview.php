<?= $this->extend('layout/master') ?>

<?= $this->section('main-content') ?>
<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h3>Task Overview</h3>
      </div>
      <div class="col-6 text-end">
        <select class="form-select w-auto d-inline" style="display:inline-block;">
          <option selected>Sprint 1</option>
          <option>Sprint 2</option>
        </select>
      </div>
    </div>
  </div>

  <div class="card mt-4">
    <div class="card-body table-responsive">
      <table class="table table-borderless table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Task</th>
            <th>User Story</th>
            <th>Sprint</th>
            <th>Project</th>
            <th>Status</th>
            <th>Assignee</th>
            <th>Priority</th>
            <th>Type</th>
          </tr>
        </thead>
        <tbody>
          <!-- Sample Static Data -->
          <tr>
            <td>1</td>
            <td>Design Login UI</td>
            <td>User can log in using email/password</td>
            <td>Sprint 1</td>
            <td>Pulse Board</td>
            <td><span class="badge bg-secondary">To Do</span></td>
            <td>Faiz</td>
            <td><span class="badge bg-danger">High</span></td>
            <td><span class="badge bg-primary">UI</span></td>
          </tr>
          <tr>
            <td>2</td>
            <td>Setup DB Schema</td>
            <td>System must store user and task data</td>
            <td>Sprint 1</td>
            <td>Pulse Board</td>
            <td><span class="badge bg-warning text-dark">In Progress</span></td>
            <td>Amir</td>
            <td><span class="badge bg-warning text-dark">Medium</span></td>
            <td><span class="badge bg-info text-dark">Backend</span></td>
          </tr>
          <tr>
            <td>3</td>
            <td>Integrate Kanban Status</td>
            <td>User can drag cards between columns</td>
            <td>Sprint 2</td>
            <td>Pulse Board</td>
            <td><span class="badge bg-warning text-dark">In Progress</span></td>
            <td>Sarah</td>
            <td><span class="badge bg-danger">High</span></td>
            <td><span class="badge bg-primary">Frontend</span></td>
          </tr>
          <tr>
            <td>4</td>
            <td>Deploy to GitHub</td>
            <td>Code must be pushed for version control</td>
            <td>Sprint 1</td>
            <td>Pulse Board</td>
            <td><span class="badge bg-success">Done</span></td>
            <td>Faiz</td>
            <td><span class="badge bg-success">Low</span></td>
            <td><span class="badge bg-secondary">Infra</span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
