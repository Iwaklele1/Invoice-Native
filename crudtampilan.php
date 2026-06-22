<?php
// ============================================================
// INVOICE APP - Single File
// ============================================================

// --- Dummy Data (ganti dengan koneksi DB) ---
$items_db = [
  1 => ['id' => 1, 'ref_no' => 'ITM-001', 'name' => 'Laptop',   'price' => 12000000],
  2 => ['id' => 2, 'ref_no' => 'ITM-002', 'name' => 'Mouse',    'price' => 150000],
  3 => ['id' => 3, 'ref_no' => 'ITM-003', 'name' => 'Keyboard', 'price' => 300000],
];

$customers_db = [
  1 => ['id' => 1, 'ref_no' => 'CST-001', 'name' => 'Budi Santoso', 'address' => 'Jl. Merdeka No. 1, Surabaya',     'phone' => '081234567890'],
  2 => ['id' => 2, 'ref_no' => 'CST-002', 'name' => 'Siti Rahayu',  'address' => 'Jl. Raya Darmo No. 10, Surabaya', 'phone' => '089876543210'],
  3 => ['id' => 3, 'ref_no' => 'CST-003', 'name' => 'Ahmad Fauzi',  'address' => 'Jl. Pemuda No. 5, Sidoarjo',      'phone' => '082211223344'],
];

// --- Router ---
$page   = $_GET['page']   ?? 'items';       // items | customers
$action = $_GET['action'] ?? 'index';       // index | create | edit
$id     = (int) ($_GET['id'] ?? 0);

// --- Handle POST ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($page === 'items') {
    if ($action === 'create') {
      // TODO: INSERT ke DB
      // $ref_no = $_POST['ref_no']; $name = $_POST['name']; $price = $_POST['price'];
    } elseif ($action === 'edit') {
      // TODO: UPDATE ke DB berdasarkan $id
    }
  }
  if ($page === 'customers') {
    if ($action === 'create') {
      // TODO: INSERT ke DB
    } elseif ($action === 'edit') {
      // TODO: UPDATE ke DB berdasarkan $id
    }
  }
  header("Location: ?page=$page");
  exit;
}

// --- Handle DELETE ---
if ($action === 'delete' && $id > 0) {
  // TODO: DELETE dari DB berdasarkan $id dan $page
  header("Location: ?page=$page");
  exit;
}

// --- Data untuk form edit ---
$edit_item     = ($page === 'items'     && $action === 'edit') ? ($items_db[$id]     ?? null) : null;
$edit_customer = ($page === 'customers' && $action === 'edit') ? ($customers_db[$id] ?? null) : null;

