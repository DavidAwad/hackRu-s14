<?php

$dbhandle = sqlite_open('signups.db', 0666, $error);
if (!$dbhandle || $error) die ($error);

$stm = "CREATE TABLE Signups(name text, school text, email text);";
$ok = sqlite_exec($dbhandle, $stm, $error);
if (!$ok) die("Query execution failed: $error");
