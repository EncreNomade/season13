<form id="payzenBuyForm" name="payzenBuyForm" action="https://secure.payzen.eu/vads-payment/" METHOD="POST">

    <?php echo Form::hidden('vads_site_id', $vads_site_id); ?>
    
    <?php echo Form::hidden('vads_ctx_mode', $vads_ctx_mode); ?>
    
    <?php echo Form::hidden('vads_version', $vads_version); ?>
    
    <?php echo Form::hidden('vads_language', $vads_language); ?>
    
    <?php echo Form::hidden('vads_page_action', $vads_page_action); ?>
    
    <?php echo Form::hidden('vads_action_mode', $vads_action_mode); ?>
    
    <?php echo Form::hidden('vads_payment_config', $vads_payment_config); ?>
    
    <?php echo Form::hidden('vads_return_mode', $vads_return_mode); ?>
    
    <?php echo Form::hidden('vads_url_return', $vads_url_return); ?>
    
    <?php echo Form::hidden('vads_redirect_success_timeout', $vads_redirect_success_timeout); ?>
    
    <?php echo Form::hidden('vads_return_mode', $vads_return_mode); ?>
    
    <?php echo Form::hidden('vads_redirect_success_message', $vads_redirect_success_message); ?>
    
    <?php echo Form::hidden('vads_redirect_error_timeout', $vads_redirect_error_timeout); ?>
    
    <?php echo Form::hidden('vads_redirect_error_message', $vads_redirect_error_message); ?>
    
    
    
    <?php echo Form::hidden('vads_amount', $vads_amount); ?>
    
    <?php echo Form::hidden('vads_currency', $vads_currency); ?>
    
    <?php echo Form::hidden('vads_order_id', $vads_order_id); ?>
    
    <?php echo Form::hidden('vads_cust_name', $vads_cust_name); ?>
    
    <?php echo Form::hidden('vads_cust_country', $vads_cust_country); ?>
    
    
    
    <?php echo Form::hidden('vads_trans_id', $vads_trans_id); ?>
    
    <?php echo Form::hidden('vads_trans_date', $vads_trans_date); ?>
    
    <?php echo Form::hidden('signature', $signature, array('id' => 'payzen_signature')); ?>
    
    <?php echo Form::submit('payzen_submit', ' ', array('id' => 'payzen_submit')); ?>
    
</form>