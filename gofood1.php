<?php
// Header
$secret = '83415d06-ec4e-11e6-a41b-6c40088ab51e';
$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'X-AppVersion: 3.27.0';
$headers[] = "X-Uniqueid: ac94e5d0e7f3f".rand(111,999);
$headers[] = 'X-Location: -6,117412,106,153527';

function fetch_value($str,$find_start,$find_end)
    {
        $start = @strpos($str,$find_start);
        if ($start === false) {
            return "";
        }
        $length = strlen($find_start);
        $end    = strpos(substr($str,$start +$length),$find_end);
        return trim(substr($str,$start +$length,$end));
    }

function nama()
	{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://ninjaname.horseridersupply.com/indonesian_name.php");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$ex = curl_exec($ch);
	// $rand = json_decode($rnd_get, true);
	preg_match_all('~(&bull; (.*?)<br/>&bull; )~', $ex, $name);
	return $name[2][mt_rand(0, 14) ];
	}

function curl($url, $fields = null, $headers = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        if ($fields !== null) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        }
        if ($headers !== null) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $result   = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return array(
            $result,
            $httpcode
        );
	}

function request($url, $token = null, $data = null, $pin = null, $otpsetpin = null, $uuid = null)
    {

    $header[] = "Host: api.gojekapi.com";
    $header[] = "User-Agent: okhttp/3.10.0";
    $header[] = "Accept: application/json";
    $header[] = "Accept-Language: id-ID";
    $header[] = "Content-Type: application/json; charset=UTF-8";
    $header[] = "X-AppVersion: 3.30.2";
    $header[] = "X-UniqueId: ".time()."57".mt_rand(1000,9999);
    $header[] = "Connection: keep-alive";
    $header[] = "X-User-Locale: id_ID";
    $header[] = "X-Location: -6.917464,107.619122";
    $header[] = "X-Location-Accuracy: 3.0";
    if ($pin):
    $header[] = "pin: $pin";
        endif;
    if ($token):
    $header[] = "Authorization: Bearer $token";
    endif;
    if ($otpsetpin):
    $header[] = "otp: $otpsetpin";
    endif;
    if ($uuid):
    $header[] = "User-uuid: $uuid";
    endif;
    $c = curl_init("https://api.gojekapi.com".$url);
        curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        if ($data):
        curl_setopt($c, CURLOPT_POSTFIELDS, $data);
        curl_setopt($c, CURLOPT_POST, true);
        endif;
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_HEADER, true);
        curl_setopt($c, CURLOPT_HTTPHEADER, $header);
        $response = curl_exec($c);
        $httpcode = curl_getinfo($c);
        if (!$httpcode)
            return false;
        else {
            $header = substr($response, 0, curl_getinfo($c, CURLINFO_HEADER_SIZE));
            $body   = substr($response, curl_getinfo($c, CURLINFO_HEADER_SIZE));
        }
        $json = json_decode($body, true);
        return $body;
    }

function getStr($a,$b,$c)
    {
        $a = @explode($a,$c)[1];
        return @explode($b,$a)[0];
    }

function getStr1($a,$b,$c,$d)
    {
            $a = @explode($a,$c)[$d];
            return @explode($b,$a)[0];
    }

function color($color = "default" , $text)
    {
        $arrayColor = array(
            'grey'      => '1;30',
            'red'       => '1;31',
            'green'     => '1;32',
            'yellow'    => '1;33',
            'blue'      => '1;34',
            'purple'    => '1;35',
            'nevy'      => '1;36',
            'white'     => '1;0',
        );  
        return "\033[".$arrayColor[$color]."m".$text."\033[0m";
    }
// Menu

