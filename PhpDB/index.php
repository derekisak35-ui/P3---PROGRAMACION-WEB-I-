<?php
require_once 'db.php';
require_once 'users.php';
require_once 'empleados.php';
session_start();
// LOGIN SIMPLE
if(isset($_POST['username'], $_POST['password'])) {
    if(User::login($_POST['username'], $_POST['password'], $conn)) {
        $loginMsg = "✅ Bienvenido " . $_SESSION['user']['username'];
    } else {
        $loginMsg = "❌ Usuario o contraseña incorrectos";
    }
}

// CRUD EMPLEADOS 
if(isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    if($accion == "crear") {
        $emp = new Empleado($_POST['nombre'], $_POST['rol'], $_POST['email']);
        $emp->crear($conn);
    }
    if($accion == "editar") {
        $emp = new Empleado($_POST['nombre'], $_POST['rol'], $_POST['email']);
        $emp->id = $_POST['id'];
        $emp->actualizar($conn);
    }
    if($accion == "eliminar") {
        $emp = new Empleado();
        $emp->id = $_POST['id'];
        $emp->eliminar($conn);
    }
}
// empleados lista
$empleados = Empleado::listar($conn);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Empleados</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<h1>Gestión de Empleados</h1>

<?php if(isset($loginMsg)) echo "<p>$loginMsg</p>"; ?>

<?php if(!isset($_SESSION['user'])): ?>
<form method="post">
    <label>Usuario: <input type="text" name="username"></label>
    <label>Contraseña: <input type="password" name="password"></label>
    <button type="submit">Login</button>
</form>
<?php else: ?>

<h2>Crear Nuevo Empleado</h2>
<form method="post">
    <input type="hidden" name="accion" value="crear">
    <label>Nombre: <input type="text" name="nombre" required></label>
    <label>Rol: <input type="text" name="rol" required></label>
    <label>Email: <input type="email" name="email" required></label>
    <button type="submit">Crear</button>
</form>

<h2>Lista de Empleados</h2>
<ul>
<?php foreach($empleados as $e): ?>
    <li>
        <?= $e['nombre'] ?> - <?= $e['rol'] ?> - <?= $e['email'] ?>
        <!-- Formulario editar -->
        <form style="display:inline" method="post">
            <input type="hidden" name="accion" value="editar">
            <input type="hidden" name="id" value="<?= $e['id'] ?>">
            <input type="text" name="nombre" value="<?= $e['nombre'] ?>" required>
            <input type="text" name="rol" value="<?= $e['rol'] ?>" required>
            <input type="email" name="email" value="<?= $e['email'] ?>" required>
            <button type="submit">Editar</button>
        </form>
        <!-- Formulario eliminar -->
        <form style="display:inline" method="post">
            <input type="hidden" name="accion" value="eliminar">
            <input type="hidden" name="id" value="<?= $e['id'] ?>">
            <button type="submit">Eliminar</button>
        </form>
    </li>
<?php endforeach; ?>
</ul>

<?php endif; ?>

</body>
</html>
