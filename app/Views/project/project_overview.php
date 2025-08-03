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
        <div class="col-md-12 project-list">
            <div class="card">
                <div class="row">
                    <div class="col-md-6">
                        <!-- <ul class="nav nav-tabs border-tab" id="top-tab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-home" role="tab" aria-controls="top-home" aria-selected="true"><i data-feather="target"></i>All</a></li>
                            <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="false"><i data-feather="info"></i>Doing</a></li>
                            <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab" href="#top-contact" role="tab" aria-controls="top-contact" aria-selected="false"><i data-feather="check-circle"></i>Done</a></li>
                        </ul> -->
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-0 me-0"></div><a class="btn btn-primary" href="<?= base_url('project/project/create') ?>"> <i data-feather="plus-square"> </i>Create New Project</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start of Listing project card -->
        <div class="card">
        <div class="card-body">
        <div class="row">
           
            <!-- Project 1 -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="project-box border rounded-4 p-3 h-100">
                <span class="badge bg-primary mb-2">Doing</span>
                <h6>Endless Admin Design</h6>
                <div class="media mb-2">
                    <img class="img-20 me-2 rounded-circle" src="assets/images/user/3.jpg" alt="">
                    <div class="media-body">
                    <p class="mb-0">Themeforest, Australia</p>
                    </div>
                </div>
                <p>Lorem Ipsum is simply dummy text of the printing industry.</p>
                <div class="row details mb-2">
                    <div class="col-6"><span>Total Task</span></div>
                    <div class="col-6 text-primary">12</div>
                    <div class="col-6"><span>Total Open Task</span></div>
                    <div class="col-6 text-primary">5</div>
                    <div class="col-6"><span>Total Resolved </span></div>
                    <div class="col-6 text-primary">7</div>
                </div>
                <div class="project-status mt-2">
                    <div class="media mb-1">
                    <p class="mb-0">70%</p>
                    <div class="media-body text-end"><span>Done</span></div>
                    </div>
                    <div class="progress" style="height: 5px;">
                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" style="width: 70%;"></div>
                    </div>
                </div>
                </div>
            </div>

            <!-- Project 2 -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="project-box border rounded-4 p-3 h-100">
                <span class="badge bg-success mb-2">Active</span>
                <h6>Inventory Revamp</h6>
                <div class="media mb-2">
                    <img class="img-20 me-2 rounded-circle" src="assets/images/user/4.jpg" alt="">
                    <div class="media-body">
                    <p class="mb-0">Internal Project</p>
                    </div>
                </div>
                <p>Modernizing the inventory and adding analytics module.</p>
                <div class="row details mb-2">
                    <div class="col-6"><span>Total Task</span></div>
                    <div class="col-6 text-primary">8</div>
                    <div class="col-6"><span>Total Open Task</span></div>
                    <div class="col-6 text-primary">6</div>
                    <div class="col-6"><span>Total Resolved</span></div>
                    <div class="col-6 text-primary">9</div>
                </div>
                <div class="project-status mt-2">
                    <div class="media mb-1">
                    <p class="mb-0">80%</p>
                    <div class="media-body text-end"><span>In Progress</span></div>
                    </div>
                    <div class="progress" style="height: 5px;">
                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width: 80%;"></div>
                    </div>
                </div>
                </div>
            </div>

            <!-- Project 3 -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="project-box border rounded-4 p-3 h-100">
                <span class="badge bg-danger mb-2">Urgent</span>
                <h6>API Gateway Fix</h6>
                <div class="media mb-2">
                    <img class="img-20 me-2 rounded-circle" src="assets/images/user/5.jpg" alt="">
                    <div class="media-body">
                    <p class="mb-0">Client XYZ, Malaysia</p>
                    </div>
                </div>
                <p>Resolve connectivity issue with legacy API endpoints.</p>
                <div class="row details mb-2">
                    <div class="col-6"><span>Total Task</span></div>
                    <div class="col-6 text-primary">15</div>
                    <div class="col-6"><span>Total Open Task</span></div>
                    <div class="col-6 text-primary">4</div>
                    <div class="col-6"><span>Total Resolved</span></div>
                    <div class="col-6 text-primary">11</div>
                </div>
                <div class="project-status mt-2">
                    <div class="media mb-1">
                    <p class="mb-0">45%</p>
                    <div class="media-body text-end"><span>Stalled</span></div>
                    </div>
                    <div class="progress" style="height: 5px;">
                    <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" style="width: 45%;"></div>
                    </div>
                </div>
                </div>
            </div>

            <!-- Project 4 -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="project-box border rounded-4 p-3 h-100">
                <span class="badge bg-info text-dark mb-2">Planned</span>
                <h6>Onboarding System</h6>
                <div class="media mb-2">
                    <img class="img-20 me-2 rounded-circle" src="assets/images/user/1.jpg" alt="">
                    <div class="media-body">
                    <p class="mb-0">HR Department</p>
                    </div>
                </div>
                <p>Create flow for new employee onboarding and training.</p>
                <div class="row details mb-2">
                    <div class="col-6"><span>Total Task</span></div>
                    <div class="col-6 text-primary">3</div>
                    <div class="col-6"><span>Total Open Task</span></div>
                    <div class="col-6 text-primary">1</div>
                    <div class="col-6"><span>Total Resolved</span></div>
                    <div class="col-6 text-primary">4</div>
                </div>

                <div class="project-status mt-2">
                    <div class="media mb-1">
                    <p class="mb-0">10%</p>
                    <div class="media-body text-end"><span>Not Started</span></div>
                    </div>
                    <div class="progress" style="height: 5px;">
                    <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" style="width: 10%;"></div>
                    </div>
                </div>
                </div>
            </div>

            <!-- Project 5 -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="project-box border rounded-4 p-3 h-100">
                <span class="badge bg-secondary mb-2">Archived</span>
                <h6>Legacy Report Migration</h6>
                <div class="media mb-2">
                    <img class="img-20 me-2 rounded-circle" src="assets/images/user/8.jpg" alt="">
                    <div class="media-body">
                    <p class="mb-0">Finance Dept.</p>
                    </div>
                </div>
                <p>Migrated 2018–2021 reports into unified database.</p>
                <div class="row details mb-2">
                    <div class="col-6"><span>Total Task</span></div>
                    <div class="col-6 text-primary">0</div>
                    <div class="col-6"><span>Total Open Task</span></div>
                    <div class="col-6 text-primary">10</div>
                    <div class="col-6"><span>Total Resolved</span></div>
                    <div class="col-6 text-primary">2</div>
                </div>

                <div class="project-status mt-2">
                    <div class="media mb-1">
                    <p class="mb-0">100%</p>
                    <div class="media-body text-end"><span>Completed</span></div>
                    </div>
                    <div class="progress" style="height: 5px;">
                    <div class="progress-bar bg-secondary progress-bar-striped progress-bar-animated" style="width: 100%;"></div>
                    </div>
                </div>
                </div>
            </div>

            <!-- Project 6 -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="project-box border rounded-4 p-3 h-100">
                <span class="badge bg-warning text-dark mb-2">Pending</span>
                <h6>Sticker Order Portal</h6>
                <div class="media mb-2">
                    <img class="img-20 me-2 rounded-circle" src="assets/images/user/9.jpg" alt="">
                    <div class="media-body">
                    <p class="mb-0">Logistics Unit</p>
                    </div>
                </div>
                <p>Build sticker tracking & reorder feature for field ops.</p>
                <div class="row details mb-2">
                    <div class="col-6"><span>Total Task</span></div>
                    <div class="col-6 text-primary">6</div>
                    <div class="col-6"><span>Total Open Task</span></div>
                    <div class="col-6 text-primary">2</div>
                    <div class="col-6"><span>Total Resolved</span></div>
                    <div class="col-6 text-primary">5</div>
                </div>
                <div class="project-status mt-2">
                    <div class="media mb-1">
                    <p class="mb-0">25%</p>
                    <div class="media-body text-end"><span>Pending</span></div>
                    </div>
                    <div class="progress" style="height: 5px;">
                    <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" style="width: 25%;"></div>
                    </div>
                </div>
                </div>
            </div>

            <?php foreach ($projects as $project): ?>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="project-box border rounded-4 p-3 h-100">
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

                        <div class="project-status mt-2">
                            <div class="media mb-1">
                                <p class="mb-0">0%</p>
                                <div class="media-body text-end"><span><?= esc($project['status']) ?></span></div>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" style="width: 0%;"></div>
                            </div>
                        </div>
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
