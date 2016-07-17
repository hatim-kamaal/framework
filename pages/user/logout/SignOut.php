<?php
class SignOut extends AbstractAction {
	public function view() {
		$this->clearSession ();
		$this->redirect ( $this->fm->getUrl ( "signin" ) );
	}
	public function isRestricted() {
		return false;
	}
	public function page() {
		global $vb, $fm, $db;
		?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Login Area</h3>
	</div>
	<div class="panel-body">
		<div class="form-group">
			<div class="alert alert-warning">Signed out!!</div>
		</div>
	</div>
</div>

<?php
	}
}
?>