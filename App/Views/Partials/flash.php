<?php if ($messages = App\Flash::getMessage()): ?>
	<?php foreach ($messages as $message): ?>
	<div class="alert alert-<?= $message['type'] ?>">
			<?= $message['message'] ?>
	</div>
	<?php endforeach ?>
<?php endif ?>
