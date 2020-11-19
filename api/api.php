<?php
#ini_set('display_errors', 1);
#error_reporting(E_ALL);

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';
require_once 'config.php';

function array_deep_find($array, $default, ...$keys)
{
    foreach ($keys as $k) {
        if (array_key_exists($array, $k)) {
            $array = $array[$k];
        } else {
            return $default;
        }
    }

    return $array;
}

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
        $address .= chr(10) . $shipping['address']['address_line_2'];

    $phone = array_deep_find($payer, '', 'phone', 'phone_number', 'national_number');

    $array = array(
        'order_id'      => $data['id'],
        'payer_id'      => $payer['payer_id'],
        'full_name'     => $shipping['name']['full_name'],
        'email'         => $payer['email_address'],
        'phone'         => $phone,
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

function price($data)
{
    return query(function($db) {
        return $db->querySingle('SELECT price FROM bottles');
    });
}

function sendConfirmation($data)
{
    global $CONFIG;

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    $to = $data['email'];
    $subject = 'Merci pour votre achat !';
    $body = file_get_contents('email.html');

    $customer = array(
        $data['full_name'],
        str_replace(chr(10), '<br/>', $data['address']),
        $data['postal_code'] . ' ' . $data['city'],
        $data['country']
    );
    $customer = implode('<br/>', $customer);

    $body = str_replace('[CUSTOMER]', $customer, $body);
    $body = str_replace('[AMOUNT]', $data['amount'], $body);
    $body = str_replace('[UNITS]', $data['units'], $body);
    $body = str_replace('[LOGO]', $CONFIG['logo'], $body);

    //Server settings
    $mail->isSMTP();
    $mail->Host       = gethostbyname($CONFIG['host']);
    $mail->SMTPAuth   = true;
    $mail->Username   = $CONFIG['email'];
    $mail->Password   = $CONFIG['password'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    # Make it quicker.
    $mail->SMTPOptions = array('ssl' => array('verify_peer_name' => false));

    //Recipients
    $mail->setFrom($CONFIG['email'], 'Le Loclathon');
    $mail->addAddress($to);
    $mail->addReplyTo($CONFIG['noreply'], 'Le Loclathon');
    foreach ($CONFIG['agents'] as $agent) {
        $mail->addBCC($agent);
    }

    // Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    $mail->send();
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
