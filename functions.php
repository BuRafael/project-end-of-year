<?php
/**
 * Theme Functions
 */

// Theme setup
function theme_setup()
{
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    register_nav_menus([
        'primary' => __('Primary Menu', 'project-end-of-year'),
        'footer'  => __('Footer Menu', 'project-end-of-year'),
    ]);
}
add_action('after_setup_theme', 'theme_setup');

// Create default pages on theme activation
function create_theme_pages()
{
    // Create Fiche Film Inception page
    $inception_page = get_page_by_path('inception');
    if (!$inception_page) {
        $page_id = wp_insert_post([
            'post_title'     => 'Inception',
            'post_name'      => 'inception',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_content'   => ''
        ]);
        
        // Set the page template
        if ($page_id && !is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'template-fiche-film.php');
        }
    } else {
        // Update template if page exists but template is not set
        $current_template = get_post_meta($inception_page->ID, '_wp_page_template', true);
        if ($current_template !== 'template-fiche-film.php') {
            update_post_meta($inception_page->ID, '_wp_page_template', 'template-fiche-film.php');
        }
    }

    // Create Signup Step 1 page
    $signup_page = get_page_by_path('inscription');
    if (!$signup_page) {
        $page_id = wp_insert_post([
            'post_title'     => 'Inscription',
            'post_name'      => 'inscription',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_content'   => ''
        ]);
        
        if ($page_id && !is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'template-register.php');
        }
    } else {
        $current_template = get_post_meta($signup_page->ID, '_wp_page_template', true);
        if ($current_template !== 'template-register.php') {
            update_post_meta($signup_page->ID, '_wp_page_template', 'template-register.php');
        }
    }

    // Create Signup Step 2 page
    $step2_page = get_page_by_path('signup-step2');
    if (!$step2_page) {
        $page_id = wp_insert_post([
            'post_title'     => 'Inscription - Étape 2',
            'post_name'      => 'signup-step2',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_content'   => ''
        ]);
        
        if ($page_id && !is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'template-register-step2.php');
        }
    } else {
        $current_template = get_post_meta($step2_page->ID, '_wp_page_template', true);
        if ($current_template !== 'template-register-step2.php') {
            update_post_meta($step2_page->ID, '_wp_page_template', 'template-register-step2.php');
        }
    }

    // Create Login page
    $login_page = get_page_by_path('login');
    if (!$login_page) {
        $page_id = wp_insert_post([
            'post_title'     => 'Connexion',
            'post_name'      => 'login',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_content'   => ''
        ]);
        
        if ($page_id && !is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'Connexion.php');
        }
    } else {
        $current_template = get_post_meta($login_page->ID, '_wp_page_template', true);
        if ($current_template !== 'Connexion.php') {
            update_post_meta($login_page->ID, '_wp_page_template', 'Connexion.php');
        }
    }

    // Create Profil page
    $profil_page = get_page_by_path('profil');
    if (!$profil_page) {
        $page_id = wp_insert_post([
            'post_title'     => 'Mon Profil',
            'post_name'      => 'profil',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_content'   => ''
        ]);
        
        if ($page_id && !is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'template-profil.php');
        }
    } else {
        $current_template = get_post_meta($profil_page->ID, '_wp_page_template', true);
        if ($current_template !== 'template-profil.php') {
            update_post_meta($profil_page->ID, '_wp_page_template', 'template-profil.php');
        }
    }
}
add_action('after_switch_theme', 'create_theme_pages');
add_action('admin_init', 'create_theme_pages'); // Also run on admin init to ensure page exists

