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
          <select class="form-select">
            <option value="1" selected>Pulse Board</option>
            <option value="2">Inventory System</option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Select Sprint</label>
          <select class="form-select">
            <option value="1" selected>Sprint 1 (01-14 Aug)</option>
            <option value="2">Sprint 2 (15-28 Aug)</option>
          </select>
        </div>
        <div class="col-md-4 text-end mt-4">
          <button class="btn btn-primary">
            <i class="fa fa-plus me-1"></i> Create Sprint
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Card 2: Product Backlog -->
  <div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
      <h5 class="fw-semibold text-dark mb-0">
        <i class="fa fa-list me-2 text-primary"></i> Product Backlog
      </h5>
      <span class="badge bg-light text-dark">2 Items</span>
    </div>
    <div class="card-body p-3" style="max-height: 560px; overflow-y: auto;">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Priority</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>6</td>
              <td>Implement email verification</td>
              <td><span class="badge bg-danger">High</span></td>
              <td><span class="badge bg-secondary">Backlog</span></td>
              <td>
                <button class="btn btn-sm btn-primary">
                  <i class="fa fa-plus me-1"></i> Add to Sprint
                </button>
              </td>
            </tr>
            <tr>
              <td>7</td>
              <td>Export report to CSV</td>
              <td><span class="badge bg-warning text-dark">Medium</span></td>
              <td><span class="badge bg-secondary">Backlog</span></td>
              <td>
                <button class="btn btn-sm btn-primary">
                  <i class="fa fa-plus me-1"></i> Add to Sprint
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Card 3: Current Sprint Tasks -->
  <div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
      <h5 class="fw-semibold text-dark mb-0">
        <i class="fa fa-tasks me-2 text-success"></i> Current Sprint Tasks
      </h5>
      <span class="badge bg-light text-dark">3 Tasks</span>
    </div>
    <div class="card-body p-3" style="max-height: 560px; overflow-y: auto;">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
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
          <tbody>
            <tr>
              <td>1</td>
              <td>Design login UI</td>
              <td><span class="badge bg-warning text-dark">In Progress</span></td>
              <td><span class="badge bg-danger">High</span></td>
              <td>Aiman</td>
              <td>03 Aug</td>
            </tr>
            <tr>
              <td>2</td>
              <td>Setup login API</td>
              <td><span class="badge bg-success">Done</span></td>
              <td><span class="badge bg-warning text-dark">Medium</span></td>
              <td>Sara</td>
              <td>05 Aug</td>
            </tr>
            <tr>
              <td>3</td>
              <td>Create user CRUD UI</td>
              <td><span class="badge bg-secondary">To-do</span></td>
              <td><span class="badge bg-danger">High</span></td>
              <td>Fatin</td>
              <td>06 Aug</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<?= $this->endSection() ?>
