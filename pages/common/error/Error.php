<?php
class Error extends AbstractAction {
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see AbstractRequestController::view()
	 */
	public function view() {
	}
	public function isRestricted() {
		return false;
	}
	public function page() {
		global $vb, $fm, $db;
		?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Error</h3>
	</div>
	<div class="panel-body">

		<?php if( strlen( $vb->message ) > 0) { ?>
			<div class="form-group">
			<div class="alert alert-warning">
				<?php echo $vb->message; ?>
				</div>
		</div>
		<?php } ?>
		</div>
</div>

<?php
	}
}
?>