// Enqueue styles and scripts
function theme_scripts()
{
    $version = filemtime(get_template_directory() . '/functions.php'); // Use file modification time as cache buster
    
    // Disable script/style concatenation for Local environment
    if (!defined('CONCATENATE_SCRIPTS')) {
        define('CONCATENATE_SCRIPTS', false);
    }
    
    // External fonts / vendors
    wp_enqueue_style('typekit-cinemusic', 'https://use.typekit.net/isz1tod.css', array(), null);
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', array(), '5.3.3');
    wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css', array(), '1.11.1');
    
    // Bootstrap JS
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), '5.3.3', true);

    // Base styles (reset + global)
    wp_enqueue_style('base-style', get_template_directory_uri() . '/assets/css/base.css', array('bootstrap'), $version);
    
    // Header and Footer styles (loaded on all pages)
    wp_enqueue_style('header-style', get_template_directory_uri() . '/assets/css/Header.css', array('base-style'), $version);
    wp_enqueue_style('footer-style', get_template_directory_uri() . '/assets/css/footer.css', array('base-style'), $version);
    
    // Header and Footer scripts (loaded on all pages)
    wp_enqueue_script('header-script', get_template_directory_uri() . '/assets/js/Header.js', array(), $version, true);
    wp_enqueue_script('footer-script', get_template_directory_uri() . '/assets/js/footer.js', array(), $version, true);
    
    // Front page specific styles and scripts
    if (is_front_page()) {
        wp_enqueue_style('front-page-style', get_template_directory_uri() . '/assets/css/front-page.css', array('header-style', 'footer-style'), $version);
        wp_enqueue_script('front-page-script', get_template_directory_uri() . '/assets/js/front-page.js', array(), $version, true);
    }
    
    // Get current page template (handle both is_page_template() and fallback method)
    $current_template = get_page_template_slug(get_the_ID());
    if (empty($current_template) && is_page()) {
        $current_template = basename(get_post_meta(get_the_ID(), '_wp_page_template', true));
    }
    
    // Fiche film template styles and scripts
    if (is_page_template('template-fiche-film.php') || $current_template === 'template-fiche-film.php') {
        wp_enqueue_style('fiche-film-style', get_template_directory_uri() . '/assets/css/Fiche film.css', array('header-style', 'footer-style', 'bootstrap'), $version);
        wp_enqueue_script('fiche-film-script', get_template_directory_uri() . '/assets/js/fiche film.js', array('bootstrap-js'), $version, true);
    }
    
    // Registration template styles and scripts
    if (is_page_template('template-register.php') || $current_template === 'template-register.php') {
        wp_enqueue_style('register-style', get_template_directory_uri() . '/assets/css/register-step.css', array('base-style'), $version);
        wp_enqueue_script('register-script', get_template_directory_uri() . '/assets/js/register-step2.js', array(), $version, true);
    }
    
    // Login template styles and scripts
    if (is_page_template('Connexion.php') || $current_template === 'Connexion.php') {
        wp_enqueue_style('login-style', get_template_directory_uri() . '/assets/css/Connexion.css', array('base-style'), $version);
        wp_enqueue_script('login-script', get_template_directory_uri() . '/assets/js/Connexion.js', array(), $version, true);
    }
    
    // Profile page styles and scripts
    if (is_page_template('template-profil.php') || $current_template === 'template-profil.php') {
        wp_enqueue_style('profil-style', get_template_directory_uri() . '/assets/css/profil.css', array('header-style', 'footer-style'), $version);
        wp_enqueue_script('profil-script', get_template_directory_uri() . '/assets/js/profil.js', array(), $version, true);
    }
    
    // Global script (smooth scroll)
    wp_enqueue_script('theme-script', get_template_directory_uri() . '/assets/js/main.js', array('bootstrap-js'), $version, true);
}
add_action('wp_enqueue_scripts', 'theme_scripts');

// Add inline styles for pages with custom template structure (runs during wp_head())
function enqueue_custom_template_styles() {
    $version = filemtime(get_template_directory() . '/functions.php');
    
    // Profile page
    if (is_page_template('template-profil.php')) {
        echo '<link rel="stylesheet" href="' . esc_url(get_template_directory_uri() . '/assets/css/profil.css') . '?v=' . $version . '">' . "\n";
    }
    
    // Fiche film page
    if (is_page_template('template-fiche-film.php')) {
        echo '<link rel="stylesheet" href="' . esc_url(get_template_directory_uri() . '/assets/css/Fiche film.css') . '?v=' . $version . '">' . "\n";
    }
}
add_action('wp_head', 'enqueue_custom_template_styles', 5);

