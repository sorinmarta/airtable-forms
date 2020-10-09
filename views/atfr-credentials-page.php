<div class="atfr-container">
    <h1><?php esc_html_e('Airtable Credentials', ATFR_DOMAIN); ?></h1>
    <div class="atfr-error-box"></div>
    <?php
    if (current_user_can('manage_options')) {
        $atfr_add_creds_nonce = wp_create_nonce( 'atfr_add_creds_nonce' );;

        // Include the forms
        include_once(ATFR_PLUGIN . 'views/partials/atfr-credentials-form.php');
    }else {
        ?>
        <p> <?php __("You are not authorized to perform this operation.", ATFR_DOMAIN) ?> </p>
        <?php
    }
    ?>
</div>
