<div class="admin_header">
	<h3>
		<i class="icon-edit"></i> Jobs
		<div class="btn-group pull-right">
			<?php echo $this->Html->link('Add Job', array('action' => 'add'),array('class'=>'btn','escape'=>false)); ?>
			<?php echo $this->Html->link('Import', array('action' => 'import'),array('class'=>'btn','escape'=>false)); ?>
		</div>
	</h3>
</div>
<div class="">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>
					<?php echo $this->Paginator->sort('title','<i class="icon-sort"></i> Title',array('escape'=>false)); ?>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($jobs as $job): ?>
			<tr>
				<td><?php echo $this->Html->link($job['Job']['title'],array('action'=>'edit',$job['Job']['id'])) ?></td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	<?php echo $this->element('paging') ?>
</div>