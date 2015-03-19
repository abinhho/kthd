<?php if(isset($submit_email)) echo validation_errors('<div class="error_messenger">',"</div>"); ?>
<?php if(!empty($error_messenger)) echo "<div class='error_messenger'>".$error_messenger."</div>"; ?>

<div class="info_block"><h6>Đăng ký email</h6><p>Đăng ký nhận các thông tin từ chúng tôi.</p></div>
<?php echo form_open('emails/do_email', "target = 'temp_frame'")?>
<?php echo form_input('email','', "class='email'")?>
<?php echo form_submit('submit_email', 'Send', "class='btn_submit'")?>
<?php echo form_close();?>

<?php if(!empty($error_messenger) ) {
?>
<script type="text/javascript">
parent.alert_messenger("<?php echo $error_messenger; ?>");
</script>
<?php } ?>


<?php if(validation_errors() != "" ) { 
?>
<script type="text/javascript">
parent.alert_messenger('<?php echo str_replace("\n",'',validation_errors('-','.')) ;?>');
</script>
<?php } ?>