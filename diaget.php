<html>
<title>VO1D RPT SYS</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="w3-theme-black.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif}
.w3-sidenav a,.w3-sidenav h4{padding:12px;}
.w3-navbar a{padding-top:12px !important;padding-bottom:12px !important;}
</style>
<body>
<?php
//
error_reporting(E_ALL ^ E_NOTICE); 
$url = "https://diademo.ws.dia.com.tr/api/v3/sis/json";
// SESSION ID MANUEL GİRİLMELİ
$session_id = "";
$firma_kodu = 34;
$donem_kodu = 1;

$data = <<<EOT
{"login" :
    {"username": "ws",
     "password": "ws",
     "disconnect_same_user": "True",
     "lang": "tr"
    }
}

EOT;

$curl = curl_init();
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data))
);
curl_setopt($curl, CURLOPT_URL, $url);
$result = curl_exec($curl);

$json=json_decode($result,true);
curl_close($curl);
//print_r($json);

//echo $json['msg'];

$url = "https://diademo.ws.dia.com.tr/api/v3/rpr/json";

$session_id = $json['msg'];
$firma_kodu = 34;
$donem_kodu = 1;

$data = <<<EOT
{"rpr_raporsonuc_getir" :
    {"session_id": "$session_id",
     "firma_kodu": $firma_kodu,
     "donem_kodu": $donem_kodu,
     "report_code":"scf1110a",
     "tasarim_key": "1200",
     "param":  {"_key": "178717",
	"tarihbaslangic": "2017-01-01",
	"tarihbitis": "2017-12-31",
	"tarihreferans": "2017-09-08",
	"vadeyontem": "B",
	"vadefarki": "0",
	"__ekparametreler": ["acilisbakiyesi"],
	"__fisturleri": [],
	"_key_sis_sube": 0,
	"_subeler": [],
	"topluekstre": "False",
	"tekniksformgoster": "False",
	"baesitsegosterme": "False",
	"filtreler": [{"filtreadi": "vadetarihi",
	                  "filtreturu": "aralik",
	                  "ilkdeger": "2017-01-01",
	                  "sondeger": "2017-12-31",
	                  "serbest": ""
	                 }],
	"siralama":[{"fieldname": "vadetarihi",
	                   "sorttype": "asc"
	                  }],
	"gruplama":[{"fieldname": "turu"}]
	},
     "format_type": "json"
    }
}
EOT;

$curl = curl_init();
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data))
);

curl_setopt($curl, CURLOPT_URL, $url);
$result = curl_exec($curl);

$json=json_decode($result,true);
//$jdata=base64_decode($json);

curl_close($curl);
$jdata=base64_decode($json['result']);
$jsonCode = json_decode($jdata,1);
//echo $json_data;

echo "<table class='table table-striped'>";
$theadeklendi=false;
echo "<thead>";
echo "<tr>";
foreach ($jsonCode as $k=>$v){
	echo "<th>";
	echo $k;
	echo "</th>";
}
echo "</tr>";
echo "</thead>";
echo "<tbody>";

echo "<tr>";
foreach ($jsonCode as $k=>$v){
	echo "<td>";
	echo $v;
	echo "</td>";
}
echo "</tr>";
echo "</tbody>";
echo "</table>";
?>


