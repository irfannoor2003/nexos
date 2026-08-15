<?php
require_once '../includes/helpers.php';
session_start();
session_destroy();
header('Location: login.php');
exit;
