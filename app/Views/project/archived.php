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
        <?php if (session()->get('role') === 'admin'): ?>
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

                        <p><?= esc($project['description'] ?? 'No description provided.') ?></p>

                        <div class="row details mb-2">
                            <div class="col-6"><span>Total Task</span></div>
                            <div class="col-6 text-primary">0</div>
                            <div class="col-6"><span>Total Open Task</span></div>
                            <div class="col-6 text-primary">0</div>
                            <div class="col-6"><span>Total Resolved</span></div>
                            <div class="col-6 text-primary">0</div>
                        </div>

                        <div class="project-status mt-2 mb-4">
                            <div class="media mb-1">
                                <p class="mb-0">0%</p>
                                <div class="media-body text-end"><span><?= esc($project['status']) ?></span></div>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" style="width: 0%;"></div>
                            </div>
                        </div>


                    <?php if (session()->get('role') === 'admin'): ?>
                        <a class="btn btn-primary" href="<?= base_url('project/project/edit/'.$project['projectID'] ) ?>">Edit</a>
                    <?php endif; ?>

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
