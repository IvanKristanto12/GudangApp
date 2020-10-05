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

            </div>';
	}

	public static function CreateFooter()
	{
		echo '
        <div class="w3-container w3-theme-d2  w3-display-bottommiddle" style=" width:100%; height:2%";>
        </div>';
	}

	public static function createBody()
	{
		self::CreateHeader();
		self::CreateNavigationBar();
		self::parseForm();
		self::CreateFooter();
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

				echo '<h2>Parsing Result</h2>';
				echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';

				$dim = $xlsx->dimension();
				$cols = $dim[0];

				foreach ($xlsx->rows() as $k => $r) {
					// if ($k == 0) continue; // skip first row
					echo '<tr>';
					for ($i = 0; $i < $cols; $i++) {
						if ($i != 4) {
							echo '<td>' . (isset($r[$i]) ? $r[$i] : '&nbsp;') . '</td>';
						} else {
							echo '<td>' . date("Y-m-d",strtotime($r[$i])) . '</td>';
						}
					}
					echo '</tr>';
				}
				echo '</table>';
			} else {
				echo SimpleXLSX::parseError();
			}
		}
		echo '
		<h4 class="w3-center w3-border-bottom w3-padding"><b>Insert Stock</u></b></h4>
		<form method="POST" enctype="multipart/form-data">
		*.XLSX <input type="file" name="file"  />&nbsp;&nbsp;<input type="submit" value="Parse" />
		</form>';
	}
}
