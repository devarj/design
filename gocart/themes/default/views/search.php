<?php 
	
	if(isset($_GET['searchTerm'])){
		$search = $_GET['searchTerm'];
		
		header("location:http://192.21.0.57/prod/mayd/cart/search/". md5($search) . "/0");
		
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div style="position: fixed;
				background: #379324;
				color: #fff;
				z-index: 9;
				right: 1rem;
				bottom: 5rem;
				max-width: 180px;
				width: 100%;
				padding: 10px;
				text-align: center;
				font-size: 0.85em;">
	<label style="font-family: Helvetica">PRODUCT NAME</label>
	<form method="get">
	<input style="padding: 5px; width: 165px; margin: 1px 1px 5px 1px;" name="searchTerm" size="20" type="text">
	<input id="realtalk" type="submit" style="padding: 5px; background-color: #e74c3c; border: 0px solid #000; color: #fff" value="Search">
	</form>
	</div>
</body>
</html>