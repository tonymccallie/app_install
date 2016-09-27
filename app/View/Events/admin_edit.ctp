<div class="admin_header">
	<h3>
		<i class="icon-edit"></i> Edit Event
	</h3>
</div>
<div class="">
	<?php
		echo $this->Form->create();
			echo $this->Form->input('id');
			echo $this->Form->input('event_date',array());
			echo $this->Form->input('title',array('class'=>'span12'));
			echo $this->Form->input('description',array('class'=>'span12'));
		echo $this->Form->end(array('label'=>'Save Event','class'=>'btn'));
	?>
</div>