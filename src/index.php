<?php
// A single-page PHP script which displays a short list of famous authors.

define('MYSQL_USERNAME', 'root');
define('MYSQL_PASSWORD', 'admin');

function connectToDB() {
    return new PDO('mysql:host=mariadb;dbname=authors_db', MYSQL_USERNAME, MYSQL_PASSWORD);
}

function getAuthors() {
    $pdo = connectToDB();
    $stmt = $pdo->query('select author_name as name from authors');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
<html>
    <head>
        <title>A Short List of Famous Authors</title>
    </head>
    <body>
        <table border="1">
            <tr>
                <th>Author Name</th>
            </tr>
<?php
foreach (getAuthors() as $author => $authors) {
    echo "<tr>\n";
    echo "    <td>$authors[name]</td>\n";
    echo "</tr>\n";
}
?>
            </tr>
        <table>
    </body>
</html>