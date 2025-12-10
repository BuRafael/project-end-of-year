<?php
echo 'Template Dir URI: ' . get_template_directory_uri() . '<br>';
echo 'CSS Path: ' . get_template_directory_uri() . '/assets/css/profil.css' . '<br>';
echo 'Current Template: ' . get_page_template_slug() . '<br>';
echo 'Is Page Template profil: ' . (is_page_template('template-profil.php') ? 'true' : 'false') . '<br>';
?>
