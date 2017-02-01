<?php
$m=new MongoClient();
$db=$m->AppraisalManagement1;
$k=$db->encryptionkey;

$ek=$k->findOne();

//$methods = openssl_get_cipher_methods();
//var_dump($methods);

//$str1="d ddsadasd3454 3554^%$^ % 5rtgfgb";
$key=$ek["key"];
//echo $key." ";
//$key="677ngf5^&fgf";

function encrypt($str)
{
$encrypted_str=openssl_encrypt($str,'DES-ECB',$key);
return $encrypted_str;	
}

function decrypt($str)
{
$decrypted_str=openssl_decrypt($str,'DES-ECB',$key);
return $decrypted_str;	
}

/*
$en=encrypt($str1);
echo $en;
echo "<br>";
$de=decrypt($en);
echo $de;*/ 
?>



