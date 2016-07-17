<?php
class Signin extends AbstractAction {
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see AbstractRequestController::view()
	 */
	public function view() {
	}
	
	/**
	 */
	public function doLogin() {
		$options = new ModelBean ();
		$options->APP_UID = $this->vb->User;
		$options->APP_PWD = $this->vb->Passcode;
		
		$result = $this->db->read ( "SELECT_APP_LOGIN", $options );
		if (isset ( $result )) {
			
			$row = mysqli_fetch_row ( $result );
			
			$userDetails = new ModelBean ();
			$userDetails->UserName = $row ["fname"] . " " . $row ["lname"];
			$userDetails->UserId = $row ["uname"];
			$this->ssnmgr->USER_DETAILS = $userDetails;
			$this->ssnmgr->lastRequest = time ();
			
			$this->redirect ( $this->fm->getUrl ( "home" ) );
		} else {
			$this->vb->message = "Invalid Username or Password";
		}
	}
	public function isRestricted() {
		return false;
	}
	public function page() {
		global $vb, $fm, $db;
		?>

<form id="Form1" method="post" action="" id="ctl01" role="form"
	class="form-horizontal minHt">


	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Login Area</h3>
		</div>
		<div class="panel-body">

		<?php if( strlen( $vb->message ) > 0) { ?>
			<div class="form-group">
				<div class="alert alert-warning">
				<?php echo $vb->message; ?>
				</div>
			</div>
		<?php } ?>
		
		
			<div class="form-group">
				<div class="col-sm-12">
					<input name="User" id="User1" type="text"
						value="<?php echo $vb->User; ?>" placeholder="Username"
						class="form-control input-lg" />
				</div>

			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<input name="Passcode" id="Passcode" type="password"
						placeholder="Password" value="<?php echo $vb->Passcode; ?>"
						class="form-control input-lg" />
				</div>

			</div>
			<div class="form-group">
				<div class="col-sm-12" align="right">
					<button type="submit" name="ACTION_REFERENCE" value="Login"
						class="btn btn-primary form-control input-lg">Login</button>
				</div>
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
			User : {
				required : true,
				minlength : 2,
			},
			Passcode : {
				required : true,
				minlength : 2,
			}
		},
		submitHandler : function(form) {
			form.submit();
		}
	});
});


</script>
<?php
	}
}
