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

      <!-- Flat Task Table -->
      <table class="table table-sm table-bordered align-middle">
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

<?= $this->endSection() ?>
