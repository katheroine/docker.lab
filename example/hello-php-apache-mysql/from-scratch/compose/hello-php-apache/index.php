<h1>Hello, world!!!</h1>
<p>This is Docker example application in PHP <?php echo phpversion(); ?> on Apache.</p>

<?php
try {
    $connection = new mysqli('hello-world-with-mysql-from-scratch', 'hello', 'hello', 'hello');
    if ($connection->connect_error) {
      die('Database connection failed: ' . $connection->connect_error);
    }
    echo('<h3>Top popular fruits</h3>');
    $result = $connection->query('SELECT * FROM fruits');
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo('<div>id: ' . $row['id']. ' - name: ' . $row['name']. ', color ' . $row['color']. '</div>');
      }
    } else {
      echo("<p>No items in the database.</p>");
    }
    $connection->close();
} catch (\Exception $error) {
    var_dump($error);
}
?>
