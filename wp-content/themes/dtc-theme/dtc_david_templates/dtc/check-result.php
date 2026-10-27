<div id="dtc-data">
	<div class="panel">
		<div class="col-md-12">
			<div class="row dtc-section">
			<br>
				<b>Your Record</b><br><br>
				<?php foreach ($data as $entry) {
					$dateStr = date('M d, Y', strtotime($entry->date_of_purchase));
					echo "<p>";
					echo "<b>Tyre:</b> $entry->tyre<br>";
					echo "<b>Quantity:</b> $entry->quantity<br>";
					echo "<b>Purchase Date:</b>$dateStr <br>";
					echo "<b>Store Name:</b> $entry->store_name<br>";
					echo "<b>Car Plate:</b> $entry->plate_no<br>";
					echo "<b>DTC Code:</b> $entry->dtc_card_no<br><br>";
					echo "</p>";
				}?>
			</div>
		</div> 
	</div>
</div>
