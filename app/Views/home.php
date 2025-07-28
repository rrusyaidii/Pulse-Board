<?= $this->extend('layout/master') ?>

<?= $this->section('main-content') ?>
<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h3>Dashboard</h3>
      </div>
      <div class="col-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?= base_url("/") ?>">
              <svg class="stroke-icon">
                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#stroke-home"></use>
              </svg>
            </a>
          </li>
        </ol>
      </div>
    </div>
  </div>

<!-- Summary Cards -->
<div class="row g-3 mt-3">

  <!-- Card 1: Active Projects -->
  <div class="col-sm-6 col-md-4 col-lg-3">
    <div class="card course-box widget-course">
      <div class="card-body">
        <div class="course-widget">
          <div class="course-icon warning">
            <i class="fa fa-folder-open text-white fs-3"></i>
          </div>
          <div>
            <h4 class="mb-0">4</h4>
            <span class="f-light">Active Project</span>
          </div>
        </div>
      </div>
      <ul class="square-group">
        <li class="square-1 warning"></li>
        <li class="square-1 primary"></li>
        <li class="square-2 warning1"></li>
        <li class="square-3 danger"></li>
        <li class="square-4 light"></li>
        <li class="square-5 warning"></li>
        <li class="square-6 success"></li>
        <li class="square-7 success"></li>
      </ul>
    </div>
  </div>

  <!-- Card 2: To Do -->
  <div class="col-sm-6 col-md-4 col-lg-3">
    <div class="card course-box widget-course">
      <div class="card-body">
        <div class="course-widget">
          <div class="course-icon warning">
            <i class="fa fa-tasks text-white fs-3"></i>
          </div>
          <div>
            <h4 class="mb-0">30</h4>
            <span class="f-light">To Do</span>
          </div>
        </div>
      </div>
      <ul class="square-group">
        <li class="square-1 warning"></li>
        <li class="square-1 primary"></li>
        <li class="square-2 warning1"></li>
        <li class="square-3 danger"></li>
        <li class="square-4 light"></li>
        <li class="square-5 warning"></li>
        <li class="square-6 success"></li>
        <li class="square-7 success"></li>
      </ul>
    </div>
  </div>

  <!-- Card 3: In Progress -->
  <div class="col-sm-6 col-md-4 col-lg-3">
    <div class="card course-box widget-course">
      <div class="card-body">
        <div class="course-widget">
          <div class="course-icon warning">
            <i class="fa fa-spinner fa-spin text-white fs-3"></i>
          </div>
          <div>
            <h4 class="mb-0">5</h4>
            <span class="f-light">In Progress</span>
          </div>
        </div>
      </div>
      <ul class="square-group">
        <li class="square-1 warning"></li>
        <li class="square-1 primary"></li>
        <li class="square-2 warning1"></li>
        <li class="square-3 danger"></li>
        <li class="square-4 light"></li>
        <li class="square-5 warning"></li>
        <li class="square-6 success"></li>
        <li class="square-7 success"></li>
      </ul>
    </div>
  </div>

  <!-- Card 4: Done -->
  <div class="col-sm-6 col-md-4 col-lg-3">
    <div class="card course-box widget-course">
      <div class="card-body">
        <div class="course-widget">
          <div class="course-icon warning">
            <i class="fa fa-check-circle text-white fs-3"></i>
          </div>
          <div>
            <h4 class="mb-0">2</h4>
            <span class="f-light">Done</span>
          </div>
        </div>
      </div>
      <ul class="square-group">
        <li class="square-1 warning"></li>
        <li class="square-1 primary"></li>
        <li class="square-2 warning1"></li>
        <li class="square-3 danger"></li>
        <li class="square-4 light"></li>
        <li class="square-5 warning"></li>
        <li class="square-6 success"></li>
        <li class="square-7 success"></li>
      </ul>
    </div>
  </div>

