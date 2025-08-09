<?php
class BlogManager {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllBlogs() {
        $sql = "SELECT * FROM tblblogs ORDER BY ID DESC";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getBlogById($id) {
        $sql = "SELECT * FROM tblblogs WHERE ID = $id";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function toggleBlogStatus($id, $status) {
        $sql = "UPDATE tblblogs SET Status='$status' WHERE ID=$id";
        return mysqli_query($this->conn, $sql);
    }

    public function deleteBlog($id) {
        $sql = "DELETE FROM tblblogs WHERE ID=$id";
        return mysqli_query($this->conn, $sql);
    }

    public function getBlogStatistics() {
        $stats = ['total'=>0, 'active'=>0, 'inactive'=>0];
        $res = mysqli_query($this->conn, "SELECT Status, COUNT(*) as cnt FROM tblblogs GROUP BY Status");
        while($row = mysqli_fetch_assoc($res)) {
            $stats['total'] += $row['cnt'];
            if($row['Status'] == 'Active') $stats['active'] = $row['cnt'];
            if($row['Status'] == 'Inactive') $stats['inactive'] = $row['cnt'];
        }
        return $stats;
    }
}
