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
                    <form class="needs-validation" novalidate="" action="<?= base_url('project/project/createProject') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="row g-3 mb-3">
                      <div class="col-md-6">
                        <label class="form-label" for="name">Project Name</label>
                        <input class="form-control" id="name" name="name" type="text" placeholder="Enter project name" required="">
                      </div>
                      <div class="col-md-6">
                        <label class="form-label" for="orgID">Organization</label>
                        <select class="form-select" id="orgID" name="orgID">
                          <option selected="" disabled="" value="">Choose Organization...</option>
                          <?php foreach ($organizations as $organization) : ?>
                            <option value="<?= $organization['orgID']?>"><?=$organization['name']?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="row g-3 mb-3">
                      <div class="col-md-6">
                        <label class="form-label" for="deptID">Department</label>
                        <select class="form-select" id="deptID" name="deptID">
                          <option selected="" disabled="" value="">Choose Department...</option>
                          <?php foreach ($departments as $department) :?>
                            <option value="<?= $department['deptID']?>"><?= $department['name']?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label" for="clientID">Client</label>
                        <select class="form-select" id="clientID" name="clientID">
                          <option selected="" disabled="" value="">Choose Client...</option>
                            <?php foreach ($clients as $client) :?>
                                <option value="<?= $client['clientID']?>"><?= $client['name']?></option>
                            <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="row g-3 mb-3">
                      <div class="col-md-6">
                        <label class="form-label" for="startDate">Start Date</label>
                        <input class="form-control" id="startDate" name="startDate" type="date" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please provide a start date.</div>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label" for="endDate">End Date</label>
                        <input class="form-control" id="endDate" name="endDate" type="date">
                      </div>

                      <div class="col-md-6 ">
                        <label class="form-label" for="status">Project Status</label>
                        <select class="form-select" id="status" name="status" required="">
                          <option selected="" disabled="" value="">Choose Status...</option>
                          <option value="planning">Planning</option>
                          <option value="active">Active</option>
                          <option value="completed">Completed</option>
                          <option value="cancelled">Cancelled</option>
                          <option value="archived">Archived</option>
                        </select>  
                      </div>

                      <div class="col-md-6">
                          <label for="contractValue">Contract Value (RM)</label>
                          <input class="form-control" id="contractValue" name="contractValue" type="number" step="0.01"
                              value="<?= esc($project['contractValue'] ?? '') ?>">
                      </div>

                      <div class="col-md-6">
                          <label for="cost">Cost (RM)</label>
                          <input class="form-control" id="cost" name="cost" type="number" step="0.01"
                              value="<?= esc($project['cost'] ?? '') ?>">
                      </div>

                    <div class="col-xs-12">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter project description here..." required></textarea>
                    </div>


                    </div>

                    <!-- User Assignments Section -->
                    <div class="row g-3 mb-3" id="user-assignments-wrapper">
                    <label class="form-label">Assign Users</label>

                    <div class="user-assignment row mb-2">
                        <div class="col-md-6">
                        <select name="userID[]" id="userID" class="form-select" required>
                            <option value="" disabled selected>Choose User...</option>
                            <?php foreach ($users as $user): ?>
                            <option value="<?= $user['userID'] ?>"><?= $user['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        </div>
                        <div class="col-md-4">
                        <select name="roles[]" class="form-select" required>
                            <option value="" disabled selected>Choose Role...</option>
                            <option value="manager">Manager</option>
                            <option value="developer">Developer</option>
                            <option value="qa">QA</option>
                        </select>
                        </div>
                        <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-remove-user">Remove</button>
                        </div>
                    </div>
                    </div>

                    <div class="mb-5">
                        <button type="button" class="btn btn-secondary" id="add-user">+ Add Another User</button>
                    </div>


                    <button class="btn btn-primary mt-3" type="submit">Create Project</button>
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


<?= $this->endSection() ?>
