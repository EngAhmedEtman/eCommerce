<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="text-primary"><?php echo $pageTitle; ?></h1>
        <a href="members.php?do=add" class="btn btn-success">
            <i class="bi bi-person-plus"></i> Add New Member
        </a>
    </div>

    <?php showMessage(); ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Date</th>
                        <th>Control</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($members as $member): ?>
                        <tr>
                            <td><?php echo $member['id']; ?></td>
                            <td><?php echo htmlspecialchars($member['Username']); ?></td>
                            <td><?php echo htmlspecialchars($member['Email']); ?></td>
                            <td><?php echo htmlspecialchars($member['FullName']); ?></td>
                            <td><?php echo htmlspecialchars($member['date']); ?></td>
                            <td>
                                <a href="members.php?do=edit&userid=<?php echo $member['id']; ?>"
                                    class="btn btn-sm btn-primary">Edit</a>
                                <a href="members.php?do=delete&userid=<?php echo $member['id']; ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('هل انت متأكد من حذف هذا المستخدم؟')">Delete</a>
                                <?php if ($member['RegStatus'] == 0): ?>
                                    <a href="members.php?do=active&userid=<?php echo $member['id']; ?>"
                                        class="btn btn-sm btn-warning" onclick="return confirm('هل انت متأكد من تفعيل هذا المستخدم؟')">Active</a>

                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>