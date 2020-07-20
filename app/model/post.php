<?PHP
  require 'functions.php';

  class Post {
    static function create($params) {
      require 'pdo_connect.php';

      $stmt = $dbh->prepare('
        INSERT INTO posts (
          user_id,
          text
        ) VALUES (
          :user_id,
          :text
        )
      ');

      $insert_data = array(
        ':user_id' => $params['user_id'],
        ':text' => h($params['text'])
      );

      return $stmt->execute($insert_data);
    }

    static function delete($params) {
      require 'pdo_connect.php';

      $stmt = $dbh->prepare('
        SELECT user_id FROM posts
        WHERE id=:id
      ');

      $stmt->execute([':id' => $params['id']]);

      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if($result['user_id'] === $params['user_id']) {
        $stmt = $dbh->prepare('
          DELETE FROM posts
          WHERE id=:id
        ');
        $stmt->execute([':id' => $params['id']]);
      }
    }

    static function fetch_all() {
      require 'pdo_connect.php';

      return $dbh->query('
        SELECT
          posts.id,
          posts.text,
          posts.user_id,
          posts.create_at,
          posts.updated_at,
          users.name AS create_by
        FROM
          posts
        INNER JOIN
          users
        ON
          posts.user_id = users.id
        ORDER BY id DESC
      ');
    }
  }
?>