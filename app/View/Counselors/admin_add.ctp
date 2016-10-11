<div class="admin_header">
	<h3>
		<i class="icon-edit"></i> Counselor
		<div class="btn-group pull-right">
			<?php echo $this->Html->link('Add Counselor', array('action' => 'add'),array('class'=>'btn','escape'=>false)); ?>
			<?php echo $this->Html->link('<i class="icon-trash"></i> ', array('action' => 'delete', $this->data['Counselor']['id']), array('escape'=>false,'class'=>'btn'),'Are you sure you want to delete this Counselor'); ?>
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
		<?php foreach($items as $item): ?>
			<tr>
				<td></td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	<?php echo $this->element('paging') ?>
</div>