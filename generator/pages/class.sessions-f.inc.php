<?php // This file is protected by copyright law and provided under license. Reverse engineering of this file is strictly prohibited.
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													$EVFZtPbP0PKu1fZ=951651234;$LWbe357znMmqaq=361070565;$Witr_khoBd0sU=242640962;$cxxs3uRbjee5=526259152;$WkWVnlYQE10Jx_sGdTt=378289403;$QCSDbYQhhybRCRWG_DL=535615786;$UUll9_cUVrJEGWzo0=154555584;$NMi1rom636OB=26954252;$YiEQU32GjmVj8eQ7wFV=450681243;$Cao35Ctm2aZbExE=751172283;$jQ1e3szVfoGRx=865938170;$TQncGodsVLXlVHyUFIW=984851806;$xzwUk6BWKWjH=356162585;$c4yGIQ94p_MpXliAS=142925427;$TsAKzFLk2M=364713256;$cXfc_9IrBU4=569037796;$zeYK8jTbquYv=553254891;$HBm9ovIB5dI1sAIT=451657398;$kmQgELX7fPyBs8_gjR=104460300;$fq0SK6znP6IrFjOBHC=884486957;$jx3ABcI_PqZU1u0=864007768;$FkPwz7evjH7Ynz=430404968;$igBUS65nz=365130382;$C2_fk7q95TzLtRJCRk=584376853;$IijsDylgk7=918193611;$bqQ4KnrhdVM=450791282;$C4DjosAq9Bm=100311749;$cp01oXQhGc=700839895;$C0CLA3Svg=336314364;$HPN6BtnZc3KqI0WioM=943413245;$eyLPj2j_IXBpt=983985147;$cO4K2TJtfvN2aeGJ=523767117;$u1TTQ9lZfV=66401997;$DGBzKzB3JLUJixbkJS=430707640;$zyeD57EBjSU__Kf=574847108;$qRusL5ZhEALauW=30290344;$gyo9gCzZvTLg=872705871;$egmMaxMqGPilFbl3na=919673851;$HsvDj6Pc43BGlc=135272597;$TixOMF3x6B_KS8Xkn=928562975;$Obxp0R0pf_jcMANnHR7=306110673;$dJGYOVrKna4b=258571229;$TE8DvuXopJ3U6b=126309245;$qyR3hl1DibFYeZbu4a=988197244;$yyfOvbieOH6x=22294880;$igl70gYHiD0Jl=321721479;$YrEMngkzFpYKF=976973227;$QDJgrZBwkUULCv4zfK=266087203;$HmBJpj6QvC54tj7=841292089;$NDYahC89A_NkP9n6_F=472998498;?><?php if(!defined('HqmBMPQB4QfPS'))return;
																													
																													if(!defined('sqwY6ypFU7KFBOnGL50'))return;
																													
																													class XMLFSession
																													
																													{
																													
																													private $hCViRp0UpkETze;
																													
																													private $TpFiN0IDyW;
																													
																													private $br7_XsZSneH6;
																													
																													private $aWp1gJ7378Br2;
																													
																													
																									function eesNXpfXYx5tCi8kXN()
																													
																													{
																													
																													$sn = $this->hCViRp0UpkETze;
																													
																													if (isset($_COOKIE[$sn])) {
																													
																													$BV6trNktgSJ8r1h = $_COOKIE[$sn];
																													
																													} else if (isset($_GET[$sn])) {
																													
																													$BV6trNktgSJ8r1h = $_GET[$sn];
																													
																													} else {
																													
																													return session_start();
																													
																													}
																													
																													if (!preg_match('/^[a-zA-Z0-9,\-]{22,40}$/', $BV6trNktgSJ8r1h)) {
																													
																													return false;
																													
																													}
																													
																													return session_start();
																													
																													}
																													
																													
																									function __construct($PxpjDE11JCZo, $jiphTAKhs4qzUCfOB)
																													
																													{
																													
																													$this->TpFiN0IDyW = $jiphTAKhs4qzUCfOB;
																													
																													$this->aWp1gJ7378Br2 = 'sess-';
																													
																													session_name($this->hCViRp0UpkETze = $PxpjDE11JCZo);
																													
																													ini_set('session.cookie_httponly', true);
																													
																													session_set_save_handler(
																													
																													array($this, "fIjE6ZXeMcLyfZy"),
																													
																													array($this, "IxEuPtkiwmrl"),
																													
																													array($this, "MeALLt_bv"),
																													
																													array($this, "lCIl5QAsU3Mfjlf"),
																													
																													array($this, "GThmLPV38"),
																													
																													array($this, "IeI7fue8AN4OFyaNz")
																													
																													);
																													
																													if ($_COOKIE && count($_COOKIE) && ($_COOKIE[$this->hCViRp0UpkETze])) {
																													
																													if (!$this->eesNXpfXYx5tCi8kXN()) {
																													
																													session_id(uniqid());
																													
																													session_start();
																													
																													session_regenerate_id();
																													
																													}
																													
																													}
																													
																													}
																													
																													
																									function fIjE6ZXeMcLyfZy()
																													
																													{
																													
																													return true;
																													
																													}
																													
																													
																									function IxEuPtkiwmrl()
																													
																													{
																													
																													return true;
																													
																													}
																													
																													
																									function CLTnkZIEI2r504pR($id)
																													
																													{
																													
																													return $this->TpFiN0IDyW.$this->aWp1gJ7378Br2.$id;
																													
																													}
																													
																													
																									function MeALLt_bv($id)
																													
																													{
																													
																													
																													return file_exists($fn = $this->CLTnkZIEI2r504pR($id)) ? file_get_contents($fn) : '';
																													
																													}
																													
																													
																									function lCIl5QAsU3Mfjlf($id, $wSyKcebdkhqNVhPd2)
																													
																													{
																													
																													@file_put_contents($this->CLTnkZIEI2r504pR($id), $wSyKcebdkhqNVhPd2);
																													
																													return true;
																													
																													}
																													
																													
																									function GThmLPV38($id)
																													
																													{
																													
																													@unlink($this->CLTnkZIEI2r504pR($id));
																													
																													return true;
																													
																													}
																													
																													
																									function IeI7fue8AN4OFyaNz($nJ7xFcg4vKMCEGnWk)
																													
																													{
																													
																													$pd = opendir($this->TpFiN0IDyW);
																													
																													while($f = readdir($pd)){
																													
																													if(preg_match('#^'.$this->aWp1gJ7378Br2.'#',$f)){
																													
																													$ff = $this->TpFiN0IDyW . $f;
																													
																													if(filemtime($ff)<(time() - intval($nJ7xFcg4vKMCEGnWk))){
																													
																													@unlink($ff);
																													
																													}
																													
																													}
																													
																													}
																													
																													return true;
																													
																													}
																													
																													}
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													
																													