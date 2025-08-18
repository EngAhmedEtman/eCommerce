<?php
session_start();
$pageTitle = 'members';
/*
=================================
=== Manage members
=== edit | delete | Add
=================================
*/


if (!isset($_SESSION['username'])) {
    header('location: index.php');
    exit();
}
include 'init.php';


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
                                <input type="hidden" name="userid" value="<?= $row['UserID'] ?>">
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


$do = $_GET['do'] ?? 'manage';
switch ($do) {

    case 'manage':
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
                                <th>Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rows = showData();
                            foreach ($rows as $row) {
                                echo "<tr>";
                                echo "<td>" . $row['UserID'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['Username']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['FullName']) . "</td>";
                                echo "<td>
                        <a href='members.php?do=edit&userid=" . $row['UserID'] . "' class='btn btn-sm btn-primary'>Edit</a>
                        <a href='members.php?do=delete&userid=" . $row['UserID'] . "' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure?')\">Delete</a>
                    </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

<?php break;
    case 'add':
        showEditForm('add');
        break;

    case 'insert':

        // validation
        $data = [
            'id'       => $_POST['userid'] ?? '',
            'username' => $_POST['username'] ?? '',
            'email'    => $_POST['email'] ?? '',
            'full'     => $_POST['full'] ?? '',
            'password' => $_POST['newPassword'] ?? '',
        ];

        $labels = [
            'username' => 'اسم المستخدم',
            'email'    => 'البريد الإلكتروني',
            'full'     => 'الاسم الكامل',
            'password' => 'كلمة المرور',
        ];

        $rules = [
            'username' => ['require', 'min:3', 'max:20'],
            'email'    => ['require', 'email', 'max:100'],
            'full'     => ['require', 'min:6', 'max:50'],
            'password' => ['require', 'password'],
        ];

        $errors = validation($data, $rules, $labels);
        $url = "members.php?manage";
        checkErrors($errors, $url);
        if ((insertDataInDatabase())) {
            setMessage('success', 'تم انشاء المستخدم بنجاح');
            header('location:members.php?do=manage');
            exit();
        } else {
            setMessage('error', 'خطأ اثناء الاضافة');
            header('location:members.php?do=add');
            exit();
        }
        break;

    case 'edit':

        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        $row = getMemberById($userid);

        if ($row) {
            showEditForm('edit', $row);
        } else {
            echo "<div class='alert alert-danger'>User Not Found</div>";
        }
        break;


    case 'update':
        echo "<h1 class='text-center'>Update Member</h1>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $oldPassword = $_POST['oldPassword'];
            $newPassword = $_POST['newPassword'];
            $pass = checkNewPasswordFound($oldPassword, $newPassword);


            // validation
            $data = [
                'id'       => $_POST['userid'] ?? '',
                'username' => $_POST['username'] ?? '',
                'email'    => $_POST['email'] ?? '',
                'full'     => $_POST['full'] ?? '',
                'password' => $pass ?? '',
            ];

            $labels = [
                'username' => 'اسم المستخدم',
                'email'    => 'البريد الإلكتروني',
                'full'     => 'الاسم الكامل',
                'password' => 'كلمة المرور',
            ];

            $rules = [
                'username' => ['require', 'min:3', 'max:20'],
                'email'    => ['require', 'email', 'max:100'],
                'full'     => ['require', 'min:3', 'max:50'],
                'password' => ['password'],
            ];

            $errors = validation($data, $rules, $labels);
            $url = "members.php?do=edit&userid=" . $data['id'];
            checkErrors($errors, $url);


            if (updateMember($data) > 0) {
                // عشان الاسم يظهر في الــ navbar 
                // علطول بدون ما اسجل خروج وبعدها دخول
                // $_SESSION['username'] = $_POST['username'];

                setMessage('success', 'تم التعديل بنجاح');
                header("Location: members.php?do=manage");
                exit();
            } else {
                setMessage('error', 'خطأ اثناء التعديل، ءلم يتم التعديل');
                header("Location: members.php?do=edit&userid=" . $data['id']);
                exit();
            }
        }
        break;


    case 'delete':
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        $row = getMemberById($userid);
        if (deleteUser($row)) {
            setMessage('success', 'تم الحذف بنجاح');
            header('location:members.php?do=manage');
        } else {
            setMessage('error', 'لم يتم الحذف');
            header('location:members.php?do=manage');
        }




    default:
        echo "<div class='alert alert-danger'>Invalid Action</div>";
}





include $tpl . "footer.php";
