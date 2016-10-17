<div class="admin_header">
	<h3>
		<i class="icon-edit"></i> Edit Spotlight
		<div class="btn-group pull-right">
			<?php echo $this->Html->link('<i class="icon-trash"></i> ', array('action' => 'delete', $this->data['Spotlight']['id']), array('escape'=>false,'class'=>'btn'),'Are you sure you want to delete this Spotlight?'); ?>
		</div>
	</h3>
</div>
<div class="">
	<?php
		echo $this->Form->create();
			echo $this->Form->input('id',array('class'=>'span12'));
			echo $this->Form->input('title',array('class'=>'span12'));
			echo $this->Form->input('descr',array('class'=>'span12'));
			echo $this->Form->input('video',array('class'=>'span12'));
			echo $this->Form->input('poster',array('class'=>'span12'));
			echo $this->Form->input('start',array());
		echo $this->Form->end(array('label'=>'Save Spotlight','class'=>'btn'));
	?>
</div>