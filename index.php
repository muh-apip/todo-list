<?php

error_reporting(E_ALL);

include './koneksi.php';
include './todo-list.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("location:login.php");
}

$todoList = new TodoList($conn);

if (isset($_POST['simpan'])) {
    $todoList->addTodo();
}

if (isset($_POST['update'])) {
    $todoList->updateTodo();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO - LIST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"/>
    <!-- Bootstrap Icon -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./asset/css/style.css">
</head>
<body id="body" data-bs-theme="light">
<nav class="navbar navbar-expand-lg navbar-light mb-4">
      <div class="container">
        <a class="navbar-brand" href="#">
          <i class="bi bi-card-checklist"></i>
          <strong>TODO LIST</strong>
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
            <span class="nav-link">Hello, <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></span>
            </li>
            <li class="nav-item">
            <a class="nav-link btn btn-danger" href="./logout.php">Keluar</a>
            </li>
          </ul>
          <div class="form-check form-switch ms-3">
            <input class="form-check-input" type="checkbox" id="darkModeToggle"/>
            <label class="form-check-label" for="darkModeToggle">
              <i class="bi bi-moon bi-solid"></i>
            </label>
          </div>
        </div>
      </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-sm-12 col-md-12 col-lg-10">
                <div class="card shadow-lg ">
                    <div class="card-header">
                        <h3 class="text-center">
                            TODO LIST <?= isset($_GET['date']) ? date('d F Y', strtotime(htmlspecialchars($_GET['date'], ENT_QUOTES, 'UTF-8'))) : date('d F Y') ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="container">
                                <div class="row my-3">
                                    <div class="col-4">
                                        <div class="input-group input-group-sm">
                                            <input type="date" class="form-control" id="date">
                                            <button class="btn btn-warning btn-sm" id="filter">
                                                Filter
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn btn-primary btn-sm" id="tambah">Tambah</button>
                                        <button class="btn btn-sm btn-success" id="riwayat">Todo List Selesai</button>
                                        <button class="btn btn-sm btn-info d-none" id="sekarang">Todo List Sekarang</button>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-hover text-center">
                                <thead>
                                    <tr>
                                        <th class="col-1">No</th>
                                        <th class="col-4">Judul</th>
                                        <th class="col-3">Tanggal</th>
                                        <th class="col-2">Prioritas</th>
                                        <th class="col-2">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody id="listSekarang">
                                    <?php
                                    $no = 1;
                                    $todos = $todoList->fetchTodos('0');
                                    while ($data = mysqli_fetch_assoc($todos)) {
                                    ?>
                                        <tr>
                                            <td class="col-1"><?= $no++ ?></td>
                                            <td class="col-4"><?= htmlspecialchars($data['judul'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="col-3"><?= htmlspecialchars($data['tgl'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="col-2">
                                                <span class="badge rounded-pill <?= $data['prioritas'] === 'tinggi' ? 'bg-danger' : ($data['prioritas'] === 'sedang' ? 'bg-warning' : 'bg-primary') ?>">
                                                    <?= ucfirst(htmlspecialchars($data['prioritas'], ENT_QUOTES, 'UTF-8')); ?>
                                                </span>
                                            </td>
                                            <td class="col-2">
                                                <div class="btn-group" role="group" aria-label="Todo actions">
                                                    <?php
                                                    $hariIni = date('d F Y');
                                                    if ($hariIni < $data['tgl']) {
                                                    ?>
                                                        <button class="btn btn-sm btn-outline-danger" disabled>Selesai</button>
                                                    <?php } elseif ($hariIni > $data['tgl']) { ?>
                                                        <button class="btn btn-sm btn-outline-warning me-1" disabled>Tertunda</button>
                                                    <?php } else { ?>
                                                        <a href="./selesai.php?id=<?= htmlspecialchars($data['id'], ENT_QUOTES, 'UTF-8') ?>" class="btn btn-sm btn-outline-success me-1">Selesai</a>
                                                        <?php } ?>
                                                <button class="btn btn-sm btn-outline-primary edit-todo me-1" 
                                                    data-id="<?= htmlspecialchars($data['id'], ENT_QUOTES, 'UTF-8') ?>" 
                                                    data-judul="<?= htmlspecialchars($data['judul'], ENT_QUOTES, 'UTF-8') ?>" 
                                                    data-tgl="<?= htmlspecialchars($data['tgl'], ENT_QUOTES, 'UTF-8') ?>" 
                                                    data-prioritas="<?= htmlspecialchars($data['prioritas'], ENT_QUOTES, 'UTF-8') ?>">
                                                    Edit
                                                </button>
                                                    <a href="./hapus.php?id=<?= htmlspecialchars($data['id'], ENT_QUOTES, 'UTF-8') ?>" class="btn btn-sm btn-outline-danger me-1">Hapus</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>

                                <tbody class="d-none" id="listRiwayat">
                                    <?php
                                    $no = 1;
                                    $todos = $todoList->fetchTodos('1');
                                    while ($data = mysqli_fetch_assoc($todos)) {
                                    ?>
                                        <tr>
                                            <td class="col-1"><?= $no++ ?></td>
                                            <td class="col-4"><?= htmlspecialchars($data['judul'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="col-3"><?= htmlspecialchars($data['tgl'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="col-2">
                                                <span class="badge rounded-pill <?= $data['prioritas'] === 'tinggi' ? 'bg-danger' : ($data['prioritas'] === 'sedang' ? 'bg-warning' : 'bg-primary') ?>">
                                                    <?= ucfirst(htmlspecialchars($data['prioritas'], ENT_QUOTES, 'UTF-8')); ?>
                                                </span>
                                            </td>
                                            <td class="col-2">
                                                <button type="button" class="btn btn-sm btn-success" disabled>Selesai</button>
                                                <a href="./hapus.php?id=<?= htmlspecialchars($data['id'], ENT_QUOTES, 'UTF-8') ?>" class="btn btn-sm btn-outline-danger">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="Mtambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Todo List</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form action="" method="post">
                            <div class="mb-4">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" placeholder="Masukkan Judul" required id="judul" name="judul">
                            </div>
                            <div class="mb-4">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" placeholder="Masukkan Tanggal" required id="tanggal" name="tanggal">
                            </div>
                            <div class="mb-4">
                                <label for="prioritas" class="form-label">Prioritas</label>
                                <select name="prioritas" id="prioritas" class="form-select text-center" required>
                                    <option value="" selected class="text-center">----- Pilih Prioritas -----</option>
                                    <option value="tinggi" class="text-center">Tinggi</option>
                                    <option value="sedang" class="text-center">Sedang</option>
                                    <option value="rendah" class="text-center">Rendah</option>
                                </select>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-primary" name="simpan">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update -->
    <div class="modal fade" id="Mupdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Todo List</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form action="" method="post">
                            <input type="hidden" id="update-id" name="id">
                            <div class="mb-4">
                                <label for="update-judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" placeholder="Masukkan Judul" required id="update-judul" name="judul">
                            </div>
                            <div class="mb-4">
                                <label for="update-tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" placeholder="Masukkan Tanggal" required id="update-tanggal" name="tanggal">
                            </div>
                            <div class="mb-4">
                                <label for="update-prioritas" class="form-label">Prioritas</label>
                                <select name="prioritas" id="update-prioritas" class="form-select text-center" required>
                                    <option value="" selected class="text-center">----- Pilih Prioritas -----</option>
                                    <option value="tinggi" class="text-center">Tinggi</option>
                                    <option value="sedang" class="text-center">Sedang</option>
                                    <option value="rendah" class="text-center">Rendah</option>
                                </select>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-primary" name="update">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>

    <script>
    $(document).ready(function() {
        let dateValue = getQueryParam('date')
        $('#date').val(dateValue)

        $('#tambah').click(function() {
            $('#Mtambah').modal('show');
        })

        $('#riwayat').click(function (e) { 
            e.preventDefault();
            $(this).addClass('d-none');
            $('#sekarang').removeClass('d-none');
            $('#listSekarang').addClass('d-none');
            $('#listRiwayat').removeClass('d-none');
        });
        
        $('#sekarang').click(function (e) { 
            e.preventDefault();
            $(this).addClass('d-none');
            $('#riwayat').removeClass('d-none');
            $('#listRiwayat').addClass('d-none');
            $('#listSekarang').removeClass('d-none');
        });

        $('#filter').click(function () {
            let protocol = window.location.protocol
            let hostname = window.location.hostname
            let pathname = window.location.pathname
            window.location.href = `${protocol}//${hostname}${pathname}?date=` + $('#date').val()
        })

        function getQueryParam(param) {
            let url = new URL(window.location.href)
            let params = new URLSearchParams(url.search)
            return params.get(param)
        }

        $('.edit-todo').click(function() {
            let id = $(this).data('id');
            let judul = $(this).data('judul');
            let tgl = $(this).data('tgl');
            let prioritas = $(this).data('prioritas');
            $('#update-id').val(id);
            $('#update-judul').val(judul);
            $('#update-tanggal').val(tgl);
            $('#update-prioritas').val(prioritas);
            $('#Mupdate').modal('show');
        });

        const darkModeToggle = document.getElementById("darkModeToggle");
        const body = document.body;
        const darkModeStatus = localStorage.getItem('darkMode');

        if (darkModeStatus === 'enabled') {
            body.setAttribute("data-bs-theme", "dark");
            darkModeToggle.checked = true;
            document.querySelector(".form-check-label i").classList.remove("bi-moon");
            document.querySelector(".form-check-label i").classList.add("bi-sun");
        }

        darkModeToggle.addEventListener("click", () => {
            if (darkModeToggle.checked) {
                body.setAttribute("data-bs-theme", "dark");
                localStorage.setItem('darkMode', 'enabled');
                document.querySelector(".form-check-label i").classList.remove("bi-moon");
                document.querySelector(".form-check-label i").classList.add("bi-sun");
            } else {
                body.setAttribute("data-bs-theme", "light");
                localStorage.setItem('darkMode', 'disabled');
                document.querySelector(".form-check-label i").classList.remove("bi-sun");
                document.querySelector(".form-check-label i").classList.add("bi-moon");
            }
        });
    });
    </script>
</body>
</html>
