<?php
require_once("connection.php");

$GelenCevap		=	Filtre($_POST["cevap"]);

$KontrolSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM survey_attention WHERE ip_address = ? AND tarih >= ?");
$KontrolSorgusu->execute([$IPAddress, $TimeReverse]);
$KontrolSayisi		=	$KontrolSorgusu->rowCount();

if($KontrolSayisi>0){
	echo "HATA<br />";
	echo "Daha önce oy kullanmışsınız. Lütfen en az 24 saat sonra tekrar deneyiniz.<br />";
	echo "Anasayfaya dönmek için <a href='index.php'>tıklayınız.</a>";
}else{
	if($GelenCevap==1){
		$Guncelle	=	$VeritabaniBaglantisi->prepare("UPDATE survey SET voteOne=voteOne+1, total_vote=total_vote+1");
		$Guncelle->execute();
	}elseif($GelenCevap==2){
		$Guncelle	=	$VeritabaniBaglantisi->prepare("UPDATE survey SET voteTwo=voteTwo+1, total_vote=total_vote+1");
		$Guncelle->execute();
	}elseif($GelenCevap==3){
		$Guncelle	=	$VeritabaniBaglantisi->prepare("UPDATE survey SET voteThree=voteThree+1, total_vote=total_vote+1");
		$Guncelle->execute();
	}else{
		echo "HATA<br />";
		echo "Cevap Kaydı Bulunamıyor.<br />";
		echo "Anasayfaya dönmek için <a href='index.php'>tıklayınız.</a>";
	}
	
	$Ekle			=	$VeritabaniBaglantisi->prepare("INSERT INTO survey_attention (ip_address, tarih) values (?, ?)");
	$Ekle->execute([$IPAddress, $ZamanDamgasi]);
	$EkleKontrol	=	$Ekle->rowCount();
	
	if($EkleKontrol>0){
		echo "TEŞEKKÜRLER<br />";
		echo "Vermiş Olduğunuz Oy Sisteme Kaydedildi.<br />";
		echo "Anasayfaya dönmek için <a href='index.php'>tıklayınız.</a>";

	}else{
		echo "HATA<br />";
		echo "İşlem Sırasında Beklenmeyen Bir Hata Oluştu. Lütfen Daha Sonra Tekrar Deneyiniz<br />";
		echo "Anasayfaya dönmek için <a href='index.php'>tıklayınız.</a>";
	}
}

$VeritabaniBaglantisi	=	null;
?>