<?= $form->create('pupils',array('action' => 'listaction')); ?>
	<?php
		echo $this->element('action_box',
			array(
				'elements' => array('<input type="submit" name="data[export]" value="Exportieren"/>'),
				'add' => true
			)
		);
		
		
	?>
	<?php $col_widths = array(
					'30',
					'30',
					'120',
					'120',
					'30',
					'30',
					'30',
					'30',
					'40',
					'40',
					'40',
					'40',
					'80',
					'100',
					'120',
					'40',
					'50'
				);
		echo $this->element('table_header',
			array(
				'col_widths' => $col_widths,
				'headers' => array(
					'',
					'Nachname',
					'Vorname',
					'GS',
					'D',
					'M',
					'E',
					'G',
					'Auto',
					'Ü18',
					'K',
					'Klasse',
					'Kaution',
					'Zimmer',
					'Stat.',
					'Opt'
				)
			)
		)
	?>
	<div class="table-wrapper">
		<table id="ContentTable">
			<?= $this->element('table_cols',array('widths' => $col_widths)); ?>
			<tbody>
				<?php 
					$sem_start = $currentSemester[0]['start'];
					$date_factor = (60*60*24*7*26);
					$males = 0;$females = 0;
					foreach ($pupils as $pupil): ?>
				<tr id="pupil_<?= $pupil['Pupil']['id'] ?>">
					<?php 
						$start = $pupil[0]['start'];
					?>
					
					<td class="checkbox">
						<?= $this->element('pupil_table_checkbox',array('pupil' => $pupil)); ?>
					</td>
					<td class="pupil-image"
						style="background-image: url('/app/webroot/<?= $pupil['Pupil']['img_url'] ?>');">

					</td>
					<td>
						<?= $pupil['Pupil']['lastname']; ?>
					</td>
					<td>
						<?php echo $pupil['Pupil']['firstname']; ?>
					</td>
					<td>
						<?php if( $pupil['Pupil']['splitted_custody']){ ?>
							<span style="color: red; font-weight: bold;">GS</span>	
						<?php }?>
					</td>
					<td>
						<?php if( $pupil['Pupil']['permanent']){ ?>
							<div class="only-icon icon-clock" title="Dauerbeleger">Dauerbeleger</div>	
						<?php }?>
					</td>
					<td>
						<?php if( $pupil['Pupil']['rent_on_account']){ ?>
							<div class="only-icon icon-house" title="Miete">Miete auf Rechnung</div>	
						<?php }?>
					</td>
					<td>
						<?php if( $pupil['Pupil']['food_on_account'] == 1){ ?>
							<strong>HP</strong>
                        <?php } elseif ($pupil['Pupil']['food_on_account'] == 2) { ?>
                            <strong>VP</strong>
                        <?php }?>
					</td>
					<td>
						<?php if( $pupil['Pupil']['male']){ 
								$males++;
						?>
							<div class="only-icon icon-male">männlich</div>
						<?php }else{ 
								$females++ ?>
							<div class="only-icon icon-female">weiblich</div>	
						<?php }?>
					</td>
					<td class="car">
						<?php $isCarSet = isset($pupil['PupilCar']['id']); 
							echo $html->link((($isCarSet)?'PKW '.' '.$pupil['PupilCar']['name'].' '.$pupil['PupilCar']['color'].' '.$pupil['PupilCar']['sign']:''),
							'javascript:;',
							array(
								'class' => 'only-icon '.(($isCarSet)?'icon-car':'icon-car-add'),
								'title' => 'PKW bearbeiten',
								'onclick' => 'showTableDialog(this,"pupils_ajax","car",'.$pupil['Pupil']['id'].');')); ?>
						<?php /* echo $this->element('pupil_table_car',array('car' => @$pupil['PupilCar'], 'pupil' => @$pupil['Pupil']));  */?>
					</td>
					<td>
						<b><?php echo ($pupil[0]['is_adult'])?'Ü18':'MJ'; ?></b>
						&nbsp;<?php /* echo $time->format('d.m.Y',$pupil['Pupil']['birthdate']); */ ?>
					</td>
					<td class="comments">
						<?php echo $html->link('Kommentar anzeigen',
								'javascript:;',
								array(
									'class' => 'only-icon '.(empty($pupil['PupilComment'])?'icon-comment-add':'icon-comments'),
									'title' => 'Kommentare',
									'onclick' => 'showTableDialog(this,"pupils_ajax","comments",'.$pupil['Pupil']['id'].');')); ?>
						<?php /* echo $this->element('pupil_table_comment',array('comments' => @$pupil['PupilComment'], 'pupil' => @$pupil['Pupil'])); */ ?>
					</td>
					<td>
						<?php if(!empty($pupil['SchoolClassType']['id'])): ?>
						
						<?= $html->link($pupil['SchoolClassType']['abbreviation'],
							array('controller'=>'school_class_types', 'action'=>'edit', $pupil['SchoolClassType']['id'])); ?>
							<?= date("y",$start); ?>
							<? if($pupil['SchoolClassType']['duration'] * $date_factor < $sem_start - $start): ?>
								<div style="display: none;">abgänger</div>
							<? endif; ?>
						<?php endif; ?>
						<?= $pupil['Pupil']['subclass']; ?>
							
					</td>
					<td class="deposit">
						<?php
							$deposit = $pupil['Deposit']; 
							if(isset($deposit['id'])){ ?>
							<div title="eingezahlt am <?= $myHtml->date($deposit['paid_in']); ?>">
								<?php if(isset($deposit['paid_out']) && $deposit['paid_out'] != '0000-00-00' && $deposit['paid_out'] != '0001-01-01'){?>
								<div class="only-icon icon-tick" title="ausgezahlt am <?= $myHtml->date($deposit['paid_out']);?>">ausgezahlt</div>
								<?php }else{ ?>
									<?= $html->link('Kaution auszahlen', 
									'javascript:;',
									array(
										'class' => 'only-icon icon-money-delete',
										'title' => 'Kaution auszahlen',
										'onclick' => 'showTableDialog(this,"pupils_ajax","deposit",'.$pupil['Pupil']['id'].');'
									)); ?>
								<?php }?>
								<?= $deposit['block'].'/'.$deposit['nr']; ?>	
							</div>	
						<?php }else{ ?>
							<?= $html->link('einzahlen',
										'javascript:;',
										array(
											'class' => 'only-icon icon-money-add',
											'title' => 'Kaution einzahlen',
											'onclick' => 'showTableDialog(this,"pupils_ajax","deposit",'.$pupil['Pupil']['id'].');')); ?>	
						<?php } ?>
						<?php /* echo $this->element('pupil_table_deposit',array('deposit' => @$pupil['Deposit'], 'pupil' => @$pupil['Pupil'])); */ ?>
					</td>
					<td class="room">
						<?php 
							echo $html->link('Zimmer geben', 
							'javascript:;',
							array(
								'class' => 'only-icon icon-door',
								'title' => 'Zimmer geben',
								'onclick' => 'showTableDialog(this,"pupils_ajax","room",'.$pupil['Pupil']['id'].');'));
						?>
						<?php if(isset($pupil['Pupil']['room']) && $pupil['Pupil']['room'] != ''){ ?>
						<?php echo 'R:'.$pupil['Pupil']['room']; ?>
						<?php } ?>
						<?php /* echo $this->element('pupil_table_room',array('pupil' => @$pupil['Pupil'])); */ ?>
					</td>
					<td class="checkout">
						
						<?php if($pupil['Pupil']['checked_out'] == '' || $pupil['Pupil']['checked_out'] == '0000-00-00'){ ?>
							<?= $html->link('Abmelden', 
							'javascript:;',
							array(
								'class' => 'only-icon icon-check-out',
								'title' => 'Abmelden',
								'onclick' => 'showTableDialog(this,"pupils_ajax","checkout",'.$pupil['Pupil']['id'].');'));
						?>
						<?php }else if($pupil['Pupil']['banished']){ ?>
							<div class="only-icon icon-status-busy" title="Ausgewiesen am <?= $myHtml->date($pupil['Pupil']['checked_out']); ?>">Ausgewiesen </div>
						<?php }else{ ?>
							<div class="only-icon icon-status-offline" title="Abgemeldet am <?= $myHtml->date($pupil['Pupil']['checked_out']); ?>">Abgemeldet </div>
						<?php }?>
						<?php /* echo $this->element('pupil_table_check_out',array('pupil' => @$pupil['Pupil'])); */ ?>
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
	<?= $this->element('table_footer', array('number' => count($pupils), 'label' => 'Sch&uuml;ler - insgesamt: '.$males.' M&auml;nner / '.$females.' Frauen')) ?>
<?= $form->end(); ?>
<div id="dialog" style="dispaly: none;"></div>