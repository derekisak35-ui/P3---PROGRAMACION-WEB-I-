<?php
require_once 'db.php';

class Empleado {
    public $id;
    public $nombre;
    public $rol;
    public $email;

    public function __construct($nombre="", $rol="", $email="") {
        $this->nombre = $nombre;
        $this->rol = $rol;
        $this->email = $email;
    }

    public function crear($conn) {
        $stmt = $conn->prepare("INSERT INTO empleados (nombre, rol, email) VALUES (:nombre, :rol, :email)");
        $stmt->execute(['nombre'=>$this->nombre,'rol'=>$this->rol,'email'=>$this->email]);
        $this->id = $conn->lastInsertId();
    }

    public static function listar($conn) {
        $stmt = $conn->query("SELECT * FROM empleados");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizar($conn) {
        if(!$this->id) return false;
        $stmt = $conn->prepare("UPDATE empleados SET nombre=:nombre, rol=:rol, email=:email WHERE id=:id");
        return $stmt->execute(['nombre'=>$this->nombre,'rol'=>$this->rol,'email'=>$this->email,'id'=>$this->id]);
    }

    public function eliminar($conn) {
        if(!$this->id) return false;
        $stmt = $conn->prepare("DELETE FROM empleados WHERE id=:id");
        return $stmt->execute(['id'=>$this->id]);
    }
}
?>
