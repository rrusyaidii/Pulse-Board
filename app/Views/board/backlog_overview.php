<?= $this->extend('layout/master') ?>
<?= $this->section('main-content') ?>

<div class="container-fluid">
  <div class="page-title mb-4">
    <div class="row">
      <div class="col-12">
        <h3>Product Backlog</h3>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body">

      <!-- Optional: Filter/Search -->
      <div class="row mb-3">
        <div class="col-md-6">
          <input type="text" class="form-control" placeholder="Search backlog item...">
        </div>
      </div>

      <!-- Backlog Table -->
      <table class="table table-sm table-bordered align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Status</th>
            <th>Priority</th>
            <th>Assignee</th>
            <th>Sprint</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Backlog Item 1 -->
          <tr>
            <td>1</td>
            <td>As a user, I want to login to the system</td>
            <td><span class="badge bg-secondary">Backlog</span></td>
            <td><span class="badge bg-danger">High</span></td>
            <td>Aiman</td>
            <td><span class="text-muted">Not assigned</span></td>
            <td>
              <button class="btn btn-sm btn-primary"><i class="fa fa-sign-in-alt me-1"></i>Assign to Sprint</button>
              <button class="btn btn-sm btn-outline-secondary"><i class="fa fa-edit"></i></button>
              <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
            </td>
          </tr>

          <!-- Backlog Item 2 -->
          <tr>
            <td>2</td>
            <td>As an admin, I want to manage users</td>
            <td><span class="badge bg-info text-dark">In Progress</span></td>
            <td><span class="badge bg-warning text-dark">Medium</span></td>
            <td>Fatin</td>
            <td>Sprint 1</td>
            <td>
              <button class="btn btn-sm btn-primary"><i class="fa fa-sign-in-alt me-1"></i>Reassign</button>
              <button class="btn btn-sm btn-outline-secondary"><i class="fa fa-edit"></i></button>
              <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
            </td>
          </tr>

          <!-- Backlog Item 3 -->
          <tr>
            <td>3</td>
            <td>As a user, I want to reset my password</td>
            <td><span class="badge bg-secondary">Backlog</span></td>
            <td><span class="badge bg-warning text-dark">Medium</span></td>
            <td>Alia</td>
            <td><span class="text-muted">Not assigned</span></td>
            <td>
              <button class="btn btn-sm btn-primary"><i class="fa fa-sign-in-alt me-1"></i>Assign to Sprint</button>
              <button class="btn btn-sm btn-outline-secondary"><i class="fa fa-edit"></i></button>
              <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
            </td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>
</div>

<?= $this->endSection() ?>
