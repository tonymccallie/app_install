<div class="admin_header">
	<h3>
		<i class="icon-edit"></i> Counselor
		<div class="btn-group pull-right">
			<?php echo $this->Html->link('Add Counselor', array('action' => 'add'),array('class'=>'btn','escape'=>false)); ?>
			<?php echo $this->Html->link('Import', array('action' => 'import'),array('class'=>'btn','escape'=>false)); ?>
		</div>
	</h3>
</div>
<div class="">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>
					<?php echo $this->Paginator->sort('last_name','<i class="icon-sort"></i> Name',array('escape'=>false)); ?>
				</th>
				<th>
					<?php echo $this->Paginator->sort('school_id','<i class="icon-sort"></i> School',array('escape'=>false)); ?>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($counselors as $counselor): ?>
			<tr>
				<td><?php echo $this->Html->link($counselor['Counselor']['first_name']." ".$counselor['Counselor']['last_name'], array('action'=>'edit',$counselor['Counselor']['id'])) ?></td>
				<td><?php echo $counselor['School']['title'] ?></td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	<?php echo $this->element('paging') ?>
</div>