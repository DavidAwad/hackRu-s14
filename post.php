<?php

$dbhandle = sqlite_open('signups.db', 0666, $error);
if (!$dbhandle) die ($error);

$stm = "CREATE TABLE IF NOT EXISTS Signups(name text, school text, email text);";
$ok = sqlite_exec($dbhandle, $stm, $error);
if (!$ok) die("Query execution failed: $error");

$name = sqlite_escape_string($_POST['name']);
$school = sqlite_escape_string($_POST['school']);
$email = sqlite_escape_string($_POST['email']);

$stm = "INSERT INTO Signups VALUES ('$name', '$school', '$email');";
$ok = sqlite_exec($dbhandle, $stm, $error);
if (!$ok) die("Query exec failed: $error");

