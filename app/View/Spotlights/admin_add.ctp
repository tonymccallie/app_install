<div class="admin_header">
	<h3>
		<i class="icon-edit"></i> Add Spotlight
	</h3>
</div>
<div class="">
	<?php
		echo $this->Form->create();
			echo $this->Form->input('title',array('class'=>'span12'));
			echo $this->Form->input('descr',array('class'=>'span12'));
			echo $this->Form->input('video',array('class'=>'span12'));
			echo $this->Form->input('poster',array('class'=>'span12'));
			echo $this->Form->input('start',array());
		echo $this->Form->end(array('label'=>'Create Spotlight','class'=>'btn'));
	?>
</div>