<?php
require_once 'config.php';
class DB
{
    private $db;
    public function __construct()
    {
        $this->db = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DB . ";charset=" . MYSQL_Charset, MYSQL_USER, MYSQL_PASS);
    }
    public function connect()
    {
        return $this->db;
    }
}
?>