<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Passbook</title>
<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
		<link href="<?php echo $fm->getScript("bootstrap_min_css"); ?>"
			rel="stylesheet" />

		<link rel="stylesheet"
			href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="<?php echo $fm->getScript("jquery_ui_js"); ?>"></script>
		<script src="<?php echo $fm->getScript("bootstrap_min_js"); ?>"></script>
		<script src="<?php echo $fm->getScript("jquery_validation_js"); ?>"></script>
		<script
			src="<?php echo $fm->getScript("common_min_js") . "?verson=1"; ?>"></script>

</head>
<body>
	<div class="row">
		<div class="col-sm-12">
			<div class="navbar navbar-default" role="navigation">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse"
						data-target=".navbar-collapse">
						<span class="sr-only">Navigation</span> <span class="icon-bar"></span>
						<span class="icon-bar"></span> <span class="icon-bar"></span>
					</button>
					<div class="navbar-brand">
						<a href='<?php echo $fm->getUrl("home");?>'>Passbook</a>
					</div>
				</div>

				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<?php if($this->vb->isUserLoggedIn) { ?>
						<li><a href='<?php echo $fm->getUrl("appdata");?>'>AppSecret</a></li>
						<?php } ?>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<?php if($this->vb->isUserLoggedIn) { ?>
						<li><a href='<?php echo $fm->getUrl("signout");?>'>Sign out</a></li>
						<?php } else { ?>
						<li><a href='<?php echo $fm->getUrl("signin"); ?>'>Login</a></li>
						<li><a href='<?php echo $fm->getUrl("register"); ?>'>Register</a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="container" style="min-height: 300px;">
		<?php
		$this->page();
		?>
	</div>
	<hr />
	<footer>Hatim Kamaal</footer>
</body>
</html>