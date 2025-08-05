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
        <div class="row project-cards">
            <?php if (session()->get('role') === 'admin'): ?>
        <div class="col-md-12 project-list">
            <div class="card">
                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-0 me-0"></div><a class="btn btn-primary" href="<?= base_url('admin/createUser') ?>"> <i data-feather="plus-square"> </i>Create New User</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        </div>
     </div>

  <div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
      <table class="table table-hover align-middle table-striped table-sm" id="userTable" style="width:100%">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
  $(document).ready(function () {
    $('#userTable').DataTable({
      processing: true,
      serverSide: true,
      ajax: "<?= base_url('admin/usersAjax') ?>",
      columns: [
        { data: 'no' },
        { data: 'username' },
        { data: 'email' },
        { data: 'role',
          render: function (data, type, row) {
            return data.charAt(0).toUpperCase() + data.slice(1);
          }
        },
        {
          data: null,
          orderable: false,
          searchable: false,
          render: function (data, type, row) {
            const editUrl = "<?= base_url('admin/editUser') ?>/" + data.id;
            const deleteUrl = "<?= base_url('admin/deleteUser') ?>/" + data.id;
            return `
              <a href="${editUrl}" class="btn btn-sm btn-warning me-1" title="Edit">
                <i data-feather="edit"></i>
              </a>
              <a href="${deleteUrl}" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this user?')">
                <i data-feather="trash-2"></i>
              </a>
            `;
          }
        }
      ],
      drawCallback: function(settings) {
        if (window.feather) {
          feather.replace();
        }
      }
    });
  });
</script>
<?= $this->endSection() ?>
