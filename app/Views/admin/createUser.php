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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  
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
                    <form class="needs-validation" novalidate="" action="<?= base_url('admin/addUser') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="row g-3 mb-3">
                      <div class="col-md-6">
                        <label class="form-label" for="name">Name</label>
                        <input class="form-control" id="name" name="name" type="text" value="<?= isset($user['name']) ? $user['name'] : '' ?>" placeholder="<?= isset($user['name']) ? 'Enter Name' : 'Enter Name' ?>" required="">
                      </div>
                    </div>

                    <input type="hidden" id="status" name="status" value="active">

                    <div class="row g-3 mb-3">
                      <div class="col-md-6">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" id="email" name="email" type="text" value="<?= isset($user['email']) ? $user['email'] : '' ?>" placeholder="<?= isset($user['email']) ? 'Enter Email' : 'Enter Email' ?>" required="">
                      </div>
                    </div>

                    <div class="row g-3 mb-3">
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
                    </div>

                    <div class="row g-3 mb-3">
                        
                      <div class="col-md-6">
                        <label class="form-label" for="role">Role</label>
                        <select class="form-select" id="role" name="role" value="<?= isset($user['role']) ? $user['role'] : '' ?>" placeholder="<?= isset($user['role']) ? 'Enter Role' : 'Enter Role' ?>">
                            <option selected disabled value="">Choose Role...</option>
                            <option value="manage">Manager</option>
                            <option value="user">User</option>
                        </select>
                      </div>
                    </div>

                    <div class="row g-3 mb-3">
                      <div class="col-md-6">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" value="<?= isset($user['password']) ? $user['password'] : '' ?>" placeholder="<?= isset($user['password']) ? 'Enter password' : 'Enter password' ?>">
                            <span class="input-group-text">
                            <i class="bi bi-eye-slash" id="togglePassword" style="cursor: pointer;"></i>
                            </span>
                        </div>
                      </div>

                    </div>

                    <button class="btn btn-primary mt-3" type="submit">Create User</button>
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
  document.addEventListener("DOMContentLoaded", function () {
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
      const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordField.setAttribute('type', type);
      this.classList.toggle('bi-eye');
      this.classList.toggle('bi-eye-slash');
    });

    // If you're using the Add/Remove user logic, keep it here too:
    const addUserBtn = document.getElementById('add-user');
    if (addUserBtn) {
      addUserBtn.addEventListener('click', function () {
        let wrapper = document.getElementById('user-assignments-wrapper');
        let clone = wrapper.querySelector('.user-assignment').cloneNode(true);
        clone.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
        wrapper.appendChild(clone);
      });
    }

  });
</script>



<?= $this->endSection() ?>
