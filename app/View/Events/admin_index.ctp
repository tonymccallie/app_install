<div class="admin_header">
	<h3>
		<i class="icon-edit"></i> Events
		<div class="btn-group pull-right">
			<?php echo $this->Html->link('Add Event', array('action' => 'add'),array('class'=>'btn','escape'=>false)); ?>
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
				<th>
					<?php echo $this->Paginator->sort('event_date','<i class="icon-sort"></i> Date',array('escape'=>false)); ?>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($events as $event): ?>
			<tr>
				<td><?php echo $this->Html->link($event['Event']['title'],array('action'=>'edit',$event['Event']['id'])) ?></td>
				<td><?php echo date('m/d/y',strtotime($event['Event']['event_date'])) ?></td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	<?php echo $this->element('paging') ?>
</div>