<?= $this->extend('layout/master') ?>

<?= $this->section('head') ?>

<style>
    /* Board Container - MODIFIED FOR WRAPPING LAYOUT */
    .kanban-container {
        display: flex;
        flex-wrap: wrap; /* Allows columns to wrap to the next row */
        align-items: flex-start; /* Aligns columns at the top of each row */
        gap: 20px 0; /* Adds vertical spacing between rows */
        padding: 10px;
        background-color: #f0f2f5;
        border-radius: 8px;
    }

    /* Kanban Boards/Columns */
    .kanban-board {
        min-width: 280px;
        max-height: calc(100vh - 300px); /* Adjusted height slightly for better spacing */
        background-color: #e9ecef;
        border-radius: 8px;
        margin: 0 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
    }
    
    .kanban-title-board {
        font-weight: bold;
        padding: 15px;
        border-bottom: 1px solid #dee2e6;
        border-radius: 8px 8px 0 0;
        text-align: center;
    }

    /* This rule makes the task list scrollable */
    .kanban-drag {
        overflow-y: auto;
        flex: 1;
        min-height: 0;
    }

    /* Kanban Items/Cards */
    .kanban-item {
        background-color: #ffffff;
        padding: 12px;
        margin: 8px;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        cursor: grab;
    }
    
    .kanban-item:hover {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    /* Card content and meta info */
    .kanban-item-link {
        text-decoration: none;
        color: #333;
        display: block;
        margin-bottom: 8px;
    }
    .kanban-item-title {
        font-size: 1rem;
        font-weight: 500;
        line-height: 1.4;
    }
    .kanban-item-meta .badge,
    .kanban-item-details small {
        font-size: 0.75rem;
    }
    .kanban-item-meta .badge {
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 4px;
        text-transform: uppercase;
        margin-right: 5px;
    }
    
    /* Column Colors */
    .kanban-backlog .kanban-title-board { background-color: #f8f9fa; color: #212529; }
    .kanban-to-do .kanban-title-board { background-color: #0dcaf0; color: white; }
    .kanban-in-progress .kanban-title-board { background-color: #ffc107; color: black; }
    .kanban-in-review .kanban-title-board { background-color: #0d6efd; color: white; }
    .kanban-completed .kanban-title-board { background-color: #198754; color: white; }

    /* Priority Badges */
    .badge-danger { background-color: #dc3545; color: #fff; }
    .badge-warning { background-color: #ffc107; color: #343a40; }
    .badge-success { background-color: #28a745; color: #fff; }
    .badge-primary { background-color: #0d6efd; color: #fff; }
    .badge-secondary { background-color: #6c757d; color: #fff; }
</style>
<?= $this->endSection() ?>

<?= $this->section('main-content') ?>
<div class="container-fluid">

    <div class="page-title mb-4">
        <div class="row">
            <div class="col-6">
                <h3>Kanban Board</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="<?= base_url("/") ?>">
                        <svg class="stroke-icon">
                            <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#stroke-home"></use>
                        </svg></a>
                    </li>
                    <li class="breadcrumb-item">Apps</li>
                    <li class="breadcrumb-item active">Kanban Board</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Select Project</label>
                    <select class="form-select" id="projectSelect">
                        <option value="">Select Project</option>
                        <?php foreach ($projects as $project): ?>
                            <option value="<?= $project['projectID'] ?>"><?= esc($project['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Select Sprint</label>
                    <select class="form-select" id="sprintSelect">
                        <option value="all">All Sprints</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h5 id="projectTitle">Select Project to View Kanban</h5>
        </div>
        <div class="card-body">
            <div id="kanbanBoard">
                <p class="text-center text-muted">Select a project to view tasks.</p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function () {
    let kanbanBoard = null;

    // ✨ Define a reusable toast notification
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    function loadKanban(projectID, sprintID = '') {
        if (!projectID) {
            $('#kanbanBoard').html('<p class="text-center text-muted">Select a project to view tasks.</p>');
            return;
        }

        // Show a loading indicator
        $('#kanbanBoard').html('<div class="d-flex justify-content-center my-5"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        
        $.get('<?= base_url('board/kanban/kanbanData') ?>/' + projectID + '/' + sprintID, function(data) {
            $('#kanbanBoard').html(''); // Clear previous board

            if (data.length === 0) {
                $('#kanbanBoard').html('<p class="text-center text-muted">No tasks found for this project/sprint.</p>');
                return;
            }

            kanbanBoard = new jKanban({
                element: "#kanbanBoard",
                gutter: "15px",
                widthBoard: "280px",
                dragBoards: false,
                boards: data,
                dropEl: function(el, target) {
                    const taskID = $(el).data('eid');
                    const newStatusID = $(target).closest('.kanban-board').data('id');
                    updateStatus(taskID, newStatusID);
                }
            });
        }, 'json').fail(function() {
            $('#kanbanBoard').html('<p class="text-center text-danger">Failed to load Kanban data. Please try again.</p>');
            // ✨ Replaced Swal with Toast
            Toast.fire({ icon: 'error', title: 'Failed to load Kanban board data.' });
        });
    }

    function updateStatus(taskID, newStatusID) {
        $.post('<?= base_url('board/kanban/updateStatus') ?>', {
            'taskID': taskID,
            'status': newStatusID,
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        }, function(response) {
            if (response.status === 'success') {
                // ✨ Replaced Swal with Toast
                Toast.fire({ icon: 'success', title: response.message });
            } else {
                // ✨ Replaced Swal with Toast
                Toast.fire({ icon: 'error', title: response.message });
                // Reload the board to revert the card's position if the update failed
                const projectID = $('#projectSelect').val();
                const sprintID = $('#sprintSelect').val();
                loadKanban(projectID, sprintID);
            }
        }, 'json').fail(function() {
            // ✨ Replaced Swal with Toast
            Toast.fire({ icon: 'error', title: 'Connection error. Could not update status.' });
            const projectID = $('#projectSelect').val();
            const sprintID = $('#sprintSelect').val();
            loadKanban(projectID, sprintID);
        });
    }

    // Project selection -> load sprints and Kanban
    $('#projectSelect').change(function() {
        const projectID = $(this).val();
        
        $('#projectTitle').text(
            projectID 
            ? 'Kanban Board for Project ' + $('#projectSelect option:selected').text() 
            : 'Select Project to View Kanban'
        );

        $('#sprintSelect').html('<option value="all">All Sprints</option>');
        if (projectID) {
            $.get('<?= base_url('board/kanban/getSprints') ?>/' + projectID, function(res) {
                if (res.status === 'success' && res.sprints.length > 0) {
                    res.sprints.forEach(sprint => {
                        $('#sprintSelect').append(
                            `<option value="${sprint.sprintID}">${sprint.name} (${sprint.startDate} - ${sprint.endDate})</option>`
                        );
                    });
                }
            }, 'json');

            loadKanban(projectID);
        } else {
            $('#kanbanBoard').html('<p class="text-center text-muted">Select a project to view tasks.</p>');
        }
    });

    // Sprint selection -> reload Kanban board
    $('#sprintSelect').change(function() {
        const projectID = $('#projectSelect').val();
        const sprintID = $(this).val();
        if (projectID) {
            loadKanban(projectID, sprintID);
        }
    });
});
</script>
<?= $this->endSection() ?>