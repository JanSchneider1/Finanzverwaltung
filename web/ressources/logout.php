<?php
/**
 * Created by IntelliJ IDEA.
 * User: caylak
 * Date: 13.12.2018
 * Time: 14:52
 */
session_start();
session_destroy();
echo "<script type='text/javascript'>location.href = '/login.php'</script>";