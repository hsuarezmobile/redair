<?php
	$x = 0;
	$json_data = array ();
	$json_data = json_decode($dataServ->getWebsiteStats());
?>
<div class="panel-body">
	<div class="row">
		<div class="col-lg-4">
			<br>
			<br><b>Resumen del Website</b><br>
			<br>
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th>Renglón</th>
							<th>Totales</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Usuarios del cms</td>
							<td><?php echo $json_data->data->usuarioscms; ?></td>
						</tr>
						<tr>
							<td>Perfiles del cms</td>
							<td><?php echo $json_data->data->perfilescms; ?></td>
						</tr>
						<tr>
							<td>Noticias</td>
							<td><?php echo $json_data->data->cantidadnoticias; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- /.row -->
</div>
<!-- /.panel-body -->
</div>


