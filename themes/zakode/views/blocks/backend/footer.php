<div class="footer">
	<div class="container">
		<?php if (ENVIRONMENT=='development'): ?>
			<p class="pull-right text-muted">
				ZaKode modules - Version: <strong><?php echo ZaKode_VERSION; ?></strong>, 
				CI Version: <strong><?php echo CI_VERSION; ?></strong>, 
				Elapsed Time: <strong>{elapsed_time}</strong> seconds, 
				Memory Usage: <strong>{memory_usage}</strong>
			</p>
		<?php endif; ?>
		<p class="text-muted">&copy; <strong><?php echo date('Y'); ?></strong> All rights reserved.</p>
	</div>
</div>
	<?php
		foreach ($scripts['foot'] as $file)
		{
			$url = starts_with($file, 'http') ? $file : base_url($file);
			echo "<script src='$url'></script>".PHP_EOL;
		}
	?>

	<?php // Google Analytics ?>
        <?php echo $template['partials']['be_ga']; ?>
</body>
</html>

