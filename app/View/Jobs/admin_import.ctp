<div class="admin_header">
	<h3>
		<i class="icon-edit"></i> Import Jobs
	</h3>
</div>
<div class="">
	<?php
		echo $this->Form->create();
		echo $this->Form->input('data',array('type'=>'textarea','class'=>'span12'));
		echo $this->Form->end(array('label'=>'Import','class'=>'btn'));
	?>
</div>