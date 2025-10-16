<?php
$pdo = new PDO('sqlite:' . __DIR__ . '/../data/cinema.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
