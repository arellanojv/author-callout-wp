<?php
function eeat_custom_user_profile_fields($user)
{
  $output = '';
  $output .= '<h2>' . __("EEAT fields", "custom-eeat-fields") . '</h2>';
  $output .= '<table class="form-table">';
  $output .= '<tr>';
  $output .= '<th><label for="headshot">' . __("Headshot Link", "custom-eeat-fields") . '</label></th>';
  $output .= '<td>';
  $output .= '<input placeholder="' . __("Headshot Link Here", "custom-eeat-fields") . '" type="url" name="headshot" id="headshot" value="' . esc_attr(get_user_meta($user->ID, 'headshot', true)) . '" class="regular-text" /><br />';
  $output .= '<span class="description">' . __("Get the image link from the media and paster it here.", "custom-eeat-fields") . '</span>';
  $output .= '</td>';
  $output .= '</tr>';
  $output .= '<tr>';
  $output .= '<th><label for="bio">' . __("Bio", "custom-eeat-fields") . '</label></th>';
  $output .= '<td>';
  $output .= '<textarea rows="5" cols="30" placeholder="' . __("Bio Here", "custom-eeat-fields") . '" name="bio" id="bio" class="regular-text" /> ' . esc_attr(get_user_meta($user->ID, 'bio', true)) . ' </textarea><br />';
  $output .= '<span class="description">' . __("", "custom-eeat-fields") . '</span>';
  $output .= '</td>';
  $output .= '</tr>';
  $output .= '<tr>';
  $output .= '<th><label for="about">' . __("About Link", "custom-eeat-fields") . '</label></th>';
  $output .= '<td>';
  $output .= '<input placeholder="' . __("About Link Here", "custom-eeat-fields") . '" type="url" name="about" id="about" value="' . esc_attr(get_user_meta($user->ID, 'about', true)) . '" class="regular-text" /><br />';
  $output .= '<span class="description">' . __("", "custom-eeat-fields") . '</span>';
  $output .= '</td>';
  $output .= '</tr>';
  $output .= '</table>';
  echo $output;
}
add_action('show_user_profile', 'eeat_custom_user_profile_fields');
add_action('edit_user_profile', 'eeat_custom_user_profile_fields');

// Save Custom User Profile Fields
function eeat_custom_user_profile_fields_save($user_id)
{
  if (!current_user_can('edit_user', $user_id)) {
    return false;
  }
  update_user_meta($user_id, 'headshot', $_POST['headshot']);
  update_user_meta($user_id, 'bio', $_POST['bio']);
  update_user_meta($user_id, 'about', $_POST['about']);
}
add_action('personal_options_update', 'eeat_custom_user_profile_fields_save');
add_action('edit_user_profile_update', 'eeat_custom_user_profile_fields_save');
