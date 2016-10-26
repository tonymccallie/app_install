<img src="http://goamarillo.org/img/my_plan.png" style="width: 450px;" />
<p>
<b>NAME:</b> <?php echo $data['User']['first_name'] ?> <?php echo $data['User']['last_name'] ?><br />
<b>SCHOOL:</b> <?php echo $data['User']['school'] ?><br />
<br />
<b>MY PATH:</b>  <?php echo $json['path'] ?><br />
<b>SCHOOL:</b> <?php echo ($json['school']!='OTHER')?$json['school']:$json['school_other'] ?><br />
<?php if(!empty($json['program'])): ?>
<b>PROGRAM/DEGREE:</b> <?php echo ($json['program']!='OTHER')?$json['program']:$json['program_other'] ?><br />
<?php endif ?>
<br />
<b>CHECK LIST COMPLETE SO FAR:</b><br /><br />
<?php foreach($steps as $k => $step): ?>
<?php echo (!empty($json['checklist'][$k]))?'[X]':'[&nbsp;&nbsp;&nbsp;]' ?> <?php echo $step ?><br />
<?php endforeach ?>
</p>