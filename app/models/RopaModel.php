<?php
require_once 'config/config.php';

class RopaModel
{
    protected $db;

    public function __construct()
    {
        try {
            $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection error: " . $e->getMessage());
        }
    }

    public function getRopa($sort='nombre', $order = 'ASC')
    {
        try {
            $query = $this->db->prepare("SELECT*FROM ropa JOIN talles ON ropa.talle_id = talles.talle_id ORDER BY $sort $order");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getRopaById($id)
    {
        try {
            $query = $this->db->prepare(
                'SELECT*FROM ropa  JOIN talles ON ropa.talle_id = talles.talle_id WHERE ropa.ropa_id = ?' );
            $query->execute([$id]);
            return $query->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function insertRopa($nombre, $precio, $talle_id)
    {
        try {
            $query = $this->db->prepare(
                'INSERT INTO ropa (nombre, precio, talle_id) 
                 VALUES (?, ?, ?)'
            );
            $query->execute([$nombre, $precio, $talle_id]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateRopa($id, $nombre, $precio, $talle_id)
    {
        try {
            $query = $this->db->prepare(
                'UPDATE ropa 
                 SET nombre = ?, precio = ?, talle_id = ? 
                 WHERE ropa_id = ?'
            );
            $query->execute([$nombre, $precio, $talle_id, $id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
