<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    unset($_SESSION['acesso']);
    unset($_SESSION['codigoCategoria']);

    session_destroy();

?>

<html>
    <?php if (isset($con)) { mysqli_close($con); } ?>
    <br><br><br><br><br><br>
    <center><h2>Fazendo Logoff...</h2></center>
    <meta http-equiv="refresh" content=2;url="../index.php">
</html>