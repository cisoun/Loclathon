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
    $shipping = $data['purchase_units'][0]['shipping'];

    $address = $shipping['address']['address_line_1'];
    if (array_key_exists('address_line_2', $shipping['address']))
        $address .= '\r\n' . $shipping['address']['address_line_2'];

    $array = array(
        'order_id'      => $data['id'],
        'payer_id'      => $payer['payer_id'],
        'full_name'     => $shipping['name']['full_name'],
        'email'         => $payer['email_address'],
        'phone'         => $payer['phone']['phone_number']['national_number'],
        'address'       => $address,
        'city'          => $shipping['address']['admin_area_2'],
        'postal_code'   => $shipping['address']['postal_code'],
        'country'       => $shipping['address']['country_code'],
        'units'         => $items['quantity'],
        'amount'        => $items['quantity'] * price($data),
        'status'        => '1',
        'date'          => $data['create_time']
    );

    // At this point, send the confirmation to the customer and try to register
    // the order into the database. If it fails, it should be visible in the
    // dashboard of Paypal.

    sendConfirmation($array);

    $result = query(function($db) use ($array) {
        $query = sql_build_insert($db, 'orders', $array);
        $result = $query->execute();
        if ($result)
            $result->finalize();
        return $result;
    });

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
        $data['full_name'],
        str_replace('\r\n', '<br/>', $data['address']),
        $data['postal_code'] . ' ' . $data['city'],
        $data['country']
    );
    $customer = implode('<br/>', $customer);

    $message = str_replace('[CUSTOMER]', $customer, $message);
    $message = str_replace('[AMOUNT]', $data['amount'], $message);
    $message = str_replace('[UNITS]', $data['units'], $message);
    $message = str_replace('[LOGO]', $CONFIG['logo'], $message);

    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=utf-8';
    $headers[] = "To: <$to>";
    $headers[] = 'From: Le Loclathon <' . $CONFIG['email'] . '>';
    $headers[] = 'Bcc: ' .  implode(',', $CONFIG['agents']);
    $headers[] = 'Reply-To: ' . $CONFIG['email'];
    $headers[] = 'Return-Path: ' . $CONFIG['email'];
    $headers[] = 'X-Mailer: PHP/' . phpversion();
    $headers[] = 'X-MSMail-Priority: High';

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
