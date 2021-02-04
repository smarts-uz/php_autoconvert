<!DOCTYPE html>
<html>
<head>
	<title>Processing...</title>
	<link rel="stylesheet" href="loading.css" type="text/css" />
</head>
<body>
<?php
	echo <<<HTML
		<script> window.top.location.href = "google.com";</script>
	HTML;
	?>
	<div class="circle"></div>
</div>
</body>
</html>

<!-- 


	case $this->paramGet(paramIframe):


		echo <<<HTML
		<script> window.top.location.href = "{$url}";</script>
		HTML;

		return true;
		break;

		case $this->paramGet('redirect'):
			echo <<<HTML
	<script> window.opener.location.href="{$url}";
				self.close();</script>
	HTML;
 -->

