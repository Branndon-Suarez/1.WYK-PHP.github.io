<?php
session_start();
    echo "Bienvenido usuario '{$_SESSION['username']}'<br>";
    echo "Su rol es: {$_SESSION['rol']}<br>";
