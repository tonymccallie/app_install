<div class="admin_header">
	<h3>
		<i class="icon-edit"></i> Save Article
	</h3>
</div>
<div class="">
	<?php
		echo $this->Form->create('Article',array('type'=>'file'));
	?>
	<div class="row-fluid">
		<div class="span6">
			<?php
				echo $this->Form->input('id');
				echo $this->Form->input('title',array('class'=>'span12'));
				echo $this->Form->input('start');
				echo $this->Form->input('body',array('class'=>'span12'));
			?>
		</div>
		<div class="span6">
			<?php
				echo !empty($this->data['Article']['image'])?'<label>Current Image</label><br />'.$this->Html->image('thumb/'.$this->data['Article']['image'].'/width:200/height:200/crop:true/zoom:auto',array('style'=>'width: 200px;')):'';
				echo $this->Form->input('imagefile',array('label' => 'New Image',
					'type'=>'file',
				));
			?>
		</div>
	</div>	
	<?php
		echo $this->Form->end(array('label'=>'Save Article','class'=>'btn'));
	?>
</div>