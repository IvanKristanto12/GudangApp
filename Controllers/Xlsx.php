<?php

class Xlsx extends Controller
{

	public static function createHead()
	{
		echo '<head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <!-- <meta http-equiv="refresh" content="1"> -->
                <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
                <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
                <link rel="icon" href="Assets/image/title-icon.png">
                <title>Xlsx</title>
            </head>';
	}

	public static function CreateHeader()
	{
		echo '

        <div class="w3-container w3-theme-d2" style="width:100%;">
            <h1 style="display:inline">Gudang App</h1>
            <div style="display:inline; float:right" class="w3-center   ">
                <h6 style="display:inline;">' . $_COOKIE["username"] . '</h6>
                <form action="authLogin" method="POST">
                <button name="logout" style="display:inline;" class="">Log Out</button>
                </form>
            </div>
        </div>';
	}

	public static function CreateNavigationBar()
	{
		echo '<div class="w3-bar w3-dark-gray">
            <a href="stock" class="w3-bar-item w3-button">Stock</a>
            <a href="so" class="w3-bar-item w3-button">SO</a>
            <a href="po" class="w3-bar-item w3-button">PO</a>
            <a href="sj" class="w3-bar-item w3-button">SJ</a>
			<a href="alllist" class="w3-bar-item w3-button ">AllList</a>
			<a href="retur" class="w3-bar-item w3-button ">Retur</a>
			<a href="listretur" class="w3-bar-item w3-button">ListRetur</a>
            </div>';
	}

	public static function createBody()
	{
		self::CreateHeader();
		self::CreateNavigationBar();
		self::parseForm();
	}

	public static function createPage()
	{
		echo '<!DOCTYPE html>
            <html lang="en">';
		self::createHead();
		self::createBody();
		echo '</html>';
	}

	public static function parseForm()
	{
		if (isset($_FILES['file'])) {

			if ($xlsx = SimpleXLSX::parse($_FILES['file']['tmp_name'])) {
				echo '
				<a class="w3-button w3-blue w3-text-black w3-border" href="xlsx"><b>New Insert</b></a>
				<div class="w3-center w3-padding w3-container">
				<h4 class="w3-padding w3-green w3-text-black"><b>Insert Result</b></h4>
				<table border="1" cellpadding="3" style="border-collapse: collapse" class="w3-table-all">
				<tr>
					<th class="w3-center w3-yellow">No</th>
					<th class="w3-center w3-yellow">Tanggal</th>
					<th class="w3-center w3-yellow">Sampel</th>
					<th class="w3-center w3-yellow">Warna</th>
					<th class="w3-center w3-yellow">Nomor Karung</th>
					<th class="w3-center w3-yellow">Meter</th>
				</tr>';

				$dim = $xlsx->dimension();
				$cols = $dim[0];
				$rowNum = 1;
				foreach ($xlsx->rows() as $k => $r) {
					if ($k == 0) continue; // skip first row
					echo '<tr> <td class="w3-center">' . $rowNum . '</td>';
					$rowNum++;
					$barang = [];
					for ($i = 0; $i < $cols; $i++) {
						if ($i == 0) {
							echo '<td class="w3-center">' . date("Y-m-d", strtotime($r[$i])) . '</td>';
							$barang[$i] = date("Y-m-d", strtotime($r[$i]));
						} else if ($i == 1) {
							$sampel = self::$db->executeQuery("GetSampelById", [$r[$i]]);
							echo '<td class="w3-center">' . $sampel[0]["Sampel"] . '</td>';
							$barang[$i] = $r[$i];
						} else if ($i == 2) {
							$warna = self::$db->executeQuery("GetWarnaById", [$r[$i]]);
							if ($warna[0]["NomorWarna"] == null) {
								echo '<td class="w3-center">' . $warna[0]["Warna"] . '</td>';
							} else {
								echo '<td class="w3-center">' . $warna[0]["Warna"] . '-' . $warna[0]["NomorWarna"] . '</td>';
							}
							$barang[$i] = $r[$i];
						} else {
							echo '<td class="w3-center">' . (isset($r[$i]) ? $r[$i] : '&nbsp;') . '</td>';
							$barang[$i] = $r[$i];
						}
					}
					self::$db->executeNonQuery("InsertStock", [$barang[3], $barang[4], "'" . $barang[0] . "'", $barang[1], $barang[2]]);
					echo '</tr>';
				}
				echo '</table>';
				echo '</div><br>';
			} else {
				echo SimpleXLSX::parseError();
			}
		} else {
			//kiri
			echo '
			<div class="w3-half w3-padding w3-border w3-container" style="overflow-y:scroll; height:500px; ">
			<h4 class=" w3-padding w3-center"><b>List Kode Sampel</b></h4>
			<table border="1" class="w3-table-all w3-border w3-padding">
				<th class="w3-center w3-yellow">Id Sampel</th>
				<th class="w3-center w3-yellow">Jenis</th>
				<th class="w3-center w3-yellow">Sampel</th>
				<th class="w3-center w3-yellow">Warna</th> 
				<th class="w3-center w3-yellow">Nomor Warna</th> ';
			$result = self::$db->executeQuery("GetListDetailSampel", [""]);
			$temp = 0;
			for ($i = 0; $i < count($result); $i++) {
				if ($temp != $result[$i]["Id_Sampel"]) {
					echo '<tr>
					<td class="w3-center"><b>' . $result[$i]["Id_Sampel"] . '</b></td>
					<td class="w3-center">' . $result[$i]["JenisKain"] . '</td>
					<td class="w3-center">' . $result[$i]["Sampel"] . '</td>
					<td class="w3-center">' . $result[$i]["Warna"] . '</td>
					<td class="w3-center">' . $result[$i]["NomorWarna"] . '</td>
					</tr>';
					$temp = $result[$i]["Id_Sampel"];
				} else {
					echo '<tr>
					<td class="w3-center" ></td>
					<td class="w3-center" ></td>
					<td class="w3-center" ></td>
					<td class="w3-center">' . $result[$i]["Warna"] . '</td>
					<td class="w3-center">' . $result[$i]["NomorWarna"] . '</td>
					</tr>';
				}
			}
			echo '</table>
			</div>';

			//kanan
			echo '
			<div class="w3-half w3-padding w3-border w3-container" style="overflow-y:scroll; height:500px">
			<h4 class=" w3-padding w3-center"><b>List Kode Warna</b></h4>
			<table border="1" class="w3-table-all w3-border">
				<th class="w3-center w3-yellow">Id Warna</th>
				<th class="w3-center w3-yellow">Warna</th>
				<th class="w3-center w3-yellow">Nomor Warna</th> ';
			$result = self::$db->executeQuery("GetListWarna", [""]);
			for ($i = 0; $i < count($result); $i++) {
				echo '<tr>
				<td class="w3-center"><b>' . $result[$i]["Id_Warna"] . '</b></td>
				<td class="w3-center">' . $result[$i]["Nama"] . '</td>
				<td class="w3-center">' . $result[$i]["NomorWarna"] . '</td>
				</tr>';
			}
			echo '</table>
			</div>';

			echo '
			<div class="w3-container">
			<br>
			<h4 class="w3-center w3-border-bottom w3-padding"><b>Insert Stock</b></h4>
			<form method="POST" enctype="multipart/form-data" class="w3-center">
			*.XLSX <input id="inputXlsx" type="file" name="file" accept=".xlsx" class="w3-red" onchange="checkInput()" required/>&nbsp;&nbsp;<input type="submit" value="Insert" />
			</form>';
		}
		echo '<script src="Assets/script/xlsx.js"></script></div>';
	}
}