// --- Page title ---
$titles = [
  'items'     => ['index' => 'Daftar Item',     'create' => 'Tambah Item',     'edit' => 'Edit Item'],
  'customers' => ['index' => 'Daftar Customer', 'create' => 'Tambah Customer', 'edit' => 'Edit Customer'],
];
$title = $titles[$page][$action] ?? 'Invoice App';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?> - Invoice App</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">&#9776;</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <span class="nav-link"><?= $title ?></span>
      </li>
    </ul>
  </nav>

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="?page=items" class="brand-link">
      <span class="brand-text font-weight-light ml-3">Invoice App</span>
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          <li class="nav-item">
            <a href="?page=items" class="nav-link <?= $page === 'items' ? 'active' : '' ?>">
              <p>Items</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=customers" class="nav-link <?= $page === 'customers' ? 'active' : '' ?>">
              <p>Customers</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <h1 class="m-0"><?= $title ?></h1>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">

        <!-- ================================================ -->
        <!-- ITEMS -->
        <!-- ================================================ -->
        <?php if ($page === 'items'): ?>

          <?php if ($action === 'index'): ?>
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Item</h3>
                <a href="?page=items&action=create" class="btn btn-sm btn-primary">Tambah Item</a>
              </div>
              <div class="card-body p-0">
                <table class="table table-bordered table-hover mb-0">
                  <thead class="thead-light">
                    <tr>
                      <th style="width:50px">ID</th>
                      <th>Ref No</th>
                      <th>Name</th>
                      <th>Price</th>
                      <th style="width:130px">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (empty($items_db)): ?>
                      <tr><td colspan="5" class="text-center text-muted">Belum ada data item.</td></tr>
                    <?php else: ?>
                      <?php foreach ($items_db as $item): ?>
                        <tr>
                          <td><?= $item['id'] ?></td>
                          <td><?= htmlspecialchars($item['ref_no']) ?></td>
                          <td><?= htmlspecialchars($item['name']) ?></td>
                          <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                          <td>
                            <a href="?page=items&action=edit&id=<?= $item['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
                            <a href="?page=items&action=delete&id=<?= $item['id'] ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Hapus item ini?')">Hapus</a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>

          <?php elseif ($action === 'create'): ?>
            <div class="card" style="max-width:600px">
              <div class="card-header"><h3 class="card-title">Form Tambah Item</h3></div>
              <div class="card-body">
                <form method="POST" action="?page=items&action=create">
                  <div class="form-group">
                    <label>Ref No</label>
                    <input type="text" name="ref_no" class="form-control" placeholder="ITM-001" required>
                  </div>
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Nama item" required>
                  </div>
                  <div class="form-group">
                    <label>Price</label>
                    <input type="number" name="price" class="form-control" placeholder="0" min="0" required>
                  </div>
                  <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                  <a href="?page=items" class="btn btn-secondary">Batal</a>
                </form>
              </div>
            </div>

          <?php elseif ($action === 'edit'): ?>
            <?php if (!$edit_item): ?>
              <div class="alert alert-warning">Item tidak ditemukan.</div>
            <?php else: ?>
              <div class="card" style="max-width:600px">
                <div class="card-header"><h3 class="card-title">Form Edit Item</h3></div>
                <div class="card-body">
                  <form method="POST" action="?page=items&action=edit&id=<?= $edit_item['id'] ?>">
                    <div class="form-group">
                      <label>Ref No</label>
                      <input type="text" name="ref_no" class="form-control" value="<?= htmlspecialchars($edit_item['ref_no']) ?>" required>
                    </div>
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($edit_item['name']) ?>" required>
                    </div>
                    <div class="form-group">
                      <label>Price</label>
                      <input type="number" name="price" class="form-control" value="<?= $edit_item['price'] ?>" min="0" required>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                    <a href="?page=items" class="btn btn-secondary">Batal</a>
                  </form>
                </div>
              </div>
            <?php endif; ?>
          <?php endif; ?>

        <!-- ================================================ -->
        <!-- CUSTOMERS -->
        <!-- ================================================ -->
        <?php elseif ($page === 'customers'): ?>

          <?php if ($action === 'index'): ?>
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Customer</h3>
                <a href="?page=customers&action=create" class="btn btn-sm btn-primary">Tambah Customer</a>
              </div>
              <div class="card-body p-0">
                <table class="table table-bordered table-hover mb-0">
                  <thead class="thead-light">
                    <tr>
                      <th style="width:50px">ID</th>
                      <th>Ref No</th>
                      <th>Name</th>
                      <th>Address</th>
                      <th>Phone</th>
                      <th style="width:130px">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (empty($customers_db)): ?>
                      <tr><td colspan="6" class="text-center text-muted">Belum ada data customer.</td></tr>
                    <?php else: ?>
                      <?php foreach ($customers_db as $cust): ?>
                        <tr>
                          <td><?= $cust['id'] ?></td>
                          <td><?= htmlspecialchars($cust['ref_no']) ?></td>
                          <td><?= htmlspecialchars($cust['name']) ?></td>
                          <td><?= htmlspecialchars($cust['address']) ?></td>
                          <td><?= htmlspecialchars($cust['phone']) ?></td>
                          <td>
                            <a href="?page=customers&action=edit&id=<?= $cust['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
                            <a href="?page=customers&action=delete&id=<?= $cust['id'] ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Hapus customer ini?')">Hapus</a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>

          <?php elseif ($action === 'create'): ?>
            <div class="card" style="max-width:600px">
              <div class="card-header"><h3 class="card-title">Form Tambah Customer</h3></div>
              <div class="card-body">
                <form method="POST" action="?page=customers&action=create">
                  <div class="form-group">
                    <label>Ref No</label>
                    <input type="text" name="ref_no" class="form-control" placeholder="CST-001" required>
                  </div>
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Nama lengkap" required>
                  </div>
                  <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" class="form-control" rows="3" placeholder="Alamat lengkap"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="Nomor telepon">
                  </div>
                  <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                  <a href="?page=customers" class="btn btn-secondary">Batal</a>
                </form>
              </div>
            </div>

          <?php elseif ($action === 'edit'): ?>
            <?php if (!$edit_customer): ?>
              <div class="alert alert-warning">Customer tidak ditemukan.</div>
            <?php else: ?>
              <div class="card" style="max-width:600px">
                <div class="card-header"><h3 class="card-title">Form Edit Customer</h3></div>
                <div class="card-body">
                  <form method="POST" action="?page=customers&action=edit&id=<?= $edit_customer['id'] ?>">
                    <div class="form-group">
                      <label>Ref No</label>
                      <input type="text" name="ref_no" class="form-control" value="<?= htmlspecialchars($edit_customer['ref_no']) ?>" required>
                    </div>
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($edit_customer['name']) ?>" required>
                    </div>
                    <div class="form-group">
                      <label>Address</label>
                      <textarea name="address" class="form-control" rows="3"><?= htmlspecialchars($edit_customer['address']) ?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Phone</label>
                      <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($edit_customer['phone']) ?>">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                    <a href="?page=customers" class="btn btn-secondary">Batal</a>
                  </form>
                </div>
              </div>
            <?php endif; ?>
          <?php endif; ?>

        <?php endif; ?>

      </div>
    </div>
  </div>

  <footer class="main-footer">
    <span class="float-right text-muted">Invoice App</span>
    &copy; <?= date('Y') ?>
  </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>