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
		<?php foreach($user_totals as $school): ?>
			<tr>
				<td><?php echo $school['User']['school'] ?></td>
				<td><?php echo $school['User']['school_count'] ?></td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
</div>