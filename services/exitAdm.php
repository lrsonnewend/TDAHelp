<?php
    session_start();
    
    unset($_SESSION['id_avaliador']);

    header("location: ../pages/avaliador.php");
?>