<?php

/**
 * Removes an email.
 *
 * @param      <type>  $email  The email
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function remove_email($email)
{
    $remove_email_list = [
        'marshal@smedia.ca'
    ];

    return array_diff($email, $remove_email_list);
}


/**
 * { function_description }
 *
 * @param      <type>   $arr1   The arr 1
 * @param      <type>   $arr2   The arr 2
 *
 * @return     integer  ( description_of_the_return_value )
 */
function check_array_is_same($arr1, $arr2)
{
    if (sizeof($arr1) != sizeof($arr2)) {
        return 0;
    }

    foreach ($arr1 as $key1 => $value1) {
        $check = 0;

        foreach ($arr2 as $key2 => $value2) {
            if ($value1 == $value2) {
                $check = 1;
            }
        }

        if ($check == 0) {
            return 0;
        }
    }

    return 1;
}


/**
 * { function_description }
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function random_number()
{
    return md5(microtime() . mt_rand());
}


/**
 * Gets all ves.
 *
 * @param      string  $dealership  The dealership
 * @param      string  $service     The service
 *
 * @return     <type>  All ves.
 */
function getAllVES($dealership = '', $service = '')
{
    if ($service = 'forward_to') {
        $query = "SELECT * FROM email_verifications where dealership = '$dealership' and service = '$service'";
    } else {
        $query = "SELECT * FROM email_verifications where dealership = '$dealership' and service != '$service'";
    }

    return $result = DbConnect::get_instance()->query($query);
}


/**
 * Gets the last ves.
 *
 * @param      string  $dealership  The dealership
 * @param      string  $service     The service
 *
 * @return     array   The last ves.
 */
function getLastVES($dealership = '', $service = '')
{
    $query = "SELECT * FROM email_verifications where dealership = '$dealership' and service = '$service' ORDER BY ev_id DESC LIMIT 1";
    $result = DbConnect::get_instance()->query($query);
    $array = mysqli_fetch_assoc($result);
    return $array;
}


/**
 * { function_description }
 *
 * @param      string  $dealership  The dealership
 * @param      string  $service     The service
 * @param      string  $email_list  The email list
 *
 * @return     array   ( description_of_the_return_value )
 */
function insertEmailVerifications($dealership = '', $service = '', $email_list = '')
{
    $query = "UPDATE email_verifications SET varified='1' where dealership = '$dealership' and service = '$service'";
    DbConnect::get_instance()->query($query);

    $email_list = preg_replace('#\s+#', ',', trim($email_list));
    $remove_email = remove_email(explode(',', $email_list));
    $final_email_list = implode(",", $remove_email);

    $token = random_number();

    $ev_details =
        [
            'dealership' => $dealership,
            'service' => $service,
            'email_list' => $final_email_list,
            'match_key' => $token
        ];

    $query_parameters = DbConnect::get_instance()->prepare_query_params($ev_details, DbConnect::PREPARE_PARENTHESES);
    $query = "INSERT INTO email_verifications $query_parameters";
    DbConnect::get_instance()->query($query);

    sendVerificationEmail($token, $remove_email, $service);

    return $ev_details;
}


/**
 * { function_description }
 *
 * @param      string  $token       The token
 * @param      string  $service     The service
 * @param      string  $email_list  The email list
 */
function reSendEmail($token = '', $service = '', $email_list = '')
{
    $remove_email = explode(',', $email_list);

    sendVerificationEmail($token, $remove_email, $service);
}


/**
 * Sends a verification email.
 *
 * @param      string  $token       The token
 * @param      string  $email_list  The email list
 * @param      string  $service     The service
 */
function sendVerificationEmail($token = '', $email_list = '', $service = '')
{
    $domain_name = $_SERVER['SERVER_NAME'];

    if ($service == 'forward_to') {
        $service = 'Smart Offer Service';
    } else {
        $service = 'Form Live Service';
    }

    $msg = "<div style='font-size: 16px;'>
                Dear sir,<br>
                <br>
                You received a request for <strong> {$service} </strong> from sMedia in this mail. To active the service, please click<br>
                this button:<br>
                <br>
                &nbsp; <a style='   background-color: #007bff; 
                                    border-color: #007bff; 
                                    color: #ffffff; 
                                    border-radius: 5px;
                                    box-sizing: border-box;
                                    display: inline-block;
                                    font-size: 16px;
                                    font-weight: bold;
                                    padding: 12px 25px;
                                    text-decoration: none;' 
                href='{$domain_name}/dashboard/client-management/service_email.php?key={$token}' target='_blank'>Active {$service}</a><br>
                <br>
                or click the link 
                <br>
                <a style='text-decoration: none;' 
                href='{$domain_name}/dashboard/client-management/service_email.php?key={$token}' target='_blank'>{$domain_name}/dashboard/client-management/service_email.php?key={$token}</a><br>
                <br>
                Best regards,<br>
                sMedia <br>
                <br>
                ______________________________<wbr>____________________<br>
                Please be aware that this is an unmonitored email alias,<br>
                so please do not reply to this email.<br>
                To contact sMedia click the link<br>
                <a style='text-decoration: none; font-size: 16px; font-weight: bold; color: #007bff;'  href='https://smedia.ca' target='_blank'><img src='https://tm.smedia.ca/dashboard/assets-new/images/logo.png'/></a>
                <div>";

    $from = ['offers@smedia.ca'];
    $to = $email_list;
    $subject = 'Active form live service';

    SendEmail($to, $from, $subject, $msg);
}


/**
 * { function_description }
 *
 * @param string $service The service
 * @param $status
 * @param <type> $dealer The dealer
 * @param null $tos
 */
function serviceOnOffEmail($service, $status, $dealer, $tos = [])
{
    $msg = "<div style='font-size: 16px;'>
                Dear sir,<br>
                <br>
                The $service service is currently turn $status for: <b>$dealer</b>. <br>
                Thank you.<br>
     
                <br>
                Best regards,<br>
                sMedia <br>
                <br>
                ______________________________<wbr>____________________<br>
                <a style='text-decoration: none; font-size: 16px; font-weight: bold; color: #007bff; '  href='https://smedia.ca' target='_blank' ><img src='https://smedia.ca/wp-content/themes/%40Smedia/images/logo.png'/></a>
                <div>";

    $from         = 'Smart Offer - sMedia <offers@smedia.ca>';

    $to     = ['tanvir@smedia.ca', 'support@smedia.ca'];

    if (!empty($tos)) {
        array_push($to, $tos);
    }

    $subject = "{$service} service is turn {$status} for: {$dealer}";

    SendEmail($to, $from, $subject, $msg);
}
