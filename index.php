<?
$fileName = $_GET['fileName'];
?>
r<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<!-- File yukleyeceksinizse forma mutleq enctype="multipart/form-data" atributunu da elave etmelisiniz. Bunun sayesinde form gonderilerken ASCII koda cevrilmir, file formatini qoruyub saxlayir ve imkan verir ki $_FILES icerisine file-nizin melumatlari gonderile bilsin. Bu enctype atributunu sadece post methodu ile istifade ede bilersiniz. Get ile mumken olmur.
-->


	<form method="post" action="upload.php" enctype="multipart/form-data">

		<input type="file" name="fileInput">
		<!--<img src="uploads/<?= $fileName?>" width="300" height="300">  -->

		<a href="uploads/<?= $fileName ?>"><?= $fileName ?></a>
		<button name="submit">Upload</button>
	</form>
</body>
</html>