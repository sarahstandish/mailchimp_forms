<?php
include 'config.php';

$form_name = "study_abroad_form";

echo display_header();
echo display_form_title("Get notified: Study abroad");
echo display_form_description("Sign up to get notified when study abroad applications are available.");
echo begin_form();
echo display_email_input();
echo display_phone_input();
echo display_checkbox_label("Which program(s) are you interested in?");
echo display_checkbox("Morocco study abroad");
echo display_checkbox("South Korea study abroad");
echo display_checkbox("Russia study abroad");
echo display_checkbox("Tunisia study abroad");
echo display_checkbox("China study abroad");
echo display_submit_button($form_name);

subscribe_and_tag($form_name, $study_abroad_interest_form_key, $own_list_id);

