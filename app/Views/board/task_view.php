<?= $this->extend('layout/master') ?>
<?= $this->section('main-content') ?>

<div class="container-fluid">

  <!-- Breadcrumb -->
  <div class="page-title mb-4">
    <div class="row">
      <div class="col-6">
        <h3><?= $breadcrumbs ?? 'Task Details' ?></h3>
      </div>
      <div class="col-6">
        <ol class="breadcrumb justify-content-end">
          <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('board/task') ?>">Tasks</a></li>
          <li class="breadcrumb-item active">Task Details</li>
        </ol>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-12">

      <!-- Card 1: Task Info -->
      <div class="card mb-4">
        <div class="card-header">
          <h5>Task Information</h5>
        </div>
        <div class="card-body">
          <div class="row g-3">

            <!-- Left Column -->
            <div class="col-md-6">
              <!-- Task Name -->
              <div class="mb-3 row">
                <label class="col-sm-4 col-form-label">Task Name</label>
                <div class="col-sm-8">
                  <input class="form-control" value="<?= esc($task['name']) ?>" disabled>
                </div>
              </div>

              <!-- Project -->
              <div class="mb-3 row">
                <label class="col-sm-4 col-form-label">Project</label>
                <div class="col-sm-8">
                  <input class="form-control" value="<?= esc($project['name'] ?? 'N/A') ?>" disabled>
                </div>
              </div>

              <!-- Sprint -->
              <div class="mb-3 row">
                <label class="col-sm-4 col-form-label">Sprint</label>
                <div class="col-sm-8">
                  <input class="form-control" 
                         value="<?= !empty($task['sprintID']) ? 'Sprint '.$task['sprintID'] : 'Backlog' ?>" 
                         disabled>
                </div>
              </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6">
              <!-- Assignee -->
              <div class="mb-3 row">
                <label class="col-sm-4 col-form-label">Assignee</label>
                <div class="col-sm-8">
                  <input class="form-control" value="<?= esc($assignee['name'] ?? 'Unassigned') ?>" disabled>
                </div>
              </div>

              <!-- Priority -->
              <div class="mb-3 row">
                <label class="col-sm-4 col-form-label">Priority</label>
                <div class="col-sm-8">
                  <input class="form-control" value="<?= esc($task['priority']) ?>" disabled>
                </div>
              </div>

              <!-- Type -->
              <div class="mb-3 row">
                <label class="col-sm-4 col-form-label">Type</label>
                <div class="col-sm-8">
                  <input class="form-control" value="<?= esc($task['type']) ?>" disabled>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- Card 2: Task Description -->
      <div class="card mb-4">
        <div class="card-header">
          <h5>Task Description</h5>
        </div>
        <div class="card-body">
          <div class="border p-3 rounded ">
            <?= !empty($task['description']) ? $task['description'] : '<em>No description provided.</em>' ?>
          </div>
        </div>
      </div>

      <!-- Buttons -->
      <div class="text-end mb-4">
        <a href="<?= base_url('board/task/edit/'.$task['taskID']) ?>" class="btn btn-warning">Edit Task</a>
        <a href="<?= base_url('board/task') ?>" class="btn btn-secondary">Back</a>
      </div>

    </div>
  </div>

</div>

<?= $this->endSection() ?>
