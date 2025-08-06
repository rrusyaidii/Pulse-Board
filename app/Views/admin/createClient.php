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
  
  <div class="container-fluid">
    <div class="row project-cards">
        <div class="col-md-12 project-list">
                        <!-- <ul class="nav nav-tabs border-tab" id="top-tab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-home" role="tab" aria-controls="top-home" aria-selected="true"><i data-feather="target"></i>All</a></li>
                            <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="false"><i data-feather="info"></i>Doing</a></li>
                            <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab" href="#top-contact" role="tab" aria-controls="top-contact" aria-selected="false"><i data-feather="check-circle"></i>Done</a></li>
                        </ul> -->
        </div>

        <div class="card">
        <div class="card-body">
        <div class="row">
           <div class="col-sm-12">
                    <form class="needs-validation" novalidate="" action="<?= base_url('admin/addClient') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <?php if (isset($client['clientID'])) : ?>
                      <input type="hidden" name="clientID" value="<?= esc($client['clientID']) ?>">
                    <?php endif; ?>

                    <div class="row g-3 mb-3">
                      <div class="col-md-6">
                        <label class="form-label" for="name">Name</label>
                        <input class="form-control" id="name" name="name" type="text" value="<?= isset($client['name']) ? $client['name'] : '' ?>" placeholder="<?= isset($client['name']) ? 'Enter Name' : 'Enter Name' ?>" required="">
                      </div>
                    </div>

                    <input type="hidden" id="status" name="status" value="active">
                    
                    <div class="row g-3 mb-3">
                      <div class="col-md-6">
                        <label class="form-label" for="address">Address</label>
                        <input class="form-control" id="address" name="address" type="text" value="<?= isset($client['address']) ? $client['address'] : '' ?>" placeholder="<?= isset($client['address']) ? 'Enter Address' : 'Enter Address' ?>" required="">
                      </div>
                    </div>

                    <button class="btn btn-primary mt-3" type="submit"><?= $title ?></button>
                    </form>
            </div>

        </div>
        </div>
        </div>
    </div>
  </div>

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
