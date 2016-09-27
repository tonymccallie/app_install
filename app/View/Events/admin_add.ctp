<div class="admin_header">
	<h3>
		<i class="icon-edit"></i> Add Event
	</h3>
</div>
<div class="">
	<?php
		echo $this->Form->create();
			echo $this->Form->input('event_date',array());
			echo $this->Form->input('title',array('class'=>'span12'));
			echo $this->Form->input('description',array('class'=>'span12'));
		echo $this->Form->end(array('label'=>'Add Event','class'=>'btn'));
	?>
</div>