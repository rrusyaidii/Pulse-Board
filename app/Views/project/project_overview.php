<?= $this->extend('layout/master') ?>

<?= $this->section('main-content') ?>
<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h3><?= $breadcrumbs ?></h3>
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
  
  <!-- Start of container-fluid -->
  <div class="container-fluid">
    <!-- Start of project-cards -->
    <div class="row project-cards">
        <?php if (session()->get('role') === 'admin' || session()->get('role') === 'manager'): ?>
        <div class="col-md-12 project-list">
            <div class="card">
                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-0 me-0"></div><a class="btn btn-primary" href="<?= base_url('project/project/create') ?>"> <i data-feather="plus-square"> </i>Create New Project</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>



        <!-- Start of Listing project card -->
        <div class="card">
        <div class="card-body">
        <div class="row">

            <?php foreach ($projects as $project): ?>
                <?php
                    $currentProjectRole = $projectRoles[$project['projectID']] ?? null;
                    $userSessionRole = session()->get('role');
                ?>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="project-box border rounded-4 p-3 pb-0 h-100">
                        <?php
                            $status = strtolower($project['status']);
                            switch ($status) {
                                case 'active':
                                    $badgeClass = 'bg-success';
                                    break;
                                case 'planning':
                                    $badgeClass = 'bg-info';
                                    break;
                                case 'archived':
                                    $badgeClass = 'bg-secondary';
                                    break;
                                default:
                                    $badgeClass = 'bg-primary';
                            }
                        ?>
                        <span class="badge <?= $badgeClass ?> mb-2"><?= ucfirst($status) ?></span>
                        <h6><?= esc($project['name']) ?></h6>

                        <div class="media-body media mb-3 text-muted">
                            <p class="mb-0"><?= esc($project['clientName']) ?></p>
                        </div>


                       <?php
                        $stats = $taskStats[$project['projectID']] ?? [
                            'total_tasks' => 0,
                            'in_progress' => 0,
                            'total_completed' => 0,
                            'contractValue' => 0,
                        ];

                        $stats['contractValue'] = $project['contractValue'] ?? 0;
                        $stats['cost'] = $project['cost'] ?? 0;

                        $percentage = $stats['total_tasks'] > 0
                            ? round(($stats['total_completed'] / $stats['total_tasks']) * 100)
                            : 0;

                        // Profit adjusted based on percentage
                        $rawProfit = $stats['contractValue'] - $stats['cost'];
                        $adjustedProfit = round($rawProfit * ($percentage / 100));

                        // Progress bar color
                        $progressClass = 'bg-danger'; // red
                        if ($percentage > 30 && $percentage < 70) {
                            $progressClass = 'bg-warning'; // yellow
                        } elseif ($percentage >= 70) {
                            $progressClass = 'bg-success'; // green
                        }
                        ?>

                        <div class="row details mb-2">
                            <div class="col-6"><span>Total Task</span></div>
                            <div class="col-6 text-primary"><?= $stats['total_tasks'] ?></div>

                            <div class="col-6"><span>In Progress</span></div>
                            <div class="col-6 text-primary"><?= $stats['in_progress'] ?></div>

                            <div class="col-6"><span>Total Completed</span></div>
                            <div class="col-6 text-primary"><?= $stats['total_completed'] ?></div>

                            <div class="col-6"><span>Contract Value</span></div>
                            <div class="col-6 text-primary">RM <?= number_format($stats['contractValue'], 0) ?></div>

                            <div class="col-6"><span>Current Profit</span></div>
                            <div class="col-6 text-primary">RM <?= number_format($adjustedProfit, 0) ?></div>
                        </div>

                        <div class="project-status mt-2 mb-4">
                            <div class="media mb-1">
                                <p class="mb-0"><?= $percentage ?>%</p>
                                <div class="media-body text-end"><span><?= esc(ucwords($project['status'])) ?></span></div>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar <?= $progressClass ?> progress-bar-striped progress-bar-animated" style="width: <?= $percentage ?>%;"></div>
                            </div>
                        </div>


                    <?php if ($userSessionRole === 'admin' || $currentProjectRole === 'manager'): ?>
                        <a class="btn btn-primary" href="<?= base_url('project/project/edit/'.$project['projectID']) ?>">Edit</a>
                    <?php endif; ?>
                    <a class="btn btn-primary me-1" href="<?= base_url('project/project/view/'.$project['projectID']) ?>">View</a>

                    </div>
                </div>
            <?php endforeach; ?>


        </div>
        </div>
        </div>
            <!-- End of Listing project card -->
    </div>
            <!-- End of project-cards -->

  </div>
<!-- End of container-fluid -->

</div>

<?= $this->endSection() ?>
