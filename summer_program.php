<?php
include 'config.php';

$form_name = "summer_program_form";

echo display_header();
echo display_form_title("Get notified when registration opens for summer language programs");
echo begin_form();
echo display_email_input();
echo display_phone_input();
echo display_checkbox_label("Which languages are you interested in studying?");
echo display_checkbox("Arabic");
echo display_checkbox("Korean");
echo display_checkbox("Mandarin Chinese");
echo hidden_checkbox("Summer program");
echo display_submit_button($form_name);

subscribe_and_tag($form_name, $summer_program_interest_form_key, $own_list_id);
?>