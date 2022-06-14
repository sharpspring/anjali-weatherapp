<?php
// A single-page PHP script which displays a short list of famous authors.

define('MYSQL_USERNAME', 'root');
define('MYSQL_PASSWORD', 'admin');

function connectToDB() {
    return new PDO('mysql:host=mariadb;dbname=weatherapp', MYSQL_USERNAME, MYSQL_PASSWORD);
}

function getAuthors() {
    $pdo = connectToDB();
    $stmt = $pdo->query('select * from location;');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
<html>
    <head>
        <title>A Weather App</title>
    </head>
    <body>
        <table border="1">
            <tr>
                <th>Weather Name</th>
            </tr>
<?php
foreach (getAuthors() as $author => $authors) {
    echo "<tr>\n";
    echo "    <td>$authors[city_name]</td>\n";
    echo "</tr>\n";
}
?>
            </tr>
        <table>
    </body>
</html>
