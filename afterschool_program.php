<?php
include 'config.php';

$form_name = "afterschool_program_form";

echo display_header();
echo display_form_title("Get notified: After-School Program");
echo display_form_description("Registration for our after-school program is available in August and September every year. Sign up to get notified when registration opens.");
echo begin_form();
echo display_email_input();
echo display_phone_input();
echo display_checkbox_label("What are you interested in studying?");
echo display_checkbox("Arabic");
echo display_checkbox("Korean");
echo display_checkbox("Mandarin Chinese");
echo display_checkbox("Russian");
echo display_checkbox("Leadership");
echo hidden_checkbox("Afterschool program");
echo display_submit_button($form_name);

subscribe_and_tag($form_name, $afterschool_program_interest_form_key, $own_list_id);
?>