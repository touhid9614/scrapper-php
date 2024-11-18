<?php
/**/

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require_once '../config.php';
require_once '../utils.php';
require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';

use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

$params = [
    'lead_email'    => 'webleads@westerngm.com',
    'company_name'  => 'Western GMC Buick',
    'company_email' => 'chad@westerngm.com',
    'stock_type'    => 'used',
    'stock_number'  => '17CH06',
    'year'          => '2017',
    'make'          => 'Dodge',
    'model'         => 'Charger',
    'total_count'   => '1',
    'fdt'           => date('Y-m-dTG:i:s'),
    'first_name'    => 'John',
    'last_name'     => 'Doe',
    'email'         => 'j.doe@gmail.com',
    'phone'         => '855-775-0062',
    'comments'      => 'Sample question asked by client?'
];

$template = '<?xml version="1.0"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <id sequence="[total_count]" source="[company_name]"></id>
        <requestdate>[fdt]</requestdate>
        <vehicle interest="buy" status="[stock_type]">
            <year>[year]</year>
            <make>[make]</make>
            <model>[model]</model>
            <stock>[stock_number]</stock>
        </vehicle>

       <customer>
           <contact>
                <name part="first">[first_name]</name>
                <name part="last">[last_name]</name>
                <email>[email]</email>
                <phone>[phone]</phone>
            </contact>
            <comments>[comments]</comments>
       </customer>

        <vendor>
            <contact>
                <name part="full">[company_name]</name>
                <email>[company_email]</email>
            </contact>
        </vendor>
        <provider>
            <name part="full">sMedia</name>
            <url>http://smedia.ca</url>
            <email>offers@mail.smedia.ca</email>
            <phone>855-775-0062</phone>
        </provider>
    </prospect>
</adf>';

$xml = processTextTemplate($template, $params);
//
///**
//    host: email-smtp.us-east-1.amazonaws.com
//    port: 587
//    region: us-east-1
//    user: AKIAJK2PQ2QGV5X6XHHA
//    pass: Ah+d+/iH4Y/AmmtlLgumhzNunhAQn5EnfXFokLLYJo4D
// */
//$SesClient = SesClient::factory([
//    'version' => '2010-12-01',
//    'region'  => 'us-east-1',
//    'key'     => 'AKIAJK2PQ2QGV5X6XHHA',
//    'pass'    => 'Ah+d+/iH4Y/AmmtlLgumhzNunhAQn5EnfXFokLLYJo4D'
//]);
//
//$sender_email = 'offers@smedia.ca';
//
//$recipient_emails = ['masterkeyy@gmail.com'];
//
//$subject = 'Amazon SES test (AWS SDK for PHP)';
//$plaintext_body = 'This email was sent with Amazon SES using the AWS SDK for PHP.' ;
//$html_body =  '<h1>AWS Amazon Simple Email Service Test Email</h1>'.
//              '<p>This email was sent with <a href="https://aws.amazon.com/ses/">'.
//              'Amazon SES</a> using the <a href="https://aws.amazon.com/sdk-for-php/">'.
//              'AWS SDK for PHP</a>.</p>';
//$char_set = 'UTF-8';
//
//try {
//    $result = $SesClient->sendEmail([
//        'Destination' => [
//            'ToAddresses' => $recipient_emails,
//        ],
//        'ReplyToAddresses' => [$sender_email],
//        'Source' => $sender_email,
//        'Message' => [
//        'Body' => [
//            'Html' => [
//                'Charset' => $char_set,
//                'Data' => $html_body,
//            ],
//            'Text' => [
//                'Charset' => $char_set,
//                'Data' => $plaintext_body,
//            ],
//        ],
//        'Subject' => [
//            'Charset' => $char_set,
//            'Data' => $subject,
//        ],
//        ]
//    ]);
//    $messageId = $result['MessageId'];
//    echo("Email sent! Message ID: $messageId"."\n");
//} catch (AwsException $e) {
//    // output error message if fails
//    echo $e->getMessage();
//    echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
//    echo "\n";
//}

echo SendEmail([$params['lead_email'], 'masterkeyy@gmail.com'], 'offers@smedia.ca',
            processTextTemplate('New Contact Request from [first_name] [last_name]', $params),
            $xml, 'text/plain');
/** /
$additional_headers = "From: sMedia<offers@smedia.ca>\r\nReply-To: offers@smedia.ca\r\nContent-Type: text/plain\r\n" . 'X-Mailer: PHP/' . phpversion();

$headers = array(
    'From'          => 'Smedia<offers@smedia.ca>',
    'Reply-To'      => 'offers@smedia.ca',
    'Content-Type'  => 'text/plain',
    'X-Mailer'      => 'PHP/' . phpversion()
);

echo mail('masterkeyy@gmail.com', "Test Message", "Message Body", $headers);
/**/