<!DOCTYPE html>
<html>
<head>
	<title>agenda</title>
	<meta charset="utf-8">

	<style type="text/css">
		body{
			background-color: #555;
			color: white;
			font-size: 1.2em;
			font-weight: bold;
		}
		fieldset{
			text-align: center;
			width: 60%;
			margin: 0 auto;
			border-radius: 10px;
			border: 3px black solid;
			}
			input[type="submit"]{
				border-radius:10px;
				background-color: rgb(0,150,255);
				color: white;
				cursor: pointer;
				padding: 10px;
			}
		#tabla{
			border: 1px solid white;
			font-size: 0.8em;
			font-weight: bold;
			margin: 0 auto;
			margin-top: 10px;
		}
		#tabla td{
			border: 1px solid white;
			text-align: center;
		}
		#tabla .en{
			background-color: #ddd;
			color: black;
		}

		#dir{

		}
	</style>






</head>
<body>
	<fieldset>
		<legend>Insertar Usuario</legend>
		<form action="" method="post">
			Primer Nombre:<br><input type="text" name="primer_nombretxt"><br><br>
			Segundo Nombre:<br><input type="text" name="segundo_nombretxt"><br><br>
			Primer Apellido:<br><input type="text" name="primer_apellidotxt"><br><br>
			Segundo Apellido:<br><input type="text" name="segundo_apellidotxt"><br><br>
			Direccion:<br><input type="text" name="direcciontxt" id="dir"><br><br>
			Telefono:<br><input type="text" name="telefonotxt"><br><br>
			Email:<br><input type="text" name="emailtxt"><br><br>	
			<input type="submit" value="guardar" name="enviar">	
		</form>
	</fieldset>




	<?php 
	class archivo{
		public $nombre;
		public $archivo;
			function __construct($n){
			$this->nombre=$n;
		}
		function insertar($primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$direccion,$telefono,$email){		
			if (file_exists($this->nombre)) {
				$this->archivo = fopen($this->nombre,"a");
				fwrite($this->archivo,PHP_EOL);
				fwrite($this->archivo,"$primer_nombre/$segundo_nombre/$primer_apellido/$segundo_apellido/$direccion/$telefono/$email/");
				fclose($this->archivo);
			}else{
				$this->archivo = fopen($this->nombre, "w");
				fwrite($this->archivo,"$primer_nombre/$segundo_nombre/$primer_apellido/$segundo_apellido/$direccion/$telefono/$email/");
				fclose($this->archivo);
			}
			echo "Contacto Insertado";
		}

		function eliminar($correoE){
			$this->archivo = fopen($this->nombre, "r");
			$contactos=array();
			while (!feof($this->archivo)) {
				$linea=fgets($this->archivo);
				$contactos[]=$linea;
			}
			fclose($this->archivo);
			$this->archivo = fopen($this->nombre, "w");
			foreach ($contactos as $con) {
				$arreglo=explode("/", $con);
				if (count($arreglo)>=7){
					if ($correoE!=$arreglo[6]) {
					fwrite($this->archivo, $con);
					}else{
						echo "Contacto Eliminado";
					}

				} 	
			}
			fclose($this->archivo);
		}

		function consultar(){
			if (file_exists($this->nombre)) {
				$this->archivo =  fopen($this->nombre, "r");
				?>


				 <table id="tabla">
					<tr>
						<td class="en">Primer Nombre</td>
						<td class="en">Segungo Nombre</td>
						<td class="en">Primer Apellido</td>
						<td class="en">Segundo Apellido</td>
						<td class="en">Direccion</td>
						<td class="en">Telefono</td>
						<td class="en">Email</td>
						<td class="en">Eliminar</td>		
					</tr>
				<?php
				while (!feof($this->archivo)) {
					$linea=fgets($this->archivo);
					$arreglo=explode("/", $linea);
					if (count($arreglo)>=7) {
						echo "<tr>";
						echo "<td>$arreglo[0]</td>";
						echo "<td>$arreglo[1]</td>";
						echo "<td>$arreglo[2]</td>";
						echo "<td>$arreglo[3]</td>";
						echo "<td>$arreglo[4]</td>";
						echo "<td>$arreglo[5]</td>";
						echo "<td>$arreglo[6]</td>";
						echo "<td><form action='' method='post'>
						<input type='hidden' value='$arreglo[6]'name='correoE'>
						<input type='submit' value='eliminar'></form></td>";
						echo "</tr>";
					}
				}
				echo "</table>";
				fclose($this->archivo);
			}else{
				echo "Agenda Vacia";
			}
		}

	}
	$obj = new archivo(agenda);
	if (isset($_POST["enviar"])) {
		$primer_nombre= $_POST["primer_nombretxt"];
		$segundo_nombre= $_POST["segundo_nombretxt"];
		$primer_apellido= $_POST["primer_apellidotxt"];
		$segundo_apellido= $_POST["segundo_apellidotxt"];
		$direccion= $_POST["direcciontxt"];
		$telefono= $_POST["telefonotxt"];
		$email= $_POST["emailtxt"];
		$obj->insertar($primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$direccion,$telefono,$email);
	}
	if (isset($_POST["correoE"])) {
		$obj-> eliminar($_POST["correoE"]);
	}
	$obj->consultar();	

 ?>

</body>
</html>
