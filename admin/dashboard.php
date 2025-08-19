<?php
session_start();
$pageTitle = 'Dashboard';
include 'init.php';
auth('index.php');
$noNavbar = '';
?>

<div class="container-fluid p-4">

    <!-- Page Title -->
    <div class="text-center mb-5">
<h1 class="display-3 fw-bold text-gradient" style="background: linear-gradient(90deg, #007bff, #00c6ff); background-clip: text; color: transparent; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">
    Dashboard
</h1>
        <p class="lead text-muted">Welcome to your admin panel</p>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3 shadow-lg">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="members.php?do=manage" class="text-white text-decoration-none">
                            Users
                        </a>
                    </h5>
                    <p class="card-text fs-4"> <?php echo countWhere('users') ?? 0 ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3 shadow-lg">
                <div class="card-body">
                    <h5 class="card-title">Active</h5>
                    <p class="card-text fs-4"><?php echo countWhere('users','RegStatus' , 1) ?? 0; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3 shadow-lg">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="members.php?page=pending" class="text-white text-decoration-none">
                            Pending
                        </a>
                    </h5>
                    <p class="card-text fs-4"><?php echo countWhere('users','RegStatus' , 0) ?? 0; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3 shadow-lg">
                <div class="card-body">
                    <h5 class="card-title">Banned</h5>
                    <p class="card-text fs-4">10</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Columns: Recent Members & Latest Items -->
    <div class="row">
        <!-- Recent Members (Left) -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white">
                    Recent Members
                </div>
                <div class="card-body">
                    <table class="table table-hover text-center align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Full Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // مثال، ممكن تجيب البيانات من قاعدة البيانات
                            $rows = $rows = showData('users', 'ORDER BY id DESC LIMIT 5');

                            foreach ($rows as $row): ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['Username'] ?></td>
                                    <td><?= $row['Email'] ?></td>
                                    <td><?= $row['FullName'] ?></td>
                                    <td>
                                    <?php if ($row['RegStatus'] == '1'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php endif; ?>
                                </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Latest Items (Right) -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white">
                    Latest Items
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <?php
                        $latestItems = [
                            ['name' => 'Item 1', 'price' => '$25', 'image' => 'https://via.placeholder.com/150'],
                            ['name' => 'Item 2', 'price' => '$40', 'image' => 'https://via.placeholder.com/150'],
                            ['name' => 'Item 3', 'price' => '$60', 'image' => 'https://via.placeholder.com/150'],
                            ['name' => 'Item 4', 'price' => '$30', 'image' => 'https://via.placeholder.com/150']
                        ];

                        foreach ($latestItems as $item): ?>
                            <div class="col-md-6">
                                <div class="card shadow-sm h-100">
                                    <img src="<?= $item['image'] ?>" class="card-img-top" alt="<?= $item['name'] ?>">
                                    <div class="card-body text-center">
                                        <h5 class="card-title"><?= $item['name'] ?></h5>
                                        <p class="card-text"><?= $item['price'] ?></p>
                                        <a href="#" class="btn btn-primary btn-sm">View</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End row -->

</div>

<?php
include $tpl . "footer.php";
?>