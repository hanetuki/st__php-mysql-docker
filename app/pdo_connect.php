<?php
  try {
    $dbh = new PDO($_ENV['DSN'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

  } catch (PDOException $e) {
    echo "err: " . $e->getMessage() . "\n";
    exit();
  }
?>