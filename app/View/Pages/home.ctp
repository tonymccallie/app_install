<div class="span12">
	<h1>App Totals</h1>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>
					School
				</th>
				<th>
					Users
				</th>
			</tr>
		</thead>
		<tbody>
		<?php $total = 0; ?>
		<?php 
			foreach($user_totals as $school): 
				$total+=$school['User']['school_count'];
		?>
			<tr>
				<td><?php echo $school['User']['school'] ?></td>
				<td><?php echo $school['User']['school_count'] ?></td>
			</tr>
		<?php endforeach ?>
		<tr>
			<td>TOTAL:</td>
			<td><?php echo $total ?></td>
		</tr>
		</tbody>
	</table>
</div>