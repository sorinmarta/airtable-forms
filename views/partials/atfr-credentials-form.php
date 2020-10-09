<form method="post" id="atfr-creds-form" name="atfr-creds">
    <input type="hidden" id="atfr-creds-action" name="action" value="atfr_creds_response">
    <input type="hidden" id="atfr-creds-nonce" name="atfr_add_creds_nonce" value="<?php echo $atfr_add_creds_nonce ?>" />
    <label for="atfr-key"><?php echo __('API Key', ATFR_DOMAIN) ?></label>
    <input type="text" name="atfr-key" id="atfr-key" value="<?php echo !empty(get_option('atfr-api-key')) ? get_option('atfr-api-key') : '' ?>" >
    <label for="atfr-base-id"><?php echo __('Base ID',ATFR_DOMAIN)?></label>
    <input type="text" name="atfr-base-id" id="atfr-base-id" value="<?php echo !empty(get_option('atfr-base')) ? get_option('atfr-base') : '' ?>" >
    <label for="atfr-table"><?php echo __('Table',ATFR_DOMAIN)?></label>
    <input type="text" name="atfr-table" id="atfr-table" value="<?php echo !empty(get_option('atfr-table')) ? get_option('atfr-table') : '' ?>" >
    <input type="submit" id="atfr-settings-submit" name="atfr-creds-submit" class="atfr-button" value="Save">
</form>