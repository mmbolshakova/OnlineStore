<?php
session_start();
header('Location: index.php');
if (isset($_SESSION['bag']))
    unset($_SESSION['bag']);
if (isset($_SESSION['usr']))
    unset($_SESSION['usr']);

