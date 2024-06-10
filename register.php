<?php

include './koneksi.php';

session_start();

if (isset($_SESSION['username'])) {
    header("location:index.php");
}

if (isset($_POST['register'])) {

    $uss = $_POST['username'];
    $pw = $_POST['password'];

    // var_dump($pw);
    // var_dump($uss);

    $sql = mysqli_query($conn, "INSERT INTO users VALUES (NULL,'$uss','$pw')");

    if($sql) {
        $_SESSION['id'] = mysqli_insert_id($conn);
        $_SESSION['username'] = $uss;
        header("location:index.php");
    } else {
        echo "
            <script>
                alert('Register Gagal!)
            </script>
        ";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO - LIST | REGISTER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"/>
    <!-- Bootstrap Icon -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./asset/css/style.css">
</head>
<body class="">

<div class="container">
    <div class="row justify-content-center row-login">
        <div class="col-sm-12 col-md-12 col-lg-4">
            <div class="card shadow-lg">
                <div class="card-title">
                    <h3 class="text-center fw-bold pt-3">REGISTER</h3>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-4">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" placeholder="Masukkan Username" id="username" name="username" required autofocus>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" placeholder="Masukkan Password" id="username" name="password" required>
                        </div>
                        <div class="d-grid mb-2">
                            <button type="submit" class="btn btn-primary" name="register">Register</button>
                        </div>
                        <p class="text-center">
                            Sudah Belum Mempunyai Akun? Login <a href="./login.php">disini.</a>
                        </span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $('#tambah').click(function() {
            $('#Mtambah').modal('show');
        })
        const darkModeToggle = document.getElementById("darkModeToggle");
        const body = document.body;
        const darkModeStatus = localStorage.getItem('darkMode');

        // Apply dark mode status from localStorage
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
    })
</script>

</body>
</html>