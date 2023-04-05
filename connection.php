<?php 
try{
    $VeritabaniBaglantisi       =       new PDO("mysql:host=localhost;dbname=crud_db;charset=UTF8","root","");
}
catch(PDOException $Hata){
    echo $Hata -> getMessage();
    die();
}

function Filtre($Deger){
    $Bir          =       trim($Deger);
    $Iki          =       strip_tags($Bir);
    $Uc           =       htmlspecialchars($Iki);
    $Sonuc        =       $Uc;
    return $Sonuc;

}

$IPAddress  =   $_SERVER["REMOTE_ADDR"];

$ZamanDamgasi   =   time();

$VoteLimit  =   86400;

$TimeReverse    =   $ZamanDamgasi-$VoteLimit;

?>