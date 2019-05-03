<?php
#ini_set('display_errors', 1);
#error_reporting(E_ALL);

require_once 'config.php';

function sql_build_insert($db, $table, $array)
{
    $keys = array_keys($array);

    $query = 'INSERT INTO %s ( %s ) VALUES ( %s )';
    $insert = implode(',', $keys);
    $values = ':' . implode(',:', $keys);

    $query = sprintf($query, $table, $insert, $values);
    $stmt = $db->prepare($query);

    foreach ($array as $key => $value)
        $stmt->bindValue(':' . $key, $value);

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
        'amount'        => $items['quantity'] * price($data),
        'status'        => '1',
        'date'          => $data['create_time']
    );

    $result = query(function($db) use ($array) {
        $query = sql_build_insert($db, 'orders', $array);
        $result = $query->execute();
        if ($result)
            $result->finalize();
        return $result;
    });

    sendConfirmation($array);

    return array(
        'success' => $result !== false,
        'email' => $array['email']
    );
}

function price($data)
{
    return query(function($db) {
        return $db->querySingle('SELECT price FROM bottles');
    });
}

function sendConfirmation($data)
{
    global $CONFIG;

    $to = $data['email'];
    $subject = 'Merci pour votre achat !';
    $message = file_get_contents('email.html');

    $customer = array(
        $data['first_name'] . ' ' . $data['last_name'],
        $data['address'],
        $data['postal_code'] . ' ' . $data['city'],
        $data['country']
    );
    $customer = implode('<br/>', $customer);

    $message = str_replace('[CUSTOMER]', $customer, $message);
    $message = str_replace('[AMOUNT]', $data['amount'], $message);
    $message = str_replace('[UNITS]', $data['units'], $message);
    $message = str_replace('[LOGO]', $CONFIG['logo'], $message);

    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
    $headers[] = "To: <$to>";
    $headers[] = 'From: Le Loclathon <' . $CONFIG['email'] . '>';

    mail($to, $subject, $message, implode("\r\n", $headers));
}

function units($data)
{
    return query(function($db) {
        return $db->querySingle('SELECT b.units - (SELECT coalesce(SUM(units), 0) FROM orders) as units FROM bottles b');
    });
}

# Get request's body (JSON).
$data = array();
$input = file_get_contents('php://input');
if ($input !== false)
    $data = json_decode($input, true);

# Route.
$url = substr($_SERVER['REQUEST_URI'], 5); # Remove '/api/' from URL.'
header('Content-type: application/json');
echo(json_encode(call_user_func($url, $data)));
?>
