<!DOCTYPE html>
<meta charset= "UTF-8">

<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "", "comercio1") or die("Error en la conexion");
?>

<html>    
    <link rel="stylesheet" href="styles.css">
    <title id='title'>Gelatto - Chocolates y Helados</title>   

    <body>
        <header>
            <h1 class='title'> Gelatto</h1>
            <div class="switches">
                    <input type="submit" name="insertar" id="toggle-theme" class="toggle-theme" value="Cambiar Tema">
                    <div class='toggle-theme'>
                        <?php
                            echo '<a href= "cerrarsesion.php"> Cerrar sesion </a>';
                        ?>
                    </div>
            </div>
            
            <script>

                const toggleTheme = document.getElementById('toggle-theme');

                toggleTheme.addEventListener('click',() =>{
                    document.body.classList.toggle('dark');
                    document.getElementById('h3').classList.toggle('dark');
                    document.getElementById('form').classList.toggle('dark');
                    document.getElementById('principales').classList.toggle('dark');
                    document.getElementById('linea').classList.toggle('dark');
                    
                })

            </script> 

            <div class="linea" id='linea'></div>

            <ul class='nav'>
                <li><a href=''>Inicio</a></li>                
                <li><a href=''>Productos</a>
                    <ul>
                    <li><a href=''>Helados</a></li>
                    <li><a href=''>Chocolates</a></li>
                    <li><a href=''>Postres</a></li>
                    </ul>
                </li>
                <li><a href=''>Locales</a></li>
                <li><a href=''>Servicio</a>
                    <ul>
                    <li><a href=''> Contacto </a></li>
                    <li><a href=''> Trabaja con nosotros </a></li>
                    </ul>
                </li>    
                <li><a href=''> Novedades </a></li>
            </ul>   
        </header>

        <?php
        if(isset($_SESSION['user'])){
            echo '<h3 class="sesion" id="h3">Bienvenido '.$_SESSION['user']. ', se ha iniciado sesión '.$_COOKIE['contador']. ' veces en un dia.</h3>';
            
        }else{
            header('location:index.html');
        }
        ?>
        
    <form id='form' method="post" action="formulario.php" enctype="multipart/form-data">
            <input type="text" name="nombre" autocomplete="off" placeholder="Ingrese nombre del producto" required><br />
            <input type="number" name="precio" autocomplete="off" placeholder="Ingrese precio"><br />
            <input type="file" name="foto" accept="image/"><br />
            <input type="submit" name="insertar" class="button" value="INSERTAR">
    </form>

    <h3 id='principales'>Principales:</h3>

    <div class='container-all'>
        
    <?php
    if(isset($_GET['id_borrar'])){
        $id_borrar = $_GET['id_borrar'];
        $sql = "DELETE FROM productos WHERE ID_producto='$id_borrar'";
        $img_borrar=$_GET['img'];
        unlink("imagenes/".$img_borrar);
        $borrar = mysqli_query($conexion,$sql)?print
        ("<script>alert('Registro eliminado');window.location='formulario.php'</script>") : 
        print("<script>alert('Error al eliminar');window.location='formulario.php'</script>");
    }
    ?>
  

    <?php
    if(isset($_POST['insertar'])){
        $nombre_prod = $_POST['nombre'];
        $precio = $_POST['precio'];
        if (is_uploaded_file($_FILES['foto']['tmp_name'])) {
            $archivo = $_FILES['foto']['name'];
            move_uploaded_file($_FILES['foto']['tmp_name'],'imagenes/'.$archivo);
        }
        $sql = "INSERT INTO productos (Foto, Nbr_prod, Precio_prod) VALUES ('$archivo','$nombre_prod','$precio')";
        $insertar = mysqli_query($conexion,$sql)? print("<script>alert('Registro insertado');window.location='formulario.php'</script>") : print("<script>alert('Error al insertar registro');window.location='formulario.php'</script>");
    }

    if(isset($_GET['id_editar'])){
        $id_editar = $_GET['id_editar'];
        $sql="SELECT * FROM productos WHERE ID_producto ='$id_editar'";
        $consulta=mysqli_query($conexion, $sql);
        $reg_editar = mysqli_fetch_assoc($consulta);
        echo '
        
        <form method="post" action="formulario.php" enctype="multipart/form-data"><h2>Modificar sabor</h2>
        <input type="hidden" name="fotoprevia" value="'.$reg_editar['Foto'].'">
        <input type="hidden" name="id_editar" value="'.$id_editar.'">
        <input type="text" name="nombre" autocomplete="off" value="'.$reg_editar['Nbr_prod'].'">
        <input type="number" name="precio" value="'.$reg_editar['Precio_prod'].'"">
        <input type="file" name="foto" accept="image/*"><br />
        <input type="submit" name="modificar" class="button" value="MODIFICAR">
    </form>
        ';
    }
        if(isset($_POST['modificar'])){
        $id_editar = $_POST['id_editar'];
        $foto_previa = $_POST['fotoprevia'];    
        $nombre_mod = $_POST['nombre'];
        $precio_mod = $_POST['precio'];
        if (is_uploaded_file($_FILES['foto']['tmp_name'])) {
            $archivo = $_FILES['foto']['name'];
            move_uploaded_file($_FILES['foto']['tmp_name'],'imagenes/'.$archivo);
            unlink("imagenes/".$foto_previa);
        }
        else{
            $archivo = $foto_previa;
        }
        $sql_mod = "UPDATE productos SET Foto='$archivo', Nbr_prod='$nombre_mod', Precio_prod='$precio_mod' WHERE ID_producto='$id_editar'";
        $modificar = mysqli_query($conexion,$sql_mod)? print("<script>alert('Registro Modificado');window.location='formulario.php'</script>") : print("<script>alert('Error al modificar');window.location='formulario.php'</script>");
    }

    $sql = "SELECT * FROM productos";
    $consulta = mysqli_query($conexion,$sql);
    ?>

    <?php
    if(mysqli_num_rows($consulta)>0){
        while($registro = mysqli_fetch_assoc($consulta)){
            echo '<div class="card">
            <div class="container-image"><img class="image" src="imagenes/'.$registro['Foto'].'" style="width: 200px"></div>
            <p class="name-prod">'.$registro['Nbr_prod'].'</p>
            <p class="price-prod"> $'.$registro['Precio_prod'].'.</p>
            <a class="delete-prod" href="formulario.php?id_borrar='.$registro['ID_producto'].'&img='.$registro['Foto'].'"
            onclick="return confirm(\'Seguro desea eliminar?\')">Eliminar</a> 
            <a class="edit-prod" href="formulario.php?id_editar='.$registro['ID_producto'].'">Editar</a>
            </div>
            </hr>';
        }
    }else{
        echo 'No hay productos para mostrar';
    }
    ?>

    <?php
    mysqli_close($conexion);
    ?>
    

        </div>
    </body>
</html>
