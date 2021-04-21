<?php

include 'keys.php';

function display_header() {
    return
    "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <link href='css/styles.css' type='text/css' rel='stylesheet'>
        <meta content='width=device-width, initial-scale=1' name='viewport' />
    </head>
    <body>";
}

function display_form_title($title) {
    return "<h3>$title</h3>";
}

function display_form_description($description) {
    return "<p>$description</p>";
}

function begin_form() {
    return "<form action='{$_SERVER['PHP_SELF']}' method='post'>";
}

function display_email_input() {
    return "<label class='field-label' for='email'>Email:<span style='color:red'> *</span></label>
    <input type='email' name='email' id='email' required>";
}

function display_phone_input() {
    return "<label class='field-label' for='phone'>Phone number (optional):</label>
    <input type='tel' name='phone' id='phone'>";
}

function display_checkbox_label($label) {
    return "<label class='field-label'>$label</label>";
}

function hidden_checkbox($tag) {
    $year = date("Y");

    return "<li><input class='hidden' type='checkbox' name='tags[]' value='$tag interest $year' id='$tag' checked='checked'>
            <label class='checkbox-description hidden' for='$tag'>$tag</label></li>";
}

function display_checkbox($tag) {

    $year = date("Y");

    return "<li><input type='checkbox' name='tags[]' value='$tag interest $year' id='$tag'>
            <label class='checkbox-description' for='$tag'>$tag</label></li>";
}

function display_submit_button($button_name) {
    return "<button type='submit' name='$button_name'>Submit</button>
    </form>";
}

function add_subscriber($email, $key, $phone_number="", $list_id) {

    //get the server from the key
    $server = substr($key, stripos($key, "-") + 1);

    $fields = [
        'email_address' => $email,
        'status'=> 'subscribed',
        'merge_fields' => [
            // 'FNAME' => '',
            // 'LNAME' => '',
            'PHONE' => $phone_number
        ],
    ];

    $json_fields_array = json_encode($fields);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://$server.api.mailchimp.com/3.0/lists/$list_id/members/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $json_fields_array,
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer $key",
            'Content-Type: application/json'
            ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    // echo $response;
}

function add_tag($email, $new_tags, $key, $list_id) {

    //get the server from the key
    $server = substr($key, stripos($key, "-") + 1);

    $email_hash = md5(strtolower($email));

    $tags_array1 = [
        [
            "name" => 'Recruitment',
            "status" => 'active'
        ]
    ];

    foreach ($new_tags as $tag) {
        //convert to a series of key value pairs
        $temp_array = [
            "name" => $tag,
            "status" => 'active'
        ];
        array_push($tags_array1, $temp_array);
    }

    $tags_array2 = [
        "tags" => $tags_array1
    ];

    $json_tags_array = json_encode($tags_array2);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://$server.api.mailchimp.com/3.0/lists/$list_id/members/$email_hash/tags",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $json_tags_array,
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer $key",
            'Content-Type: application/json'
            ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    // echo $response;
}

function subscribe_and_tag($form_name, $key, $list_id) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST[$form_name])) {
        add_subscriber($_POST['email'], $key,$_POST['phone'], $list_id);
        add_tag($_POST['email'], $_POST['tags'], $key, $list_id);
        echo "<p>Thanks for signing up!</p>";
        $message = "{$_POST['email']} signed to learn more about {$_POST['tags']}";
        mail('sarah@oneworldnow.org', 'New signup via website', $message);
    }
}

?>
