<?php $this->layout('layouts::app', ['title' => 'users']) ?>

<?php $this->start('main') ?>
<h1>Users</h1>

<!-- Bootstrap CSS (if not in layout) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- 🔥 DATE MODAL -->
<div class="modal fade" id="dateModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enter Report Date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="userId" value="">
                <div class="mb-3">
                    <label class="form-label">Report Date:</label>
                    <input type="date" class="form-control" id="reportDate" value="<?= date('Y-m-d') ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="downloadWord()">Download Word</button>
            </div>
        </div>
    </div>
</div>
<?php include 'database.php'; ?>

<table id="usersTable" class="display">
    <thead>
        <tr><th>ID</th><th>Name</th><th>Role</th><th>Action</th></tr>
    </thead>
    <tbody>
        <?php
        $stmt = $pdo->query("SELECT id, name, role FROM users ORDER BY id");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . ($row['id'] ?? '-') . "</td>";
            echo "<td>" . ($row['name'] ?? '-') . "</td>";
            echo "<td>" . ($row['role'] ?? '-') . "</td>";
            echo "<td>";
            // 🔥 FIXED BUTTON - Proper PHP escaping
            echo "<button class='btn btn-sm btn-primary' onclick=\"openWordModal({$row['id']}, '{$row['name']}')\">📄 Word</button>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<!-- Scripts (load jQuery first) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

<script>
$(document).ready(function() {
    $('#usersTable').DataTable();
});

// 🔥 OPEN MODAL FUNCTION
function openWordModal(userId, userName) {
    document.getElementById('userId').value = userId;
    document.getElementById('reportDate').value = '<?= date('Y-m-d') ?>';

        // Bootstrap 5 modal show
        var modal = new bootstrap.Modal(document.getElementById('dateModal'));
        modal.show();
    }

    // 🔥 DOWNLOAD FUNCTION
    function downloadWord() {
        var userId = document.getElementById('userId').value;
        var reportDate = document.getElementById('reportDate').value;

        // FIXED PATH: From views/ → root export_user.php
        window.location.href = 'export_user.php?id=' + userId + '&date=' + reportDate;
    }
</script>

<?php $this->stop() ?>