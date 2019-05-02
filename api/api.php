<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

function sql_build_insert($db, $table, $array)
{
    $keys = array_keys($array);

    $query = 'INSERT INTO %s ( %s ) VALUES ( %s )';
    $insert = implode(',', $keys);
    $values = ':' . implode(',:', $keys);

    $query = sprintf($query, $table, $insert, $values);
    $stmt = $db->prepare($query);

    foreach ($array as $key => $value)
    {
        $stmt->bindValue(':' . $key, $value);
    }

    return $stmt;
}

function query($callback)
{
    $db = new SQLite3('database.db');
    $results = $callback($db);
    $db->close();

    return $results;
}

function buy($data)
{
    $payer = $data['payer'];
    $items = $data['purchase_units'][0]['items'][0];

    $array = array(
        'order_id'      => $data['id'],
        'payer_id'      => $payer['payer_id'],
        'first_name'    => $payer['name']['given_name'],
        'last_name'     => $payer['name']['surname'],
        'email'         => $payer['email_address'],
        'phone'         => $payer['phone']['phone_number']['national_number'],
        'address'       => $payer['address']['address_line_1'],
        'city'          => $payer['address']['admin_area_2'],
        'postal_code'   => $payer['address']['postal_code'],
        'country'       => $payer['address']['country_code'],
        'units'         => $items['quantity'],
        'amount'        => $data['purchase_units'][0]['amount']['value'],
        'status'        => '1',
        'date'          => $data['create_time']
    );

    return query(function($db) use ($array) {
        $query = sql_build_insert($db, 'orders', $array);
        $result = $query->execute();
        $query->finalize();

        return array(
            'success' => $result !== false,
            'email' => $array['email']
        );
    });
}

function price($data)
{
    return query(function($db) {
        return $db->querySingle('SELECT price FROM bottles');
    });
}

function units($data)
{
    return query(function($db) {
        return $db->querySingle('SELECT b.units - (SELECT coalesce(SUM(units), 0) FROM orders) as units FROM bottles b');
    });
}


$data = array();
$input = file_get_contents('php://input');
if ($input !== false)
    $data = json_decode($input, true);

$url = substr($_SERVER['REQUEST_URI'], 5); # Remove '/api/' from URL.'
header('Content-type: application/json');
echo(json_encode(call_user_func($url, $data)));
?>
