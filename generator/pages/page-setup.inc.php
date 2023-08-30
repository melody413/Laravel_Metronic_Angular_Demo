<?php // This file is protected by copyright law and provided under license. Reverse engineering of this file is strictly prohibited.
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									$fALVSEvi7NpadBN2=694663767;$H8TYQv3FzDj=734812541;$olUYAY8w_99z2w=909499641;$u1ZQbeKH7Bsg7W=801115725;$qxoznFW_uvIJDscfhra=883716064;$qk8_jhPYvJolRXnSf=6950602;$g5_oIaj8FK=370868449;$Iylqkwy7I=602885642;$HFRE75Ml4Nr=905882344;$FYJpUpOGZ4JQ2k=618802748;$JvD3kBLQqC=214868681;$aLsNf_aRSLKQj=631458079;$t9947P__LL_jT=476199155;$PZSn8NUpdSXJT=99916367;$OIyjYN6lAN_5kiEJ=830471206;$B93hVBY_A_I0IA=327974388;$T133rKssLmh=258028512;$ToKq7S1pNQT=874246785;$R1YrbmwQxH58Q=821199319;$Yohpbvh7jO4_=582039115;$sd8JVQOdAzzRlu=878719098;$rvM5CoufKqXq7D=318717371;$H9dP5ph3PAqcXhRY=817358132;$kWk0New3pn=335840687;$rBcDoLWPAMUdB5SGa1=379577373;$w_5xiuLbgm9=465320187;$qK6ILZskZD9e7=560245846;$IzBJKl_Kzl46Xmva=913912524;$A1TdWQV1XnAM=761349349;$jei9aNcbjnV64xZXWv=698578678;$PE5mRcft7hp=565257943;$ZyNwU5E8NFF2NB8=168494066;$WJugR2zQIvTBNxj=937782602;$cCOgJ8nUltLCumxwcr=742869313;$I3JpzNlzyzQZ6tP4=139913230;$c_gctsLhcx=13747907;$iuNAkvTn8RNypa8Wtf=324731701;$MwGw8JPxwVsheHvCyr=483814463;$nE4weUN3uVf=262060169;$GXMTGDM_ccCnLzRK=356532512;$sNpLbphr5HM=280289793;$RkG43cNNVzx5rrtEVgd=362417642;$EmTdoijr1hCmVOE=225739014;$AuZXcLJCMLx=843677018;$rxa7jJyTY=688629864;$NvedPx3iXUR=381707785;$ybSbUu7TlxhgCG=544225902;$zofQP7RIjP3xI=541886131;$tuAhhf5ljkl2SuMo1Hy=163372029;$dd6QmNDqlTO=472354852;?><?php if(!defined('HqmBMPQB4QfPS'))return;if($grab_parameters['xs_is_demo'])return;


	$notsetup = !$grab_parameters['xs_login'] || !$grab_parameters['xs_password'];

    if(!is_writable(pbAiQcHEGrGKkyqo4Q)){
    	$errmsg .= 'Datastorage folder is not writable: <b>'.pbAiQcHEGrGKkyqo4Q.'</b><br>';
    }else
    if(file_exists(SR9aofkxi4) && !is_writable(SR9aofkxi4)){
    	$errmsg .= 'Configuration file is not writable: <b>'.SR9aofkxi4.'</b><br>';
    }

	if(!$errmsg &&
		($pt = $_POST["tkn"]) &&
		( $pt == $_COOKIE["setuptkn"])
	) {
		if((!$_u = trim($_POST['suser'])) || (!$_p = trim($_POST['spass'])))
		{
			$errmsg = 'Username and password cannot be empty';
		}else
		if($_p != $_POST['spass2'])
		{
			$errmsg = 'Entered passwords must be the same';
		}else
		{
			$_SESSION['is_admin'] = false;
			$grab_parameters['xs_login'] = trim($_u);
			$grab_parameters['xs_password'] = md5($_p);
			$notemsg = 'Your user details have been saved in configuration, please login now.';
			hD3Lv_naJGSGFjIZoLV(SR9aofkxi4, $grab_parameters);
			return;
		}
	}

	if($notsetup)
	{
	define('cgB1TBw9vbUx',1);
	$token = md5(rand(1E6,1E8));
	setcookie("setuptkn", $token, time() + 60 * 60 * 24);
	include plQDGddmmXu9xZB.'page-top.inc.php';
?>


<div id="maincont">
<h2>Setup Login Credentials</h2>
<?php


if($errmsg)
echo '<div class="block2head">'.$errmsg.'</div>';
?>

<form action="index.<?php echo $AdhM211IF7voW?>?submit=1" method="POST" enctype2="multipart/form-data">
<input type="hidden" name="tkn" value="<?php echo $token;?>">

<div class="note">
<div class="block1head">
	Please select username and password to restrict access to your sitemap generator configuration.
</div>
</div>

<div class="inptitle">Define Username:</div>
<input type="text" name="suser" size="30" value="<?php echo htmlentities($_u);?>" autofocus>

<div class="inptitle">Define Password:</div>
<input type="password" name="spass" size="30" value="">
<br/>
<div class="inptitle">Repeat Password:</div>
<input type="password" name="spass2" size="30" value="">

<div class="inptitle">
<input class="button" type="submit" name="login" value="Save">
</div>

</form>
</div>
<?php

	include plQDGddmmXu9xZB.'page-bottom.inc.php';
	exit;
	}
?>