<div class="admin_header">
	<h3>
		<i class="icon-edit"></i> Articles
		<div class="btn-group pull-right">
			<?php echo $this->Html->link('Add Article', array('action' => 'add'),array('class'=>'btn','escape'=>false)); ?>
		</div>
	</h3>
</div>
<div class="">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Image</th>
				<th>
					<?php echo $this->Paginator->sort('title','<i class="icon-sort"></i> Title',array('escape'=>false)); ?>
				</th>
				<th>
					<?php echo $this->Paginator->sort('start','<i class="icon-sort"></i> Start',array('escape'=>false)); ?>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($articles as $article): ?>
			<tr>
				<td><?php echo !empty($article['Article']['image'])?$this->Html->image('thumb/'.$article['Article']['image'].'/width:200/height:200/crop:true/zoom:auto',array('style'=>'width: 200px;')):''; ?></td>
				<td><?php echo $this->Html->link($article['Article']['title'],array('action'=>'edit',$article['Article']['id'])) ?></td>
				<td><?php echo date('m/d/y h:i a',strtotime($article['Article']['start'])) ?></td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	<?php echo $this->element('paging') ?>
</div>