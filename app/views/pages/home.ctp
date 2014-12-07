

<?php
if (Configure::read() > 0):
	Debugger::checkSessionKey();
endif;
?>
<div class="form-col" style="width: 590px;">
	<h2>Neue Schüler</h2>
	<table>
		<tbody>
		<?php foreach($newPupils as $pupil): ?>
		<?php 
						$start = $pupil[0]['start'];
					?>

			<tr>
				<td><?= $pupil['Pupil']['lastname'] ?></td>
				<td><?= $pupil['Pupil']['firstname'] ?></td>
				<td>
					<b><?php echo ($pupil[0]['is_adult'])?'Ü18':'MJ'; ?></b>
				</td>

				<td><?= $time->format('d.m.y H:i',$pupil['Pupil']['created'] ); ?> Uhr</td>
				<td>
						<?php if(!empty($pupil['SchoolClassType']['id'])): ?>
						
							<?= $pupil['SchoolClassType']['abbreviation'] ?>
							<?= $start ?>
						<?php endif; ?>
						<?= $pupil['Pupil']['subclass']; ?>
							
					</td>

				<td>
						<?= $html->link('', 
									array(
										'controller'=>'pupils', 'action'=>'edit', $pupil['Pupil']['id']),
									array(
										'class' => 'only-icon icon-pencil',
										'title' => 'bearbeiten')); ?>
					</td>

			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
<div class="form-col" style="width: 310px;">
	<h2>Letzte Kommentare</h2>
	<table>
		<tbody>
		<?php foreach($comments as $comment): ?>
			<tr>
				<td>
					<div class="comment-text">
						<?= $html->link($comment['Pupil']['firstname'] .' '. $comment['Pupil']['lastname'],array('controller' => 'pupils', 'action' => 'edit', $comment['Pupil']['id'])); ?>
						<br/>
						<?= $comment['PupilComment']['text'] ?>
					</div>
					<div class="comment-details">
						<?= $time->format('d.m.Y H:i',$comment['PupilComment']['created']); ?>
						von 
						<?= $comment['User']['username'] ?>
					</div>
					
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
	</table>
</div>
<div class="clearfix"></div>
