<?php

error_reporting(0);
if (!file_exists('token')) {
    mkdir('token', 0777, true);
}

include ("curl.php");
echo "\n";
echo "\e[94m          BERBURU PROMO MEDAN           \n";
echo "\e[91m FORMAT NOMOR HP : INDONESIA '62***' , US='1***'\n";
echo "\e[93m HANYA UNTUK REGISTER DAN CLAIM VOUCHER\n";
echo "\e[93m CREATE BY ZY FLASHER MEDAN\n";
echo "\e[93m MAKAN GAK HARUS MAHAL \n";
echo "\n";
echo "\e[96m[X] Masukkan Nomor HP Anda (62/1) : ";
$nope = trim(fgets(STDIN));
$register = register($nope);
if ($register == false)
    {
    echo "\e[91m[X] Nomer Bekas Kau Masukan\n";
    }
  else
    {
    otp:
    echo "\e[96m[X] Masukan OTP Bro : ";
    $otp = trim(fgets(STDIN));
    $verif = verif($otp, $register);
    if ($verif == false)
        {
        echo "\e[91m[X] Kode OTP Salah\n";
        goto otp;
        }
      else
        {
        file_put_contents("token/".$verif['data']['customer']['name'].".txt", $verif['data']['access_token']);
        echo "\e[93m[X] Mencoba Redeem : GOFOOD 30K !\n";
        sleep(3);
        $claim = claim($verif);
        if ($claim == false)
            {
            echo "\e[92m[!]".$voucher."\n";
            sleep(3);
            echo "\e[93m[X] Mencoba Redeem : GOFOOD 25K !\n";
            sleep(3);
            goto next;
            }
            else{
                echo "\e[92m[+] ".$claim."\n";
                sleep(3);
                echo "\e[93m[X] Mencoba Redeem : WADAW !\n";
                sleep(3);
                goto ride;
            }
            next:
            $claim = claim1($verif);
            if ($claim == false) {
                echo "\e[92m[!]".$claim['errors'][0]['message']."\n";
                sleep(3);
                echo "\e[93m[X] Mencoba Redeem : GOFOOD 20K !\n";
                sleep(3);
                goto next1;
            }
            else{
                echo "\e[92m[+] ".$claim."\n";
                sleep(3);
                echo "\e[93m[X] Mencoba Redeem : WADAW !\n";
                sleep(3);
                goto ride;
            }
            next1:
            $claim = claim2($verif);
            if ($claim == false) {
                echo "\e[92m[!]".$claim['errors'][0]['message']."\n";
                sleep(3);
                echo "\e[93m[X] Mencoba Redeem : WADAW !\n";
                sleep(3);
                goto ride;
            }
          else
            {
            echo "\e[92m[+] ".$claim . "\n";
            sleep(3);
            echo "\e[93m[X] Mencoba Redeem : WADAW !\n";
            sleep(3);
            goto ride;
            }
            ride:
            $claim = ride($verif);
            if ($claim == false ) 
           {
                echo "\e[92m[!]".$claim['errors'][0]['message']."\n";
                sleep(3);
                echo "\e[93m[X] Mencoba Redeem : AYOCOBAGOJEK !\n";
                sleep(3);

            }
            else{
                echo "\e[92m[+] ".$claim."\n";
                sleep(3);
                echo "\e[93m[X] Mencoba Redeem : AYOCOBAGOJEK !\n";
                sleep(3);
                goto pengen;
            }
            pengen:
            $claim = cekvocer($verif);
            if ($claim == false ) {
                echo "Maaf Akun Anda Tidak Ada Voucher\n";
            }
            else{
                echo "\e[92m[+] ".$claim."\n";
                
        }
    }
    }


?>
