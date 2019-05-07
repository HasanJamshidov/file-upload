<?


if (isset($_POST['submit'])) 
{
	/*
	$_FILES yukelnen file-a aid melumatlari ozunde saxlayan super global deyiskendir. ($_POST, $_GET, $_COOKIE ve s. kimi. Ona gore super global adlanirlar ki proyektin icindekinnistenilen file daxilinde cagirilib islenile bilirler, diger deyiskenler kimi sadece icerisinde olduqlari phpsehifesinde kecerli deyiller ). [ ] daxilinde file-i yuklemek ucun hansi inputu istifade edirikse onun adini yaziriq.  

	*/



	$file = $_FILES['fileInput'];

	//print_r($file);  

	/*
		$file deyiskeni assosiativ array formasindadir. Onun elementlerini asagidaki formada cagirib istifade ede bilerik.
	*/

	// file-in adini bu sekilde elde ede bilerik
	$fileName = $file['name'];

	/*
	file-in muveqqeti adi ve unvani burdadir. File yuklenende kecici olaraq bura yuklenir. Amma bu unvandaki file-i birbasa cagirib istifade etmeyimiz mumkun deyil, cunki .tmp genislenmesi ile saxlanilir.
	*/
	$fileTmpName = $file['tmp_name'];

	// file yuklenende sehv verib vermediyini gosterir. Eger hec bir error bas vermeyibse bunun deyeri 0 olur.
	$fileError = $file['error'];

	//file-in olcusunu byte olaraq gosterir
	$fileSize = $file['size'];
	
	// explode stringi hisselere ayirmaq ucun istifade olunan metoddur. Ilk parametri neye esasen boluneceyini, ikinci parametr ise bolunecek stringi gosterir. Meselen, bizim yuklediyimiz adi sekil.jpg olsun. Biz noqteye esasen file-in adini hisselere ayirsaq asagidaki code setrini istifade edeceyik. Neticede $fileExt deyiskeni iki elementi olan massiv olcaq: $fileExt[0] = sekil ve $fileExt[1] =jpg formasinda.
	$fileExt = explode('.', $fileName);

/* Bu dovr size explode funksiyasinin neticesini visual sekilde gormeye imkan verir, yeni neticenin ne olacagini test ede bilerik.

	foreach ($fileExt as $value) 
	{
		echo $value;
		echo "<br>";
	}

*/

	//end $fileExt massivinin en son elementini dondurur. Bizde bu filein genislenmesi olcaq. strtolower ise hemin genislenmeni kicik herflere cevirir. Meselen PNG-dirse, artiq png olacaq.
	$fileLastExt = strtolower(end($fileExt));

	// icaze verilen file formatlarini yaratdigimiz bir massivde saxlayiriq. Diqqet edin ki, burdaki genislenmeler kicik herfle yazilib. Bu sebebden az onceki $fileLastExt deyiskenimizin de kicik herflerle yazildigina emin olmaq ucun strtolower istifade etdik. Qarsilasdirma zamani ola bilecek butun problemleri aradan qaldirmaq ucun.
	$allowedFormats  = array( 'png','jpg', 'jpeg', 'pdf');

	//in_array arrayin icerisinde axtaris ucun istifade olunur. Eger $fileLastExt deyiskeninin qiymetini $allowedFormats massivinde de tapsa true geri donderecek.
	if (in_array($fileLastExt, $allowedFormats)) 
	{
		//yuklenme zamani hec bir xeta bas vermeyibse
		if ($fileError === 0 )
		 {
		 	// olcu 50mb-dan boyuk deyilse (50000000 byte = 50mb). Istediyiniz olcunu byte olaraq yaza bilersiniz. Olculerin byte-a cevrilmesini Google-da   tapmaq olur (50mb to byte google-layin meselen :) ) ya da riyazi olaraq code-un icerisinde de yaza bilerisiniz. Hansi size daha elverisli gelirse ele istifade edin.
			if ($fileSize <= 50000000) 
			{
				/*
				file-lara tekrarlanmayan ad teyin etmek ucun uniqid() istifade edirik. Bu  Tekrarlanma riskini en minimala endirmek ucun uniqid-nin yaratdigi ifadenin onune rand() funkisyasi ile yaratdigimiz 1-1000000 tesadufi bir ededi de teyin edirik. Uniqid serverdeki (ya da localserver) tarixe esasen 13 simvol uzunlugunda uniq ifadeler yaradir. Qirmizi rengde olan noqteler stringleri birlesdirmek ucundur (java, javascript ve s. dillerdeki + operatorunun benzeri).
				*/
				$fileNewName = uniqid(rand(1, 1000000)).".".$fileLastExt ;

				//hara yukleneceyini gosteririk
				$path = 'uploads/'.$fileNewName;

				/* Ve nehayet her sey qaydasindadirsa tmp_name-de gosterilen unvanda muveqqeti olaraq movcud olan .tmp genislenmeli file-mizi arzu etdiyimiz qovluga dasiya bilerik. Diqqet yetirin ki biz fileNewName deyiskenine file-in oz formatina uygun genislenmeni de elave etmisdik.

				$fileNewName = uniqid(rand(1, 1000000)).".".$fileLastExt ;

				Burdaki $fileLastExt noqteden sonra genislenmeni de elave edirdi. Yeni artiq tmp genislenmesi ile bitmir faylimiz.

				*/
				move_uploaded_file($fileTmpName, $path);

				//url-e get methodu ile file-in adini gondere bilerik. Bunu index sehifesinde $_GET['fileName'] olaraq elde edeceyik. Bunu etmek zeruri deyil, sadece yoxlamaq ucun yazmisdiq. 
				header("Location: index.php?fileName=$fileNewName");
			}

			//teyin etdiyimiz olcuden boyukdurse
			else
			{
				echo "Olcu cox boyukdur";
			}
		 }
		 //yuklenme zamani xeta bas veribse
		 else
		 {
		 	echo "File yuklene bilmedi";
		 }
	}

	//in_array false geri dondurubse, yeni istifadece sekil ve ya pdf olmayan bir file yuklemeye calisibsa
	else{
		echo "File-nizin formati duzgun deyil";
	}



}

?>