<div class="info-box gb">
	<h2 class="success">Du hast dich erfolgreich angemeldet</h2>
	<p>
		Du musst nun noch deinen Anmeldebogen ausdrucken. Dieser ist unterschrieben und mit <b>zwei</b> Passbildern versehen beim Internat abgegeben.<br/>
	</p>
		<ul class="final-steps">
			<li><?= $html->link('Anmeldebogen jetzt ausdrucken',
							array('controller'=>'print', 'action'=>'bypw', $pw), array('target' => '_blank')); ?></li>
		</ul>
	<p>
		Wenn du ihn später ausdrucken willst, notiere dir folgendes Passwort: <b><?= $pw ?></b>
	</p>
	<p>
		<b>Hinweis:</b> Wenn eine Unterbringung <b>nicht</b> möglich ist, informieren wir dich.
	</p>
		
</div>