<?php
  session_start();

  session_unset();

  session_destroy();

  header('Location: /CONSULTARQ/CONSULTARQ%20Admin/index.php');
?>
