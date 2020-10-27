<form method="post" id="atfr-creds-form" name="atfr-creds">
    <input type="hidden" id="atfr-creds-action" name="action" value="atfr_creds_response">
    <input type="hidden" id="atfr-creds-nonce" name="atfr_add_creds_nonce" value="<?php echo $atfr_add_creds_nonce ?>" />
    <label for="atfr-table"><?php echo __('ATKey',ATFR_DOMAIN)?></label>
    <input type="text" name="atfr-key" id="atfr-key" value="<?php echo !empty(get_option('atfr-api-key')) ? get_option('atfr-api-key') : '' ?>" >
    <input type="submit" id="atfr-settings-submit" name="atfr-creds-submit" class="atfr-button" value="Save">
</form>