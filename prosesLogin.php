<?php

include './koneksi.php';

session_start();

if (isset($_POST["login"])) {

        $uss = $_POST["username"];
        $pw = $_POST["password"];

        // var_dump($uss);

        $sql = "SELECT * FROM users WHERE username='$uss'";
        $query = $conn->query($sql);
        $hasil = $query->fetch_assoc();

        if ($pw <> $hasil['password']) {
            echo "
                <script> 
                    alert('Login Gagal !');
                    window.location.href = './login.php';
                </script>
            ";
        } else {
            $_SESSION['username'] = $hasil['username'];
            $_SESSION['id'] = $hasil['id'];
            header("location:index.php");
        }
        
    }

?>