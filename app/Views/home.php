<?= $this->extend('layout/master') ?>

<?= $this->section('main-content') ?>
<div class="container-fluid mb-5"><!-- Added mb-5 for footer spacing -->
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
              <h4 class="mb-0"><?= $totalProjects ?></h4>
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
              <h4 class="mb-0"><?= $toDo ?></h4>
              <span class="f-light">To Do</span>
            </div>
          </div>
        </div>
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
              <h4 class="mb-0"><?= $inProgress ?></h4>
              <span class="f-light">In Progress</span>
            </div>
          </div>
        </div>
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
              <h4 class="mb-0"><?= $done ?></h4>
              <span class="f-light">Done</span>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div> <!-- /.row -->

  <div class="row mt-4">
    <!-- Project Summary Column -->
    <div class="col-xl-8">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom">
          <h5 class="fw-semibold text-dark mb-0">
            <i class="fa fa-folder-open me-2 text-primary"></i>My Projects
          </h5>
          <span class="badge bg-light text-dark"><?= count($myProjects) ?> Projects</span>
        </div>
        <div class="card-body p-3" style="max-height: 560px; overflow-y: auto;">
          <div class="row g-3">

            <?php if (!empty($myProjects)): ?>
              <?php foreach ($myProjects as $project): 
                $totalTasks = ($project['doneTasks'] + $project['pendingTasks']);
                $progress = ($totalTasks > 0) ? round(($project['doneTasks'] / $totalTasks) * 100) : 0;
                $badgeClass = $project['status'] == 'Active' ? 'success' 
                            : ($project['status']=='Pending' ? 'warning text-dark' : 'secondary');
              ?>
              <div class="col-md-6 col-xl-6">
                <div class="card shadow-sm border-0 h-100">
                  <div class="card-body">
                    <h5 class="card-title d-flex justify-content-between align-items-center">
                      <?= esc($project['name']) ?>
                      <span class="badge bg-<?= $badgeClass ?>"><?= esc($project['status']) ?></span>
                    </h5>
                    <p class="text-muted small"><?= esc($project['description'] ?? 'No description') ?></p>
                    <ul class="list-unstyled mb-2">
                      <li><strong>Pending:</strong> <?= $project['pendingTasks'] ?> tasks</li>
                      <li><strong>Done:</strong> <?= $project['doneTasks'] ?> tasks</li>
                    </ul>
                    <div class="progress" style="height: 6px;">
                      <div class="progress-bar bg-<?= $badgeClass ?>" style="width: <?= $progress ?>%;"></div>
                    </div>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            <?php else: ?>
              <p class="text-muted ps-3">No projects assigned yet.</p>
            <?php endif; ?>

          </div>
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
          <span class="badge bg-light text-dark"><?= count($myTasks) ?> Tasks</span>
        </div>

        <div class="card-body p-3 overflow-auto" style="max-height: 460px;">
          <ol class="ps-2 mb-0">
            <?php if (!empty($myTasks)): ?>
              <?php foreach ($myTasks as $task): ?>
                <li class="mb-4 border-bottom pb-2">
                  <div class="d-flex justify-content-between align-items-center">
                    <a href="<?= base_url('board/task/view/'.$task['taskID']) ?>" 
                       target="_blank" 
                       class="fw-semibold text-primary">
                      <?= esc($task['name']) ?>
                    </a>
                    <div class="d-flex gap-2">
                      <!-- Priority -->
                      <span class="badge bg-<?= $task['priority']=='High' ? 'danger' : ($task['priority']=='Medium'?'warning text-dark':'success') ?>">
                        <?= esc($task['priority']) ?>
                      </span>
                      <!-- Status -->
                      <span class="badge bg-<?= 
                          in_array($task['status'], ['Done','Completed']) ? 'success' :
                          ($task['status']=='In Progress' ? 'info text-dark' : 'secondary')
                      ?>">
                        <?= esc($task['status']) ?>
                      </span>
                      <!-- Type -->
                      <span class="badge bg-info text-dark"><?= esc($task['type'] ?? 'Task') ?></span>
                    </div>
                  </div>
                  <small class="text-muted">
                    Project: <?= esc($task['projectName'] ?? 'Unknown') ?>
                  </small>
                </li>
              <?php endforeach; ?>
            <?php else: ?>
              <p class="text-muted ps-2">No tasks assigned to you.</p>
            <?php endif; ?>
          </ol>
        </div>
      </div>
    </div>

  </div> 
</div>
<?= $this->endSection() ?>
