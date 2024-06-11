<?php
include './Base.php';

class TodoList extends Base {

    public function addTodo() {
        $id_user = $this->getSession('id');
        $judul = $this->getPost('judul');
        $tgl = date('d F Y', strtotime($this->getPost('tanggal')));
        $prioritas = $this->getPost('prioritas');

        $sql = mysqli_query($this->conn, "INSERT INTO todos VALUES (NULL, '$id_user', '$judul', '$tgl', '$prioritas', '0')");

        if (!$sql) {
            $this->alertAndRedirect('Gagal Menambahkan Todo List', './index.php');
        } else {
            $this->redirect('index.php');
        }
    }

    public function fetchTodos($status) {
        if (isset($_GET['date'])) {
            if (!empty($_GET['date'])) {
                $hariIni = date('d F Y', strtotime(htmlspecialchars($_GET['date'], ENT_QUOTES, 'UTF-8')));
            } else {
                $hariIni = date('d F Y');
            }
        } else {
            $hariIni = date('d F Y');
        }

        $id_user = $this->getSession('id');
        
        if (isset($_GET['filter'])) {
            if (empty(!$_GET['filter'])) {
                if ($_GET['filter'] == 'all'){
                    return mysqli_query($this->conn, "SELECT * FROM todos WHERE id_user = '$id_user' AND selesai = '$status' ORDER BY tgl ASC");
                } else {
                    return mysqli_query($this->conn, "SELECT * FROM todos WHERE id_user = '$id_user' AND selesai = '$status' AND tgl = '$hariIni' ORDER BY tgl ASC");
                }
            } else {
                return mysqli_query($this->conn, "SELECT * FROM todos WHERE id_user = '$id_user' AND selesai = '$status' ORDER BY tgl ASC");
            }
        } else {
            return mysqli_query($this->conn, "SELECT * FROM todos WHERE id_user = '$id_user' AND selesai = '$status' ORDER BY tgl ASC");
        }
    }

    public function deleteTodoById($id) {
        $stmt = $this->conn->prepare("DELETE FROM todos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    public function updateTodo() {
        $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
        $judul = htmlspecialchars($_POST['judul'], ENT_QUOTES, 'UTF-8');
        $tgl = date('d F Y', strtotime(htmlspecialchars($_POST['tanggal'], ENT_QUOTES, 'UTF-8')));
        $prioritas = htmlspecialchars($_POST['prioritas'], ENT_QUOTES, 'UTF-8');
    
        $query = "UPDATE todos SET judul = '$judul', tgl = '$tgl', prioritas = '$prioritas' WHERE id = $id";
        mysqli_query($this->conn, $query);
    }
    
    
}
?>
