<?php if ($messages = App\Flash::getMessage()): ?>
	<?php foreach ($messages as $message): ?>
		<div>
			<?= $message ?>
		<div>
	<?php endforeach ?>
<?php endif ?>
