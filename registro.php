<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/stylesIndex.css">
    <title>Registrese</title>
</head>
<body>
        <header>
            <a href="index.html">Vuelva a la pagina principal</a>
        </header>
        <h1 class='title'> Gelatto</h1>    
    <span>
        <h1>Registrese o</h1> <a href="login.php">Ingrese</a>
    </span>
    
    <form method="post" action="registro.php" enctype="multipart/form-data">

            <input type="text" name="mail" autocomplete="off" placeholder="Ingrese su email"required><br /> 
            <input type="text" name="user" autocomplete="off" placeholder="Ingrese su usuario" required><br />
            <input type="password" name="pass" autocomplete="off" placeholder="Ingrese su contraseña"required><br />
            <input type="submit" name="insertar" class="button" value="REGISTRARSE">

    </form>

    <section>
    Al registrarte, aceptas nuestras Condiciones, <br>la Política de datos y la Política de cookies.
    </section>

    <a href='https://www.apple.com/la/app-store/'><img src="estilos/img/appstore.png"></a>
    <a href="https://play.google.com/store?hl=es_AR&gl=US"><img src="estilos/img/google play.png"></a>
    
</body>
</html>
<?php
    include 'db.php';
    session_start();    
    if(isset($_POST['insertar'])){
        $user = $_POST['user'];
        $contrasenia = $_POST['pass'];
        $sql = "INSERT INTO usuarios (email, contrasenia) VALUES ('$user', '$contrasenia')";
        $resultado = mysqli_query($conexion, $sql);
        if($resultado){            
            //$_SESSION['pass_hard'] = base64_encode($contrasenia);
            ?>
            <h3 class="ok">¡Te has registrado correctamente!</h3>
            <?php
        }
        else{
            ?>
            <h3 class="bad">¡ups ha ocurrido un error!</h3>
            <?php
        }
    }

?>