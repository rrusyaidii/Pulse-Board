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
                        <!-- <ul class="nav nav-tabs border-tab" id="top-tab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-home" role="tab" aria-controls="top-home" aria-selected="true"><i data-feather="target"></i>All</a></li>
                            <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="false"><i data-feather="info"></i>Doing</a></li>
                            <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab" href="#top-contact" role="tab" aria-controls="top-contact" aria-selected="false"><i data-feather="check-circle"></i>Done</a></li>
                        </ul> -->
        </div>

        <!-- Start of Listing project card -->
        <div class="card">
        <div class="card-body">
        <div class="row">
           <div class="col-sm-12">
                    <form class="needs-validation" novalidate="" action="<?= base_url('project/project/updateProject/' . $project['projectID']) ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="row g-3 mb-3">
                      <div class="col-md-6">
                        <label class="form-label" for="name">Project Name</label>
                        <input class="form-control" id="name" name="name" type="text" value="<?= esc($project['name']) ?>" readonly>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="orgID">Organization</label>
                        <?php
                            $orgName = '';
                            foreach ($organizations as $org) {
                                if ($org['orgID'] == $project['orgID']) {
                                $orgName = $org['name'];
                                break;
                                }
                            }
                            ?>
                            <input class="form-control" type="text" value="<?= esc($orgName) ?>" readonly>
                            <input type="hidden" name="orgID" value="<?= $project['orgID'] ?>">
                      </div>
                    </div>

                    <div class="row g-3 mb-3">
                      <div class="col-md-6">
                        <label class="form-label" for="deptID">Department</label>
                        <?php
                            $deptName = '';
                            foreach ($departments as $dept) {
                                if ($dept['deptID'] == $project['deptID']) {
                                $deptName = $dept['name'];
                                break;
                                }
                            }
                            ?>
                            <input class="form-control" type="text" value="<?= esc($deptName) ?>" readonly>
                            <input type="hidden" name="deptID" value="<?= $project['deptID'] ?>">
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="clientID">Client</label>
                        <?php
                            $clientName = '';
                            foreach ($clients as $client) {
                                if ($client['clientID'] == $project['clientID']) {
                                $clientName = $client['name'];
                                break;
                                }
                            }
                            ?>
                            <input class="form-control" type="text" value="<?= esc($clientName) ?>" readonly>
                            <input type="hidden" name="clientID" value="<?= $project['clientID'] ?>">
                      </div>

                      <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="startDate">Start Date</label>
                            <input class="form-control" id="startDate" name="startDate" type="date" readonly
                            value="<?= $project['startDate'] ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="endDate">End Date</label>
                            <input class="form-control" id="endDate" name="endDate" type="date" readonly
                            value="<?= $project['endDate'] ?>">
                        </div>
                      </div>

                      <div class="col-md-6">
                            <label class="form-label" for="name">Project Status</label>
                            <input class="form-control" id="status" name="status" type="text" value="<?= esc(ucfirst($project['status'])) ?>" readonly>
                        </div>

                        <div class="col-md-6">
                        <label class="form-label" for="name">Contract Value (RM)</label>
                        <input class="form-control" id="contractValue" name="contractValue" type="text" value="<?= esc($project['contractValue']) ?>" readonly>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="name">Cost</label>
                        <input class="form-control" id="cost" name="cost" type="text" value="<?= esc($project['cost']) ?>" readonly>
                      </div>

                      <div class="col-xs-12">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter project description here..." readonly><?= isset($project['description']) ? esc($project['description']) : '' ?></textarea>
                      </div>
                    </div>

                    

                    <!-- User Assignments Section -->
                    <div class="row g-3 mb-3" id="user-assignments-wrapper">
                    <label class="form-label">Assign Users</label>

                    <?php foreach ($assignedUsers as $assigned): ?>
                    <div class="user-assignment row mb-2">
                    <div class="col-md-6">
                        <select name="userID[]" class="form-select" disabled>
                        <option value="" disabled>Choose User...</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['userID'] ?>" <?= $user['userID'] == $assigned['userID'] ? 'selected' : '' ?>>
                            <?= $user['name'] ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="roles[]" class="form-select" disabled>
                        <option value="" disabled>Choose Role...</option>
                        <option value="manager" <?= $assigned['role'] == 'manager' ? 'selected' : '' ?>>Manager</option>
                        <option value="developer" <?= $assigned['role'] == 'developer' ? 'selected' : '' ?>>Developer</option>
                        <option value="qa" <?= $assigned['role'] == 'qa' ? 'selected' : '' ?>>QA</option>
                        </select>
                    </div>
                    </div>
                    <?php endforeach; ?>

                    </div>



                    <button class="btn btn-primary mt-3" href="<?= base_url('/project/project') ?>">Back</button>
                    </form>
            </div>

        </div>
        </div>
        </div>
            <!-- End of Listing project card -->
    </div>
            <!-- End of project-cards -->

  </div>
<!-- End of container-fluid -->

</div>


<script>
document.getElementById('add-user').addEventListener('click', function () {
  let wrapper = document.getElementById('user-assignments-wrapper');
  let clone = wrapper.querySelector('.user-assignment').cloneNode(true);
  clone.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
  wrapper.appendChild(clone);
});

document.addEventListener('click', function (e) {
  if (e.target.classList.contains('btn-remove-user')) {
    let row = e.target.closest('.user-assignment');
    if (document.querySelectorAll('.user-assignment').length > 1) {
      row.remove();
    }
  }
});
</script>

<?php if (session()->getFlashdata('success')): ?>
  <script>
    swal({
      title: "Success",
      text: "<?= session('success') ?>",
      icon: "success",
      button: "OK",
    }).then(() => {
      window.location.href = "<?= base_url('/project/project') ?>"; 
    });
  </script>
<?php endif; ?>



<?= $this->endSection() ?>
