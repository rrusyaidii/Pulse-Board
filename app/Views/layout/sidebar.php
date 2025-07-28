<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
  <div>
    <!-- Logo Section -->
    <div class="logo-wrapper">
      <a href="<?= base_url("/") ?>">
        <img class="img-fluid for-light" src="<?= base_url() ?>/assets/images/logo/logo.png" alt="">
        <img class="img-fluid for-dark" src="<?= base_url() ?>/assets/images/logo/logo_dark.png" alt="">
      </a>
      <div class="back-btn"><i class="fa fa-angle-left"></i></div>
      <div class="toggle-sidebar">
        <i class="status_toggle middle sidebar-toggle" data-feather="grid"></i>
      </div>
    </div>

    <!-- Logo Icon -->
    <div class="logo-icon-wrapper">
      <a href="<?= base_url("/") ?>">
        <img class="img-fluid" src="<?= base_url() ?>/assets/images/logo/logo-icon.png" alt="">
      </a>
    </div>

    <!-- Sidebar Menu -->
    <nav class="sidebar-main">
      <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
      <div id="sidebar-menu">
        <ul class="sidebar-links" id="simple-bar">
          
          <!-- Back Button (Mobile View) -->
          <li class="back-btn">
            <div class="mobile-back text-end">
              <span>Back</span>
              <i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
            </div>
          </li>

          <!-- Dashboard Menu Item -->
          <li class="sidebar-list">
            <a class="sidebar-link sidebar-title" href="<?= base_url("home") ?>">
              
              <svg class="stroke-icon">
                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#stroke-home"></use>
              </svg>
              <svg class="fill-icon">
                <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#fill-home"></use>
              </svg>
              <span>Dashboard</span>
            </a>
          </li>
          <!-- End Dashboard Menu -->

          <!-- Project Menu with Submenu -->
          <li class="sidebar-list">
            <a class="sidebar-link sidebar-title" href="#">
            <i class="icon-bar-chart"></i>
              
              <span>Project</span>
            </a>
            <ul class="sidebar-submenu">
              <li><a href="<?= base_url("project/project") ?>">My Projects</a></li>
              <li><a href="<?= base_url() ?>">Archived Projects</a></li>
              <!-- <li><a href="<?= base_url() ?>">Departments Projects??</a></li> -->
            </ul>
          </li>
          <!-- End Project Menu -->

          <!-- Board Menu with Submenu -->
          <li class="sidebar-list">
            <a class="sidebar-link sidebar-title" href="#">
            <i class="icon-layout-grid2"></i>

              <span>Board</span>
            </a>
            <ul class="sidebar-submenu">
              <li><a href="<?= base_url("board/work_item") ?>">Work Items</a></li>
              <li><a href="<?= base_url("board/kanban") ?>">Board</a></li>
              <li><a href="<?= base_url("board/task") ?>">Task Overview</a></li>
              <li><a href="<?= base_url("board/sprints") ?>">Sprint Planning</a></li>
              <li><a href="<?= base_url("board/backlog") ?>">Backlog</a></li>
            </ul>
          </li>
          <!-- End Board Menu -->
        </ul>
      </div>
      <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </nav>
  </div>
</div>
