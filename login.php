<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/stylesIndex.css">
    <title>Ingrese</title>
</head>
<body>
        <header>
            <a href="index.html">Vuelva a la pagina principal</a>
        </header>
        <h1 class='title'> Gelatto</h1>    
    <span>
        <h1>Ingrese o</h1><a href="registro.php">Registrese</a>
    </span>
    <form method="post" action="login.php" enctype="multipart/form-data">

            <input type="text" name="user" autocomplete="off" placeholder="Ingrese su usuario" required><br />
            <input type="password" name="contrasenia" autocomplete="off" placeholder="Ingrese su contraseña"required><br />
            <input type="submit" name="insertar" class="button" value="INICIAR SESION">
    </form>

    <a href='https://www.apple.com/la/app-store/'><img src="estilos/img/appstore.png"></a>
    <a href="https://play.google.com/store?hl=es_AR&gl=US"><img src="estilos/img/google play.png"></a>
    
</body>
</html>
<?php
    include 'db.php';
    session_start();
    if($_POST){ //Es para que no salte el warning de array key, encapsulo todo desde lo que incluye el metodo post
    $user = $_POST['user']; 
    $contrasenia = $_POST['contrasenia'];
    if(isset($_POST ['insertar'])){
        
        $consulta = "SELECT * FROM usuarios WHERE email='$user' and contrasenia='$contrasenia'";
        $resultado = mysqli_query($conexion, $consulta);        
        $filas = mysqli_num_rows($resultado);
        
        if($filas > 0){
            $_SESSION['user'] = $user;
            if (isset($_COOKIE['contador'])){
                $cont = $_COOKIE['contador'];
                setcookie('contador', $cont+1, time()+60*60*24);
            }else{
                setcookie('contador', 1, time()+30);
            }
            header('location:formulario.php');           
        }else{
            echo '<h3 class="bad">¡ups ha ocurrido un error!</h3>';
            session_destroy();
        }

        mysqli_free_result($resultado);
        mysqli_close($conexion);

    }
}
?>


    