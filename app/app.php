<?php

require_once('../config.php');

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

function items() {
  return query(function($db) {
      return $db->querySingle('SELECT id, title, units, price FROM items');
  });
}

function price($id)
{
    return query(function($db) {
        return $db->querySingle('SELECT price FROM bottles');
    });
}

function units()
{
    return query(function($db) {
        return $db->querySingle('SELECT b.units - (SELECT coalesce(SUM(units), 0) FROM orders) as units FROM bottles b');
    });
}

?>
