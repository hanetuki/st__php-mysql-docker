<?PHP
  require 'functions.php';

  class User {
    static function login($params) {
      require 'pdo_connect.php';

      $stmt = $dbh->prepare('
        SELECT * From users
        WHERE email=:email
      ');

      $insert_data = [':email' => h($params['email'])];

      $stmt->execute($insert_data);

      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if(password_verify($params['password'], $result['password'])) {
        return $result;
      }

      return false;
    }

    static function sign_up($params) {
      require 'pdo_connect.php';

      $stmt = $dbh->prepare('
        INSERT INTO users (
          name,
          email,
          password
        ) VALUES (
          :name,
          :email,
          :password
        )
      ');

      $insert_data = [
        ':name' => h($params['name']),
        ':email' => h($params['email']),
        ':password' => password_hash($params['password'], PASSWORD_DEFAULT)
      ];

      return $stmt->execute($insert_data);
    }
  }
?>