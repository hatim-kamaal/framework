<form id="Form1" method="post" action="" id="ctl01" role="form"
	class="form-horizontal minHt">

	<div class="container minHt">
		<div class="form-group">
			<div class="alert alert-success">
				<b>Register with us!</b>
			</div>
		</div>

		<?php if( strlen( $viewbean->message ) > 0) { ?>
		<div class="form-group">
			<div class="alert alert-warning">
				<?php echo $viewbean->message; ?>
			</div>
		</div>
		<?php } ?>

		<div class="form-group">
			<div class="alert alert-primary">
				Hello,<br>
				Provide your valid email address to recieve the registration code.
			</div>
		</div>
		<div class="form-group">
			<label for="Email" class="col-sm-3 control-label">E-mail ID</label>
			<div class="col-sm-5">
				<input name="Email" id="Email" type="text"
					value="<?php echo $viewbean->Email; ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label for="FName" class="col-sm-3 control-label">First Name</label>
			<div class="col-sm-5">
				<input name="FName" id="FName" type="text"
					value="<?php echo $viewbean->FName; ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label for="LName" class="col-sm-3 control-label">Last Name</label>
			<div class="col-sm-5">
				<input name="LName" id="LName" type="text"
					value="<?php echo $viewbean->LName; ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label for="Captcha" class="col-sm-3 control-label">Captcha
			</label>
			<div class="col-sm-5">
				<img class="img-responsive"  src="<?php echo $path->getUrl("captcha"); ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="Captcha" class="col-sm-3 control-label">
			Enter captcha code</label>
			<div class="col-sm-5">
				<input name="Captcha" id="Captcha" type="text"
					class="form-control" />
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-5" align="right">
				<button type="submit" name="ACTION_REFERENCE" value="Register"
					class="btn btn-primary">Proceed</button>
				&nbsp;&nbsp;&nbsp;&nbsp; <a href="register"></a>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
$(function() {
	// Setup form validation on the #register-form element
	$("#Form1").validate(
	{
		// Specify the validation rules
		rules : {
			FName : {
				required : true,
				minlength : 2,
			},
			LName : {
				required : true,
				minlength : 6,
				number : true,
			},
			Email : {
				required : true,
				email : true
			},
			Captcha : {
				required : true,
			}
		},
		submitHandler : function(form) {
			form.submit();
		}
	});
});


</script>