echo "=======================\n";
echo "1. Register (Akun Baru)\n";
echo "2. Login (Akun Lama)\n";
echo "=======================\n";
echo "Select Your Tools: ";
$menu = trim(fgets(STDIN));
	if($menu == "1")
	{ 
		echo "\n-----------------------------------------------\n";
		echo "INFO - 08 Untuk Nomer Indo dan 1 Untuk Nomer US\n";
		echo "-----------------------------------------------\n";
		echo "Nomer HP: ";
		$number = trim(fgets(STDIN));
		$numbers = $number[0].$number[1];
		if($numbers == "08") { 
			$number = str_replace("08","628",$number);
		}
		$nama = nama();
		$email = strtolower(str_replace(" ", "", $nama) . mt_rand(100,999) . "@gmail.com");
		$data1 = '{"name":"' . $nama . '","email":"' . $email . '","phone":"+' . $number . '","signed_up_country":"ID"}';
		$reg = curl('https://api.gojekapi.com/v5/customers', $data1, $headers);
		$regs = json_decode($reg[0]);
		// Verif OTP
		if($regs->success == true) {
			echo "Enter OTP: ";
			$otp = trim(fgets(STDIN));
			$data2 = '{"client_name":"gojek:cons:android","data":{"otp":"' . $otp . '","otp_token":"' . $regs->data->otp_token . '"},"client_secret":"' . $secret . '"}';
			$verif = curl('https://api.gojekapi.com/v5/customers/phone/verify', $data2, $headers);
			$verifs = json_decode($verif[0]);
			if($verifs->success == true) {
				// Claim Voucher
				$token = $verifs->data->access_token;
				$headers[] = 'Authorization: Bearer '.$token;
				echo "Mencoba Redeem Voc 20+10 \n";
				$data3 = '{"promo_code":"GOFOODSANTAI19"}';
				$claim = curl('https://api.gojekapi.com/go-promotions/v1/promotions/enrollments', $data3, $headers);
				$claims = json_decode($claim[0]);
				if ($claims->success == true) {
					// Claim Voucher
                                $live2 = "santai19";
                                $fopen2 = fopen($live2, "a+");
                                $fwrite2 = fwrite($fopen2, "TOKEN => ".$token." \n");
                                fclose($fopen2);
                                echo "Hasil->" .$claims->data->message."  [•] Token Tersimpan di ~> ".$live2;
					} else {
					echo "\n\n[×] Gagal Claim Voucer !, but wait ... ";
					sleep(5);
                                    echo "\n";
                                    // SANTAI11
                                    echo "Mencoba Redeem Voc 15+10 \n";
                                        $data4 = '{"promo_code":"WADAWGOJEK"}';
                                        $claim1 = curl('https://api.gojekapi.com/go-promotions/v1/promotions/enrollments', $data4, $headers);
                                        $claims1 = json_decode($claim1[0]);
                                        if($claims1->success == true) 
                                                {
                                                        // Claim Voucher
                                                        $live3 = "santai11";
                                                        $fopen3 = fopen($live3, "a+");
                                                        $fwrite3 = fwrite($fopen3, "TOKEN => ".$token." \n");
                                                        fclose($fopen3);
                                                        echo "Hasil->".$claims1->data->message."  [•] Tersimpan di ~> ".$live3;
										}else {
                                                echo "[×] Gagal Claim Voucer !";		}
			}
			
		} else {
			die("ERROR - AKUN SUDAH ADA");
		}
	}
	} 
	elseif($menu == "2") {
		echo "\n-----------------------------------------------\n";
		echo "INFO - 08 Untuk Nomer Indo dan 1 Untuk Nomer US\n";
		echo "-----------------------------------------------\n";
		echo "Nomer HP: ";
		$number = trim(fgets(STDIN));
		$numbers = $number[0].$number[1];
		if($numbers == "08") { 
			$number = str_replace("08","628",$number);
		}
		$login = curl('https://api.gojekapi.com/v3/customers/login_with_phone', '{"phone":"+' . $number . '"}', $headers);
		$logins = json_decode($login[0]);
		if($logins->success == true) {
			echo "Enter OTP: ";
			$otp = trim(fgets(STDIN));
			$data1 = '{"scopes":"gojek:customer:transaction gojek:customer:readonly","grant_type":"password","login_token":"' . $logins->data->login_token . '","otp":"' . $otp . '","client_id":"gojek:cons:android","client_secret":"' . $secret . '"}';
			$verif = curl('https://api.gojekapi.com/v3/customers/token', $data1, $headers);
			$verifs = json_decode($verif[0]);
			if($verifs->success == true) {
				// Cek Voc
				$token = $verifs->data->access_token;
				$headers[] = 'Authorization: Bearer '.$token;
				print_r($token);
				$cekvoucher = request('/gopoints/v3/wallet/vouchers?limit=10&page=1', $token);
                $total = fetch_value($cekvoucher,'"total_vouchers":',',');
                $voucher3 = getStr1('"title":"','",',$cekvoucher,"3");
                $voucher1 = getStr1('"title":"','",',$cekvoucher,"1");
                $voucher2 = getStr1('"title":"','",',$cekvoucher,"2");
                $voucher4 = getStr1('"title":"','",',$cekvoucher,"4");
                $voucher5 = getStr1('"title":"','",',$cekvoucher,"5");
                
                
                $expired1 = getStr1('"expiry_date":"','"',$cekvoucher,'1');
                $expired2 = getStr1('"expiry_date":"','"',$cekvoucher,'2');
                $expired3 = getStr1('"expiry_date":"','"',$cekvoucher,'3');
                $expired4 = getStr1('"expiry_date":"','"',$cekvoucher,'4');
                $expired5 = getStr1('"expiry_date":"','"',$cekvoucher,'5');
                    
                
                echo "\n".color("yellow","!] Total voucher ".$total." : ");
                echo "\n".color("green","1] ".$voucher1);
                echo "\n".color("red"," EXP ~> ".$expired1);
                echo "\n".color("green","2] ".$voucher2);
                echo "\n".color("red"," EXP ~> ".$expired2);
                echo "\n".color("green","3] ".$voucher3);
                echo "\n".color("red"," EXP ~> ".$expired3);
                echo "\n".color("green","4] ".$voucher4);
                echo "\n".color("red"," EXP ~> ".$expired4);
                echo "\n".color("green","5] ".$voucher5);
                echo "\n".color("red"," EXP ~> ".$expired5);
                echo"\n";
            } else {
					die ("\n\n Gagal cek voc ");
					}
			} else {
				die("OTP salah!");
			}
		} else {
			die("ERROR - Nomer belum kedaftar !");
				}
	