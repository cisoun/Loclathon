<?php
require_once '../config.php';
require_once 'db.php';

function buy($data)
{
    $payer = $data['payer'];
    $items = $data['purchase_units'][0]['items'][0];
    $shipping = $data['purchase_units'][0]['shipping'];

    $address = $shipping['address']['address_line_1'];
    if (array_key_exists('address_line_2', $shipping['address']))
        $address .= chr(10) . $shipping['address']['address_line_2'];

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
    // dashboard of Paypal anyway.

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

function price()
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
        str_replace(chr(10), '<br/>', $data['address']),
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

function units()
{
    return query(function($db) {
        return $db->querySingle('SELECT b.units - (SELECT coalesce(SUM(units), 0) FROM orders) as units FROM bottles b');
    });
}
?>