</div>


  <div class="row">
  <!-- Project Summary Column -->
  <div class="col-xl-8">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom">
        <h5 class="fw-semibold text-dark mb-0">
          <i class="fa fa-folder-open me-2 text-primary"></i>My Projects
        </h5>
        <span class="badge bg-light text-dark">3 Projects</span>
      </div>
      <div class="card-body p-3" style="max-height: 560px; overflow-y: auto;">
        <div class="row g-3">
          <!-- Project 1 -->
          <div class="col-md-6 col-xl-6">
            <div class="card shadow-sm border-0 h-100">
              <div class="card-body">
                <h5 class="card-title d-flex justify-content-between align-items-center">
                  Project Alpha
                  <span class="badge bg-success">Active</span>
                </h5>
                <p class="text-muted small">Developing the main dashboard and authentication modules.</p>
                <ul class="list-unstyled mb-2">
                  <li><strong>Pending:</strong> 4 tasks</li>
                  <li><strong>Done:</strong> 6 tasks</li>
                </ul>
                <div class="progress" style="height: 6px;">
                  <div class="progress-bar bg-success" style="width: 60%;"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Project 2 -->
          <div class="col-md-6 col-xl-6">
            <div class="card shadow-sm border-0 h-100">
              <div class="card-body">
                <h5 class="card-title d-flex justify-content-between align-items-center">
                  Project Beta
                  <span class="badge bg-secondary">Done</span>
                </h5>
                <p class="text-muted small">Completed refactor and testing of API modules.</p>
                <ul class="list-unstyled mb-2">
                  <li><strong>Pending:</strong> 0 tasks</li>
                  <li><strong>Done:</strong> 10 tasks</li>
                </ul>
                <div class="progress" style="height: 6px;">
                  <div class="progress-bar bg-secondary" style="width: 100%;"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Project 3 -->
          <div class="col-md-6 col-xl-6">
            <div class="card shadow-sm border-0 h-100">
              <div class="card-body">
                <h5 class="card-title d-flex justify-content-between align-items-center">
                  Project Gamma
                  <span class="badge bg-warning text-dark">Pending</span>
                </h5>
                <p class="text-muted small">Awaiting kick-off approval and resource assignment.</p>
                <ul class="list-unstyled mb-2">
                  <li><strong>Pending:</strong> 10 tasks</li>
                  <li><strong>Done:</strong> 0 tasks</li>
                </ul>
                <div class="progress" style="height: 6px;">
                  <div class="progress-bar bg-warning" style="width: 0%;"></div>
                </div>
              </div>
            </div>
          </div>

          
        </div> <!-- /.row -->
      </div>
    </div>
  </div>

 <!-- My Task Column -->
<div class="col-xl-4">
  <div class="card shadow-sm border-0 h-100 d-flex flex-column">
    <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom">
      <h5 class="fw-semibold text-dark mb-0">
        <i class="fa fa-check-circle me-2 text-primary"></i>My Task
      </h5>
      <span class="badge bg-light text-dark">7 Tasks</span>
    </div>

    <!-- Scrollable body with fixed height -->
    <div class="card-body p-3 overflow-auto" style="max-height: 460px;">
      <ol class="ps-2 mb-0">
        <li class="mb-4 border-bottom pb-2">
          <div class="d-flex justify-content-between align-items-center">
            <span class="fw-semibold text-primary">Fix dashboard alignment</span>
            <div class="d-flex gap-2">
              <span class="badge bg-danger">High</span>
              <span class="badge bg-warning text-dark">Bug</span>
            </div>
          </div>
          <small class="text-muted">Project: Pulse Board</small>
        </li>
        <li class="mb-4 border-bottom pb-2">
          <div class="d-flex justify-content-between align-items-center">
            <span class="fw-semibold text-primary">Update login validation</span>
            <div class="d-flex gap-2">
              <span class="badge bg-warning text-dark">Medium</span>
              <span class="badge bg-success">Improvement</span>
            </div>
          </div>
          <small class="text-muted">Project: UserAuth Module</small>
        </li>
        <li class="mb-4 border-bottom pb-2">
          <div class="d-flex justify-content-between align-items-center">
            <span class="fw-semibold text-primary">Design Kanban board</span>
            <div class="d-flex gap-2">
              <span class="badge bg-danger">High</span>
              <span class="badge bg-info text-dark">Feature</span>
            </div>
          </div>
          <small class="text-muted">Project: Task Manager</small>
        </li>
        <li class="mb-4 border-bottom pb-2">
          <div class="d-flex justify-content-between align-items-center">
            <span class="fw-semibold text-primary">Connect task API</span>
            <div class="d-flex gap-2">
              <span class="badge bg-warning text-dark">Medium</span>
              <span class="badge bg-success">Improvement</span>
            </div>
          </div>
          <small class="text-muted">Project: API Gateway</small>
        </li>
        <li class="mb-4 border-bottom pb-2">
          <div class="d-flex justify-content-between align-items-center">
            <span class="fw-semibold text-primary">Create registration form</span>
            <div class="d-flex gap-2">
              <span class="badge bg-success">Low</span>
              <span class="badge bg-info text-dark">Feature</span>
            </div>
          </div>
          <small class="text-muted">Project: Onboarding</small>
        </li>
        <li class="mb-4 border-bottom pb-2">
          <div class="d-flex justify-content-between align-items-center">
            <span class="fw-semibold text-primary">Test notification system</span>
            <div class="d-flex gap-2">
              <span class="badge bg-danger">High</span>
              <span class="badge bg-warning text-dark">Bug</span>
            </div>
          </div>
          <small class="text-muted">Project: Core Alerts</small>
        </li>
        <li class="mb-4 border-bottom pb-2">
          <div class="d-flex justify-content-between align-items-center">
            <span class="fw-semibold text-primary">Add another test task</span>
            <div class="d-flex gap-2">
              <span class="badge bg-warning text-dark">Medium</span>
              <span class="badge bg-success">Improvement</span>
            </div>
          </div>
          <small class="text-muted">Project: Core Alerts</small>
        </li>
      </ol>
    </div>
  </div>
</div>



</div>



  </div>
</div>

<?= $this->endSection() ?>