// Handle user registration
function handle_user_registration()
{
    if (isset($_POST['register_submit']) && isset($_POST['register_nonce']) && wp_verify_nonce($_POST['register_nonce'], 'register_action')) {
        $username = sanitize_user($_POST['user_login']);
        $email = sanitize_email($_POST['user_email']);
        $password = $_POST['user_pass'];
        $password_confirm = $_POST['user_pass_confirm'];

        if ($password !== $password_confirm) {
            wp_redirect(home_url('/inscription?registration=error'));
            exit;
        }

        // Vérifier si l'email existe déjà
        if (email_exists($email)) {
            wp_redirect(home_url('/inscription?registration=email_exists'));
            exit;
        }

        // Vérifier si l'username existe déjà
        if (username_exists($username)) {
            wp_redirect(home_url('/inscription?registration=username_exists'));
            exit;
        }

        $user_id = wp_create_user($username, $password, $email);

        if (!is_wp_error($user_id)) {
            if (isset($_POST['first_name'])) {
                update_user_meta($user_id, 'first_name', sanitize_text_field($_POST['first_name']));
            }
            if (isset($_POST['last_name'])) {
                update_user_meta($user_id, 'last_name', sanitize_text_field($_POST['last_name']));
            }
            if (isset($_POST['phone'])) {
                update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
            }
            if (isset($_POST['student_id'])) {
                update_user_meta($user_id, 'student_id', sanitize_text_field($_POST['student_id']));
            }

            $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
            $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
            if ($first_name || $last_name) {
                wp_update_user(array(
                    'ID' => $user_id,
                    'display_name' => trim($first_name . ' ' . $last_name),
                    'first_name' => $first_name,
                    'last_name' => $last_name
                ));
            }

            // Connecter automatiquement l'utilisateur
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id, true, is_ssl());
            do_action('wp_login', $username, get_user_by('ID', $user_id));

            // Rediriger vers le step 2 (avatar)
            $step2_page = get_page_by_path('signup-step2');
            if ($step2_page) {
                wp_redirect(get_permalink($step2_page->ID));
            } else {
                wp_redirect(home_url('/signup-step2'));
            }
            exit;
            exit;
        } else {
            wp_redirect(home_url('/signup?registration=error'));
            exit;
        }
    }
}
add_action('template_redirect', 'handle_user_registration');

// Handle user login
function handle_user_login()
{
    if (isset($_POST['login_submit']) && isset($_POST['login_nonce']) && wp_verify_nonce($_POST['login_nonce'], 'login_action')) {
        $username = sanitize_user($_POST['log']);
        $password = $_POST['pwd'];
        $remember = isset($_POST['rememberme']) ? true : false;

        if (empty($username) || empty($password)) {
            wp_redirect(home_url('/login?login=empty'));
            exit;
        }

        $creds = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => $remember
        );

        $user = wp_signon($creds, false);

        if (!is_wp_error($user)) {
            wp_redirect(home_url());
            exit;
        } else {
            wp_redirect(home_url('/login?login=failed'));
            exit;
        }
    }
}
add_action('template_redirect', 'handle_user_login');

// Redirect after login
function redirect_after_login($redirect_to, $request, $user)
{
    if (!is_wp_error($user)) {
        return home_url();
    }
    return $redirect_to;
}
add_filter('login_redirect', 'redirect_after_login', 10, 3);

// Helper function to get user custom field
function get_user_custom_field($user_id, $field_name)
{
    return get_user_meta($user_id, $field_name, true);
}

// Add custom fields to user profile in admin
function add_custom_user_profile_fields($user)
{
?>
    <h3>Additional Information</h3>
    <table class="form-table">
        <tr>
            <th><label for="phone">Phone Number</label></th>
            <td>
                <input type="tel" name="phone" id="phone" value="<?php echo esc_attr(get_user_meta($user->ID, 'phone', true)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="student_id">Student ID</label></th>
            <td>
                <input type="text" name="student_id" id="student_id" value="<?php echo esc_attr(get_user_meta($user->ID, 'student_id', true)); ?>" class="regular-text" />
            </td>
        </tr>
    </table>
<?php
}
add_action('show_user_profile', 'add_custom_user_profile_fields');
add_action('edit_user_profile', 'add_custom_user_profile_fields');

// Save custom fields in admin
function save_custom_user_profile_fields($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    if (isset($_POST['phone'])) {
        update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
    }
    if (isset($_POST['student_id'])) {
        update_user_meta($user_id, 'student_id', sanitize_text_field($_POST['student_id']));
    }
}
add_action('personal_options_update', 'save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'save_custom_user_profile_fields');

// Add custom columns to users list table
function add_custom_user_columns($columns)
{
    $columns['phone'] = 'Phone';
    $columns['student_id'] = 'Student ID';
    return $columns;
}
add_filter('manage_users_columns', 'add_custom_user_columns');

// Display custom column data in users list
function show_custom_user_column_data($value, $column_name, $user_id)
{
    if ($column_name == 'phone') {
        return get_user_meta($user_id, 'phone', true) ?: '—';
    }
    if ($column_name == 'student_id') {
        return get_user_meta($user_id, 'student_id', true) ?: '—';
    }
    return $value;
}
add_filter('manage_users_custom_column', 'show_custom_user_column_data', 10, 3);
