<?php
class Base {
    protected $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function setSession($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function getSession($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function setPost($key, $value) {
        $_POST[$key] = $value;
    }

    public function getPost($key) {
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }

    public function redirect($url) {
        header("location: $url");
        exit();
    }

    public function alertAndRedirect($message, $url) {
        echo "
            <script>
                alert('$message');
                window.location.href = '$url';
            </script>
        ";
    }
}
?>
