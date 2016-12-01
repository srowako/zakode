<?php
if(!isset($message) or !is_array($message)) $message =[];
else{
    
if(!isset($message['nonAjax']))
	$message['nonAjax'] = 0;
switch (strtolower($this->session->flashdata('messageTitle')[0])) {
    
	case 'w':
	$alert = 'alert alert-warning alert-dismissible';
	break;
    
	case 's':
	$alert = 'alert alert-success alert-dismissible';
	break;
    
        case 'd':
	$alert = 'alert alert-danger alert-dismissible';
	break;
    
        default:
	$alert = 'alert alert-info alert-dismissible';
	break;	
}
?>

<div class="<?php echo $alert ?>">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-info"></i> <?php echo $this->session->flashdata('messageTitle'); ?></h4>
    <?php echo $this->session->flashdata('messageBody') ?>
</div>

<?php if($message['nonAjax']): ?>

<div class="<?php echo $message['messageClass']; ?>">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-info"></i> <?php echo $this->session->flashdata('messageTitle'); ?></h4>
    <?php echo $this->session->flashdata('messageBody') ?>
</div>

<?php endif; 
}
?>

