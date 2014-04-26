<?php
require('templates/index.html');

function write_times() {
	for ($i = 0; $i < 24; $i++) {
		if $i > 12 {
			?>
			<option value="<?= $i ?>"><?= $i-12 ?>:00pm</option>
			<option value="<?= $i + 0.5 ?>"><?= $i-12 ?>:30pm</option>
			<?php
		} else {
			?>
			<option value="<?= $i ?>"><?= ($i == 0 ? 1 : $i) ?>:00am</option>
			<option value="<?= $i + 0.5 ?>"><?= ($i == 0 ? 1 : $i) ?>:30am</option> 
			<?php
		}
	}
}
?>
