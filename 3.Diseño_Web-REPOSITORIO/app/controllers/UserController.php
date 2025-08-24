<?php
    require_once('../Modelo/Usuarios.php');

    if($_POST){
        $USUARIO = $_POST['usuario'];
        $CONTRASEÑA =$_POST['contrasena'];

        $Modelo = new USUARIOS();
        if($Modelo->Login($USUARIO,$CONTRASEÑA)){
            header('location: ../../ESTUDIANTES/Vistas/index.php');
        }else{
            header('location: ../../index.php');
        }
    }else{
        header('location: ../../index.php');
    }
