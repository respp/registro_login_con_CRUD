<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/stylesIndex.css">
    <title>Document</title>
</head>
<body>
        <header>
            <a href="/registro_login">Vuelva a la pagina principal</a>
        </header>
<?php
session_start();
if(isset($_SESSION['user'])){
    echo '<h3 class="ok">Bienvenido '.$_SESSION['user']. ', se ha iniciado sesión '.$_COOKIE['contador']. ' veces en un dia.</h3>';
    echo '<a href= "cerrarsesion.php"> salir </a>';
}else{
    header('location:index.html');
}
?>
</body>
</html>