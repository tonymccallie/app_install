<div class="admin_header">
	<h3>
		<i class="icon-edit"></i> Spotlights
		<div class="btn-group pull-right">
			<?php echo $this->Html->link('Add Spotlight', array('action' => 'add'),array('class'=>'btn','escape'=>false)); ?>
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
		<?php foreach($spotlights as $spotlight): ?>
			<tr>
				<td><?php echo $this->Html->link($spotlight['Spotlight']['title'], array('action'=>'edit',$spotlight['Spotlight']['id'])) ?></td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	<?php echo $this->element('paging') ?>
</div>