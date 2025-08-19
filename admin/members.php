<?php
session_start();
$pageTitle = 'members';
/*
=================================
=== Manage members
=== edit | delete | Add
=================================
*/
include 'init.php';

auth('index.php');

// Show Edit Form
function showEditForm($mode = 'add', $row = null)
{
    $isEdit = ($mode === 'edit');
    $action = $isEdit ? "?do=update" : "?do=insert";
    $title  = $isEdit ? "Edit Member" : "Add Member";
?>
    <?php showMessage(); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg rounded-3">
                    <div class="card-body p-4">
                        <h1 class="text-center mb-4"><?php echo $title ?></h1>

                        <form action="<?= $action ?>" method="POST">
                            <?php if ($isEdit): ?>
                                <input type="hidden" name="userid" value="<?= $row['id'] ?>">
                            <?php endif; ?>
                            <!-- Username -->
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control"
                                    name="username"
                                    value="<?= $isEdit ? htmlspecialchars($row['Username']) : '' ?>"
                                    required>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label">Password</label>

                                <input type="hidden" name="oldPassword" value="<?= $row['password'] ?>" autocomplete="off">
                                <input type="password" class="form-control" name="newPassword" autocomplete="off" <?= !$isEdit ? 'required' : '' ?>>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control"
                                    name="email"
                                    value="<?= $isEdit ? htmlspecialchars($row['Email']) : '' ?>"
                                    required>
                            </div>

                            <!-- Full Name -->
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control"
                                    name="full"
                                    value="<?= $isEdit ?  htmlspecialchars($row['FullName']) : '' ?>"
                                    required>
                            </div>

                            <!-- Save Button -->
                            <div class="d-grid">
                                <input type="submit" value="<?= $isEdit ? 'Save' : 'Add' ?>" class="btn btn-primary">
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }



function renderMembersTable($rows)
{
?>
    <div class="container mt-5">
        <!-- عنوان -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="text-primary text-center">Manage Members</h1>
            <a href="members.php?do=add" class="btn btn-success">
                <i class="bi bi-person-plus"></i> Add New Member
            </a>
        </div>
        <!-- رسائل نجاح / خطأ -->
        <?php showMessage(); ?>
        <!-- جدول الأعضاء -->
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Full Name</th>
                            <th>date</th>
                            <th>Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row) : ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['Username']) ?></td>
                                <td><?= htmlspecialchars($row['Email']) ?></td>
                                <td><?= htmlspecialchars($row['FullName']) ?></td>
                                <td><?= htmlspecialchars($row['date']) ?></td>
                                <td>
                                    <a href="members.php?do=edit&userid=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="members.php?do=delete&userid=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل انت متأكد من الحذف ؟')">Delete</a>
                                    <?php if($row['RegStatus'] == 0 ): ?>
                                    <a href="members.php?do=active&userid=<?= $row['id'] ?>" class="btn btn-sm btn-warning" onclick="return confirm(' هل تريد تحديث حالة هذا المستخدم ؟')">Activate</a>

                                        <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



<?php }


include 'controller/membersController.php';
include $tpl . "footer.php";
