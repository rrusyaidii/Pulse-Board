<?= $this->extend('layout/master') ?>

<?= $this->section('main-content') ?>
<div class="container-fluid mb-5">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h3><?= $title ?></h3>
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

  <div class="row g-3 mt-3">

    <?php if (isset($totalProfit)): ?>
      <div class="col-sm-6 col-md-3">
        <div class="card shadow-sm border-0">
          <div class="card-body text-center">
            <h5>Total Revenue</h5>
            <h3 class="text-success">$<?= number_format($totalRevenue,2) ?></h3>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="card shadow-sm border-0">
          <div class="card-body text-center">
            <h5>Total Cost</h5>
            <h3 class="text-danger">$<?= number_format($totalCost,2) ?></h3>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="card shadow-sm border-0">
          <div class="card-body text-center">
            <h5>Total Profit</h5>
            <h3 class="text-primary">$<?= number_format($totalProfit,2) ?></h3>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="card shadow-sm border-0">
          <div class="card-body text-center">
            <h5>Total Projects</h5>
            <h3 class="text-dark"><?= $totalProjects ?></h3>
          </div>
        </div>
      </div>
    <?php else: ?>
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
        </div>
      </div>
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
    <?php endif; ?>

  </div> 

  <div class="row mt-4">
    <div class="col-xl-<?= isset($totalProfit) ? '12' : '8' ?>">
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
                  $status = strtolower($project['status']);
                  $badgeClass = match($status) {
                      'active' => 'bg-success',
                      'pending' => 'bg-warning text-dark',
                      'planning' => 'bg-info',
                      'on hold' => 'bg-primary',
                      'archived' => 'bg-secondary',
                      'cancelled' => 'bg-danger',
                      default => 'bg-dark'
                  };
              ?>
                <div class="col-md-<?= isset($totalProfit) ? '4' : '6' ?>">
                  <div class="project-box border rounded-4 p-3 pb-0 h-100">
                    <span class="badge <?= $badgeClass ?> mb-2"><?= ucfirst($status) ?></span>
                    <h6><?= esc($project['name']) ?></h6>

                    <?php if (isset($totalProfit)): ?>
                      <!-- Director View: Show financial info -->
                      <div class="row details mb-2">
                        <div class="col-6"><span>Contract Value</span></div>
                        <div class="col-6 text-success">$<?= number_format($project['contractValue'],2) ?></div>

                        <div class="col-6"><span>Cost</span></div>
                        <div class="col-6 text-danger">$<?= number_format($project['cost'],2) ?></div>

                        <div class="col-6"><span>Profit</span></div>
                        <div class="col-6 text-primary">$<?= number_format($project['profit'],2) ?></div>
                      </div>
                    <?php else: ?>
                      <!-- Normal User View: Task stats -->
                      <div class="row details mb-2">
                        <div class="col-6"><span>Total Task</span></div>
                        <div class="col-6 text-primary"><?= $project['totalTasks'] ?></div>

                        <div class="col-6"><span>In Progress</span></div>
                        <div class="col-6 text-primary"><?= $project['inProgressTasks'] ?></div>

                        <div class="col-6"><span>Total Completed</span></div>
                        <div class="col-6 text-primary"><?= $project['doneTasks'] ?></div>
                      </div>
                    <?php endif; ?>

                    <div class="project-status mt-2 mb-4">
                      <div class="media mb-1">
                        <p class="mb-0"><?= $project['percentage'] ?>%</p>
                        <div class="media-body text-end"><span><?= esc(ucwords($project['status'])) ?></span></div>
                      </div>
                      <div class="progress" style="height: 5px;">
                        <div class="progress-bar <?= $project['progressClass'] ?> progress-bar-striped progress-bar-animated" style="width: <?= $project['percentage'] ?>%;"></div>
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

    <?php if (!isset($totalProfit)): ?>
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
    <?php endif; ?>

  </div> 
</div>
<?= $this->endSection() ?>
