<div class="col-lg-2">
	<?php 
		include 'widgets/cart.php'; 
		include 'widgets/recent.php';		

		$api_id = 'ae7610e4707b2a016592a1b8175ebe50'; // Vaš API ID
		$url = 'https://api.kursna-lista.info/'.$api_id.'/kursna_lista/json';
		$content = file_get_contents($url);

		if (empty($content))
		{
		    die('Greška u preuzimanju podataka');
		}

		$data = json_decode($content, true);

		// print_r($data);

		if ($data['status'] == 'ok')
		{
		    ?>	<div id="kursna-lista">
					<table class="table-condensed table">
						<h4>Kursna lista: <?=$data['result']['date'];?></h3>
						<thead>
							<th>Valuta</th>
							<th>Srednji kurs</th>
						</thead>
						<tbody>
							<tr>
								<td>EUR</td>
								<td><?=money($data['result']['eur']['sre']);?></td>
							</tr>
							<tr>
								<td>USD</td>
								<td><?=money($data['result']['usd']['sre']);?></td>
							</tr>
							<tr>
								<td>CHF</td>
								<td><?=money($data['result']['chf']['sre']);?></td>
							</tr>
							<tr>
								<td>GBP</td>
								<td><?=money($data['result']['gbp']['sre']);?></td>
							</tr>
							<tr>
								<td>RUB</td>
								<td><?=money($data['result']['rub']['sre']);?></td>
							</tr>
						</tbody>
					</table>
				</div>
		    <?php
		}
		else
		{
		    echo "Došlo je do greške: " . $data['code'] . " - " . $data['msg'];
		}
	?>
</div>