<?php
function sql_build_insert($db, $table, $array)
{
    $keys = array_keys($array);

    $query = 'INSERT INTO %s ( %s ) VALUES ( %s )';
    $query_keys = implode(',', $keys);
    $query_values = ':' . implode(',:', $keys);

    $query = sprintf($query, $table, $query_keys, $query_values);
    $stmt = $db->prepare($query);

    foreach ($array as $key => $value)
        $stmt->bindValue(':' . $key, $value);

    return $stmt;
}

function query($callback)
{
    $db = new SQLite3(dirname(__DIR__) . '/api/database.db');
    $results = $callback($db);
    $db->close();

    return $results;
}
?>
