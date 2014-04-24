<div id="error">
	<h4><?php echo $this->languages->get(Strings::ERRORS_TITLE); ?></h4>
	<ul>
		<?php foreach ($this->errors as $error) { ?>
			<li><?php echo $error ?>
		<?php } ?>
	</ul>
</div>