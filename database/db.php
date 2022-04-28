<?php

namespace Database;
use PDO;

class db
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    protected $db;

    public function __construct()
    {
        $config = require('./config/database.php');
        $this->servername = $config['SERVERNAME'];
        $this->username = $config['USERNAME'];
        $this->password = $config['PASSWORD'];
        $this->dbname = $config['DBNAME'];
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db = $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function connection () {
        return $this->db;
    }

    public function insert(string $name_table, array $column)
    {
        $db = $this->db;
        $key = array_keys($column);
        $value = array_values($column);
        $sql = "INSERT INTO $name_table (`" . implode("`, `", $key) . "`) " . "VALUES ('" . implode("', '", $value) . "')";
        $db->exec($sql);
        $result = $db->lastInsertId();
        $db = null;
        return $result;
    }


    public function select($name_table, $column = '*', $where = 1)
    {
        $db = $this->db;
        if (is_array($column))
            $column = str_replace(' ', ', ', implode(" ", $column));
        $where = $this->make($where, 'AND ');

        $sql = "SELECT $column FROM `$name_table` WHERE $where";
        $query = $db->query($sql, PDO::FETCH_ASSOC);
        $db = null;
        return $query->fetchAll();
    }


    public function update(string $name_table, int $id, array $column)
    {
        $db = $this->db;
        $column = $this->make($column, ',');
        $sql = "UPDATE `$name_table` SET $column WHERE `id` = $id";
        $query = $db->prepare($sql);
        $result = $query->execute();
        $db = null;
        return $result;
    }


    public function delete($name_table, $column)
    {
        $db = $this->db;
        $column = $this->make($column, ',');
        $sql = "DELETE FROM `$name_table` WHERE $column";
        $result = $db->exec($sql);
        $db = null;
        return $result;
    }


    private function make($params, $replace)
    {
        $data = [];
        if (is_array($params)) {
            foreach ($params as $key => $value) {
                $data[] = "$key='$value'";
            }
            return str_replace(" ", "$replace", implode(" ", $data));
        }
    }
}