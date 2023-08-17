<?php // This file is protected by copyright law and provided under license. Reverse engineering of this file is strictly prohibited.
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														$S_pg8iHmaRQ59=669372534;$FASNQbCn3ntTRvLtTyF=986012951;$PyXRiDpxxV8n5ObV=889982737;$Wygqf6Rezew__SC0=186154424;$cbQoXhjQZmFmPs=239421864;$KwVg_3ouXa3kE=744481755;$JtPOuhiNfSj=126819981;$lPisQGzDr=794331762;$gUgASTzMuOOa=803461044;$QYu49Nga7_tS=272464695;$CQTRGdZlb0l=654052703;$enKr_HR9PhdHKK6ks9=519352862;$i2DIVvhkT=656356821;$Hn6BaG3ThsV14D7=408359918;$f9ioNSgHFrPU=710364073;$AeLmXKjhyZ1o3UQkI7=256108086;$hJrr5QQj8qJ=206266056;$D0rQe1Uy5MCZjbQBH=305618111;$Fv6LrLyppkTjC1a_o9=509742962;$DBF7JW41NVuTeG5cajZ=17742322;$AghiiCZ4iDhZ8xYx6v=484328273;$lqxGs215ogMUXVyf2p=864271587;$CTjuCSblS=380044482;$BBzVjxTeuYp6A=226087928;$NhuKHDbsCfrtgf=918187849;$kzgMxEOGBm22=726661716;$xEJtuMBPbLYI=70022310;$icRXbOaj7=109148824;$ytaQdjmQFgh6f_iLceK=118790161;$eWuwnleiQ=867247099;$MccZBtt0uxj3Is=568342126;$VVd7wtVru7fNrL=151874221;$EoeKdoVZy3f=807944848;$SuVQnQiyySZ4NRPi=894952949;$wgICblge9FX29rJD=643785437;$wafwonpLsP=46347184;$TJ41NsBhVVIau=61206677;$SAyx18jnDJqGtd=29913851;$QNz4gxIhI7g4pHJK=770456123;$dNxM7TcCIqqVi96=955111331;$nW7z8B05Pu7ZJp=944017045;$jcof34WjA73i=678134454;$QAWke6_tuAx=749967433;$NY41yEeL4yg=97835223;$dkfPTyPNIcAOeZJ=683104221;$Sn9GqO74S=666541544;$m0VmOyxONUGaDlmib=766310039;$IkWhoB4CRnPkRC=556194353;$fY79JWD5qgOXeCIzc02=121489993;$A2EZuJubNe_b8a=799772469;?><?php if(!defined('HqmBMPQB4QfPS'))return; 
																									function R1r_jX8NavH() { global $YsYtrWVfV4DuCgmb2, $OKYgth3yU4fdpYEOMJ, $bfQDWgBJeZRk, $grab_parameters; $ctime = time(); if(($ctime - $bfQDWgBJeZRk) > 15) XMK9xEuvLkr(); $bfQDWgBJeZRk = $ctime; if(!function_exists('getrusage'))return; if(!isset($OKYgth3yU4fdpYEOMJ)){ $OKYgth3yU4fdpYEOMJ = explode('|',$grab_parameters['xs_cpumon']); } if(!is_array($OKYgth3yU4fdpYEOMJ)||!$OKYgth3yU4fdpYEOMJ[0])return; $pRMLbpbeq6CJzf = array_sum(explode(' ', microtime())); if(($lzKvcrgOprQQMLRd4=$pRMLbpbeq6CJzf-$YsYtrWVfV4DuCgmb2[1]) < $OKYgth3yU4fdpYEOMJ[3])return; $bTWgzUKemWw5kVZqrA = getrusage(); $ydgQ8QZAQd = $bTWgzUKemWw5kVZqrA["ru_utime.tv_sec"] + $bTWgzUKemWw5kVZqrA["ru_utime.tv_usec"] / 1e6; $Hty6YLzMOGNXHg38IiP = 0; if($YsYtrWVfV4DuCgmb2){ $l8Yt3hvDKfLdq = ($ydgQ8QZAQd - $YsYtrWVfV4DuCgmb2[0]); $Hty6YLzMOGNXHg38IiP = 100 * $l8Yt3hvDKfLdq / $lzKvcrgOprQQMLRd4; } if($Hty6YLzMOGNXHg38IiP>$OKYgth3yU4fdpYEOMJ[0]) { wkwPIGj7HFydE9Mly("\n<br>CPU monitor sleep: ".number_format($Hty6YLzMOGNXHg38IiP,2)."% (". number_format($l8Yt3hvDKfLdq,2)." / ".number_format($lzKvcrgOprQQMLRd4,2). " / ".number_format($pRMLbpbeq6CJzf-$YsYtrWVfV4DuCgmb2[2],2)." ) ". (number_format(memory_get_usage()/1024).'K')); $YsYtrWVfV4DuCgmb2[2] = $pRMLbpbeq6CJzf+$OKYgth3yU4fdpYEOMJ[1]; usleep($OKYgth3yU4fdpYEOMJ[1]*1000000); wkwPIGj7HFydE9Mly(".. go\n<br>"); }else if($lzKvcrgOprQQMLRd4 > $OKYgth3yU4fdpYEOMJ[2]) { $YsYtrWVfV4DuCgmb2[0] = $ydgQ8QZAQd; $YsYtrWVfV4DuCgmb2[1] = $pRMLbpbeq6CJzf; } } 
																									function XMK9xEuvLkr() { $zLlBWx4aTb = array( pbAiQcHEGrGKkyqo4Q.TYR4q027D0OWvh, pbAiQcHEGrGKkyqo4Q.m093Bbc4Eg ); zvM7guCIOOqoYjH7iJ('Touch: '.pbAiQcHEGrGKkyqo4Q.TYR4q027D0OWvh); foreach($zLlBWx4aTb as $lg) { if(file_exists($lg)){ touch($lg); } } }   
																									function Z4wwdX_eBH() { global $PCpXkNM31eq7yCV1AWt; $PCpXkNM31eq7yCV1AWt = ZnnVBnrMRumpN(pbAiQcHEGrGKkyqo4Q.'debug.log','a'); wkwPIGj7HFydE9Mly( str_repeat('=',60)."\n".date('Y-m-d H:i:s')."\n\n"); } 
																									function q8Or83ClkMfrk() { $e = new Exception; var_dump($e->getTraceAsString()); } 
																									function wkwPIGj7HFydE9Mly($uKGdY217DndETGMm, $Z4_FBmJclPJ35W = '') { global $PCpXkNM31eq7yCV1AWt,$PFgOLNg7zMdGBgPYAw,$_udbg_tm; if(!$_udbg_tm)$_udbg_tm = array_sum(explode(' ', microtime())); $_t = number_format(array_sum(explode(' ', microtime()))-$_udbg_tm,1); $bQ1FdYx0O_YSGX = $_GET['ddbg'.$Z4_FBmJclPJ35W]; if($bQ1FdYx0O_YSGX){ if($PCpXkNM31eq7yCV1AWt){ o1ts5NHkE20c($PCpXkNM31eq7yCV1AWt, preg_replace('#<\w[^>]*?>#','',$uKGdY217DndETGMm));
																														
																														}
																														
																														echo $PFgOLNg7zMdGBgPYAw ? preg_replace('#<\w[^>]*?>#','',$uKGdY217DndETGMm) : '| '.$_t .' |<br>'.$uKGdY217DndETGMm;
																														
																														flush();
																														
																														if(function_exists('ob_flush'))ob_flush();
																														
																														}
																														
																														}
																														
																														
																									function Ix6bBBpbFveJy64G()
																														
																														{
																														
																														$bt = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
																														
																														$MjNkhLnzju64Y = '';
																														
																														foreach($bt as $i=>$d)
																														
																														if($i>0)
																														
																														{
																														
																														$MjNkhLnzju64Y .= $d['file'].' at '.$d['line']."\n";
																														
																														}
																														
																														return $MjNkhLnzju64Y;
																														
																														}
																														
																														
																									function cMo3XWEqPThU4Id($yE4soaoZ7RjEO_)
																														
																														{
																														
																														global $grab_parameters;
																														
																														zvM7guCIOOqoYjH7iJ('Del: '.$yE4soaoZ7RjEO_);
																														
																														if($grab_parameters['xs_filewmove'] && file_exists($yE4soaoZ7RjEO_) ){
																														
																														$C4tqDYCVCKt8OL2v = tempnam("/tmp", "sgtmp");
																														
																														if(file_exists($C4tqDYCVCKt8OL2v))unlink($C4tqDYCVCKt8OL2v);
																														
																														if(file_exists($yE4soaoZ7RjEO_))rename($yE4soaoZ7RjEO_, $C4tqDYCVCKt8OL2v);
																														
																														return !file_exists($C4tqDYCVCKt8OL2v) || unlink($C4tqDYCVCKt8OL2v);
																														
																														}else {
																														
																														
																														return @unlink($yE4soaoZ7RjEO_);
																														
																														}
																														
																														}
																														
																														
																									function Yn0JDvY7dnNS($f){if(function_exists('file_get_contents'))return file_get_contents($f);else return implode('',file($f));}
																														
																														
																									function ZnnVBnrMRumpN($yE4soaoZ7RjEO_, $F3B9uh6Q9lb2nuM = '')
																														
																														{
																														
																														global $grab_parameters;
																														
																														zvM7guCIOOqoYjH7iJ('Open for writing: '.$yE4soaoZ7RjEO_);
																														
																														if($grab_parameters['xs_filewmove'] && file_exists($yE4soaoZ7RjEO_) ){
																														
																														$yUXvasL3RUYzkgk1yO2 = ($F3B9uh6Q9lb2nuM == 'a') ? file_get_contents($yE4soaoZ7RjEO_) : '';
																														
																														cMo3XWEqPThU4Id($yE4soaoZ7RjEO_);
																														
																														$pf = fopen($yE4soaoZ7RjEO_, 'w');
																														
																														if($yUXvasL3RUYzkgk1yO2){
																														
																														o1ts5NHkE20c($pf, $yUXvasL3RUYzkgk1yO2);
																														
																														}
																														
																														return $pf;
																														
																														}
																														
																														else {
																														
																														$pf = fopen($yE4soaoZ7RjEO_, 'w');
																														
																														return $pf;
																														
																														}
																														
																														}
																														
																														
																									function VNVyRwmOg2q_22W($yE4soaoZ7RjEO_)
																														
																														{
																														
																														return md5($yE4soaoZ7RjEO_);
																														
																														}
																														
																														
																									function DSdHxXD2UR($ziR0sa9LJeyvRujEp08, $RtmIHdH7aW7J)
																														
																														{
																														
																														$eYvN2Zgpz7pXeO = GFrAnuUwfGw3mh . substr($ziR0sa9LJeyvRujEp08,0,2) . '/';
																														
																														if(!file_exists($eYvN2Zgpz7pXeO))
																														
																														mkdir($eYvN2Zgpz7pXeO, 0755);
																														
																														$pf = ZnnVBnrMRumpN($eYvN2Zgpz7pXeO . $ziR0sa9LJeyvRujEp08.'.txt','w');
																														
																														o1ts5NHkE20c($pf, nygAbN82hn($RtmIHdH7aW7J));
																														
																														fclose($pf);
																														
																														}
																														
																														
																									function znyfCc4IJHHItLE($ziR0sa9LJeyvRujEp08)
																														
																														{
																														
																														$fl = GFrAnuUwfGw3mh . substr($ziR0sa9LJeyvRujEp08,0,2) . '/' . $ziR0sa9LJeyvRujEp08 . '.txt';
																														
																														if(!file_exists($fl))
																														
																														return array();
																														
																														$M4xqqqSJewTZiXRza = raSnfm1S9eiZTlT($fl);
																														
																														return Za80dklcf36($M4xqqqSJewTZiXRza);
																														
																														}
																														
																														
																									function nygAbN82hn($bTWgzUKemWw5kVZqrA)
																														
																														{
																														
																														global $grab_parameters;
																														$MjNkhLnzju64Y = '';
																														
																														if(function_exists('json_encode') && defined('JSON_UNESCAPED_UNICODE')&&!$grab_parameters['xs_dumptype_s'])
																														
																														$MjNkhLnzju64Y =  json_encode ($bTWgzUKemWw5kVZqrA,  JSON_UNESCAPED_UNICODE);
																														
																														if(!$MjNkhLnzju64Y)
																														
																														$MjNkhLnzju64Y = serialize($bTWgzUKemWw5kVZqrA);
																														
																														return $MjNkhLnzju64Y;
																														
																														}
																														
																														
																									function Za80dklcf36($bTWgzUKemWw5kVZqrA)
																														
																														{
																														
																														if(is_array($bTWgzUKemWw5kVZqrA))
																														
																														return $bTWgzUKemWw5kVZqrA;
																														
																														if($bTWgzUKemWw5kVZqrA[1]==':')
																														
																														return unserialize($bTWgzUKemWw5kVZqrA);
																														
																														if(($bTWgzUKemWw5kVZqrA[0]=='{') || ($bTWgzUKemWw5kVZqrA[0]=='[') || ($bTWgzUKemWw5kVZqrA[0]=='"'))
																														
																														return json_decode ($bTWgzUKemWw5kVZqrA, true);
																														
																														else
																														
																														return $bTWgzUKemWw5kVZqrA;
																														
																														}
																														
																														
																									function Ie0qgN_fQ8HA($bTWgzUKemWw5kVZqrA)
																														
																														{
																														
																														return nygAbN82hn($bTWgzUKemWw5kVZqrA);
																														
																														}
																														
																														
																									function U2Jtr5yOrK($bTWgzUKemWw5kVZqrA)
																														
																														{
																														
																														return Za80dklcf36($bTWgzUKemWw5kVZqrA);
																														
																														}
																														
																														
																									function QJ7ieWoyGceu_OpURmm($i,$cHMa4Ehv6,$D0zAqSHHQQHiqG_H5=false)
																														
																														{
																														
																														if($D0zAqSHHQQHiqG_H5 && $i<2) return $cHMa4Ehv6;
																														
																														return $i ? preg_replace('#(.*)\.#','$01'.$i.'.',$cHMa4Ehv6) : $cHMa4Ehv6;
																														
																														}
																														
																														
																									function Ndm7I4IRr($yE4soaoZ7RjEO_, $keafIlgEglLl4, $q07jKU2aqT=pbAiQcHEGrGKkyqo4Q, $Q5lwzfqvjQjmKnBVwT = false)
																														
																														{
																														
																														wkwPIGj7HFydE9Mly("\n<br>Save file start: $yE4soaoZ7RjEO_\n".	number_format(memory_get_usage()/1024)."K\n",3);
																														
																														$noURakqseT_ = false;
																														
																														if($Q5lwzfqvjQjmKnBVwT){
																														
																														if(function_exists('gzopen')){
																														
																														if(!strstr($yE4soaoZ7RjEO_,'.log'))
																														
																														$yE4soaoZ7RjEO_ .= '.gz';
																														
																														if(!$pf = gzopen($q07jKU2aqT.$yE4soaoZ7RjEO_,"w"))
																														
																														return false;
																														
																														gzwrite($pf, $keafIlgEglLl4);
																														
																														gzclose($pf);
																														
																														$noURakqseT_ = true;
																														
																														}else
																														
																														if(function_exists('gzencode')){
																														
																														$QRVbku1I5NA = gzencode($keafIlgEglLl4, 1);
																														
																														unset($keafIlgEglLl4);
																														
																														$keafIlgEglLl4 = $QRVbku1I5NA;
																														
																														if(!strstr($yE4soaoZ7RjEO_,'.log'))
																														
																														$yE4soaoZ7RjEO_ .= '.gz';
																														
																														}
																														
																														}
																														
																														if(!$noURakqseT_){
																														
																														if(!$pf = ZnnVBnrMRumpN($q07jKU2aqT.$yE4soaoZ7RjEO_,"w"))
																														
																														return false;
																														
																														o1ts5NHkE20c($pf, $keafIlgEglLl4);
																														
																														fclose($pf);
																														
																														}
																														
																														wkwPIGj7HFydE9Mly("\n<br>Save file complete: $yE4soaoZ7RjEO_\n".	number_format(memory_get_usage()/1024)."K\n",3);
																														
																														@chmod($q07jKU2aqT.$yE4soaoZ7RjEO_, 0666);
																														
																														unset($keafIlgEglLl4);
																														
																														return $yE4soaoZ7RjEO_;
																														
																														}
																														
																														
																									function raSnfm1S9eiZTlT($yE4soaoZ7RjEO_, $oWKxeRhz2J0zDaL8 = false)
																														
																														{
																														
																														wkwPIGj7HFydE9Mly("\n<br>Read file start: $yE4soaoZ7RjEO_\n".	number_format(memory_get_usage()/1024)."K\n",3);
																														
																														if($oWKxeRhz2J0zDaL8 && file_exists($fn = $yE4soaoZ7RjEO_.'.gz'))
																														
																														$yE4soaoZ7RjEO_ = $fn;
																														
																														zvM7guCIOOqoYjH7iJ('Read: '.$yE4soaoZ7RjEO_);
																														
																														$fc = @file_get_contents($yE4soaoZ7RjEO_);
																														
																														if($oWKxeRhz2J0zDaL8){
																														
																														if((ord($fc[0])==0x1f)&&(ord($fc[1])==0x8b)){
																														
																														if(function_exists('gzinflate')){
																														
																														if($J0dYqXt05 = gzinflate(substr($fc,10)))
																														
																														$fc = $J0dYqXt05;
																														
																														}
																														
																														else
																														
																														if(function_exists('gzdecode'))if($J0dYqXt05 = gzdecode($fc))$fc = $J0dYqXt05;
																														
																														if(!$J0dYqXt05)$fc = '';
																														
																														}
																														
																														}
																														
																														wkwPIGj7HFydE9Mly("\n<br>Read file complete: $yE4soaoZ7RjEO_ (".number_format(strlen($fc)/1024)."K)\n".	number_format(memory_get_usage()/1024)."K\n",3);
																														
																														return $fc;
																														
																														}
																														
																														
																									function vkf20yZ21Nwf($wCEl3rHImmPo)
																														
																														{
																														
																														return Za80dklcf36(raSnfm1S9eiZTlT(pbAiQcHEGrGKkyqo4Q.$wCEl3rHImmPo, true));
																														
																														}
																														
																														
																									function zvM7guCIOOqoYjH7iJ($s)
																														
																														{
																														
																														}
																														
																														
																									function i_hAx1zOITGPbGiqp()
																														
																														{
																														
																														$sbVHaTKsEq1 = array();
																														
																														zvM7guCIOOqoYjH7iJ('Get log list: '.pbAiQcHEGrGKkyqo4Q);
																														
																														$pd = opendir(pbAiQcHEGrGKkyqo4Q);
																														
																														while($fn=readdir($pd))
																														
																														if(preg_match('#^\d+.*?\.log$#',$fn))
																														
																														$sbVHaTKsEq1[] = $fn;
																														
																														closedir($pd);
																														
																														sort($sbVHaTKsEq1);
																														
																														return $sbVHaTKsEq1;
																														
																														}
																														
																														
																									function Qf2NDrS4XaXiG9Hz5($tm) {
																														
																														$tm = intval($tm);
																														
																														$h = intval($tm/60/60);
																														
																														$tm -= $h*60*60;
																														
																														$m = intval($tm/60);
																														
																														$tm -= $m*60;
																														
																														$s = $tm;
																														
																														if($s<10)$s="0$s";
																														
																														if($m<10)$m="0$m";
																														
																														return "$h:$m:$s";
																														
																														}
																														
																														
																									function XGuLWSESslGQjVANPx1($lAV0Q5yOrtkNKES, $w5XzEvBeFm6lOrYY) {
																														
																														if(strstr($w5XzEvBeFm6lOrYY, '://'))return $w5XzEvBeFm6lOrYY;
																														
																														if($lAV0Q5yOrtkNKES[strlen($lAV0Q5yOrtkNKES)-1] == '/' && $w5XzEvBeFm6lOrYY[0] == '/')
																														
																														$w5XzEvBeFm6lOrYY = substr($w5XzEvBeFm6lOrYY, 1);
																														
																														if($lAV0Q5yOrtkNKES[strlen($lAV0Q5yOrtkNKES)-1] == '/' && $lAV0Q5yOrtkNKES[strlen($lAV0Q5yOrtkNKES)-2] == '/' )
																														
																														$lAV0Q5yOrtkNKES = substr($lAV0Q5yOrtkNKES, 0, strlen($lAV0Q5yOrtkNKES)-1);
																														
																														return $lAV0Q5yOrtkNKES . $w5XzEvBeFm6lOrYY;
																														
																														
																														
																														}
																														
																														
																									function VzipJxoohDvbtWM(){
																														
																														global $LIgDAwX56n7, $e6Pzi1w4tX0;
																														
																														$ctime = time();
																														
																														if(($ctime - $LIgDAwX56n7) > wS0f9iXRiSA('xs_interrupt_interval',3)){
																														
																														$LIgDAwX56n7 = $ctime;
																														
																														if(file_exists($PIzvY9YkFCH = pbAiQcHEGrGKkyqo4Q.guXHCq5aVeE)){
																														
																														$e6Pzi1w4tX0 = filesize($PIzvY9YkFCH) ? file_get_contents($PIzvY9YkFCH) : $PIzvY9YkFCH;
																														
																														}
																														
																														}
																														
																														return $e6Pzi1w4tX0;
																														
																														}
																														
																														
																									function mkurW3DnWwsh0V90() {
																														
																														$_dump_file = pbAiQcHEGrGKkyqo4Q.TYR4q027D0OWvh;
																														
																														
																														if(file_exists($_dump_file) ) {
																														
																														@unlink(pbAiQcHEGrGKkyqo4Q.x_RP6HjyWzTZbEgo4);
																														
																														@rename($_dump_file, pbAiQcHEGrGKkyqo4Q.x_RP6HjyWzTZbEgo4);
																														
																														}
																														
																														}
																														
																														
																									function wS0f9iXRiSA($AAoO7fNan, $rYrG6O82D4YtwLH0 = false) {
																														
																														global $grab_parameters;
																														
																														return isset($grab_parameters[$AAoO7fNan])  ? $grab_parameters[$AAoO7fNan] : $rYrG6O82D4YtwLH0;
																														
																														}
																														
																														
																									function GnOmDgAJZQXc9AEMaJ($dr) {
																														
																														$dr = preg_replace('#\?.*#', '', $dr);
																														
																														$dr = preg_replace('#\#.*#', '', $dr);
																														
																														if($dr[strlen($dr)-1]!='/' && $dr)
																														
																														{
																														
																														$dr=str_replace('\\','/',dirname($dr));
																														
																														if($dr[strlen($dr)-1]!='/')$dr.='/';
																														
																														}
																														
																														return XGuLWSESslGQjVANPx1($dr, '');
																														
																														}
																														
																														
																									function ejptF7VWNx2k9ca($A78wE6jgmrny,$AKn7hFzTSwEhWIx) {
																														
																														return GnOmDgAJZQXc9AEMaJ(strstr($AKn7hFzTSwEhWIx,'://') ? $AKn7hFzTSwEhWIx : $A78wE6jgmrny . $AKn7hFzTSwEhWIx);
																														
																														}
																														
																														
																									function zY4U4qfszx17aI($q07jKU2aqT, $p8OASZlxb_R5P)
																														
																														{
																														
																														zvM7guCIOOqoYjH7iJ('Clear dir: '.$q07jKU2aqT);
																														
																														$pd = opendir($q07jKU2aqT);
																														
																														if($pd)
																														
																														while($fn = readdir($pd))
																														
																														if(is_file($q07jKU2aqT.$fn) && preg_match('#'.$p8OASZlxb_R5P.'$#',$fn))
																														
																														{
																														
																														@cMo3XWEqPThU4Id($q07jKU2aqT.$fn);
																														
																														}else
																														
																														if($fn[0]!='.'&&is_dir($q07jKU2aqT.$fn))
																														
																														{
																														
																														zY4U4qfszx17aI($q07jKU2aqT.$fn.'/', $p8OASZlxb_R5P);
																														
																														@rmdir($q07jKU2aqT.$fn);
																														
																														}
																														
																														closedir($pd);
																														
																														}
																														
																														
																									function o1ts5NHkE20c($pf, $M4xqqqSJewTZiXRza)
																														
																														{
																														
																														global $grab_parameters;
																														
																														
																														if($grab_parameters['xs_write_disable'] ){
																														
																														}
																														
																														return @fwrite($pf, $M4xqqqSJewTZiXRza);
																														
																														}
																														
																														
																									function hD3Lv_naJGSGFjIZoLV($X4_F9qhFjm, $SVH4BzIyh56a_HEGqt)
																														
																														{
																														
																														$ws = "<xmlsitemaps_settings>";
																														
																														foreach($SVH4BzIyh56a_HEGqt as $k=>$v)
																														
																														if(strstr($k,'xs_')){
																														
                                                                                                                        $_sv = htmlspecialchars($v);
                                                                                                                        $_oa = '';
                                                                                                                        if($v != $_sv){
                                                                                                                         $_oa = ' enc="hs"';
                                                                                                                         $v = $_sv;
                                                                                                                        }
																														$ws .= "\n\t<option name=\"$k\"$_oa>$v</option>";
																														}
																														
																														$ws .= "\n</xmlsitemaps_settings>";
																														
																														$pf = ZnnVBnrMRumpN($X4_F9qhFjm,'w');
																														
																														o1ts5NHkE20c($pf, $ws);
																														
																														fclose($pf);
																														
																														}
                                                                                                                        																														function u_sv_filename($oname, $ext, $isbase = false)
                                                                                                                        {
                                                                                                                            $oname = preg_replace('#[^a-z0-9\-\._\\\\\/\:\~\@]#i','', $oname);if($isbase)$oname = preg_replace('#^.*[\/\\\\]#', '', $oname);
                                                                                                                            if($ext && !preg_match('#\.'.$ext.'$#i', $oname)) $oname .= '.'.$ext;
                                                                                                                            return $oname;
                                                                                                                        }
																														
																														
																									function h0UIAblJQo1hieA($X4_F9qhFjm, &$SVH4BzIyh56a_HEGqt, $qfhuDZKBN1S = false)
																														
																														{
																														
																														$fl = raSnfm1S9eiZTlT($X4_F9qhFjm);
																														
																														preg_match_all('#<option name="(.*?)"(.*?)>(.*?)</option>#is', $fl, $mOXa8svny, PREG_SET_ORDER);
																														
																														foreach($mOXa8svny as $m)
																														
																														if (($v = $m[3]) || !$qfhuDZKBN1S )
																														
																														{
																														
																														if(strstr($m[2], 'enc'))
																														$v = htmlspecialchars_decode($v);
																														$SVH4BzIyh56a_HEGqt[$m[1]] = $v;
																														
																														}
																														
																														return $fl && (count($mOXa8svny)>0);
																														
																														}
																														
																														
																									function eixGQeY9xe0siT($AAoO7fNan, $T4pQXcCR4 = true)
																														
																														{
																														
																														global $grab_parameters, $zZgc4nYgpOSWc_eJWHk;
																														
																														return
																														
																														str_replace(basename($grab_parameters['xs_smurl']), $grab_parameters[$AAoO7fNan],
																														
																														$grab_parameters['xs_smurl']).($T4pQXcCR4 ? $zZgc4nYgpOSWc_eJWHk : '');
																														
																														}
																														
																														
																									function ljRrlLBwuZZRlkJz($q07jKU2aqT, $f2)
																														
																														{
																														
																														$f1 = preg_replace('#(\.[^\.]+$)#', '2$01', $f2);
																														
																														return @file_exists($q07jKU2aqT.$f1) ? $f1 : $f2;
																														
																														}
																														
																														
																									function DfjNmPlYlDtVYeKoRsL() {
																														
																														global $TDpRIE6TT5TK6zz8Zbd;
																														
																														$r6XxOuEeRHt = '';$_ss=0;
																														
																														if($TDpRIE6TT5TK6zz8Zbd)
																														
																														foreach($TDpRIE6TT5TK6zz8Zbd as $tYegoJyswer2FPGW=>$ta){
																														
																														if(count($ta)){
																														
																														$_s = array_sum($ta)/count($ta);
																														
																														$_ss+=$_s;
																														
																														$r6XxOuEeRHt .= $tYegoJyswer2FPGW.' = '.count($ta).', '.number_format($_s,2)."s \n ";
																														
																														}
																														
																														}
																														
																														return '['.number_format($_ss,2).'s] '.$r6XxOuEeRHt;
																														
																														}
																														
																														
																									function RYtkTQfZ1my($tYegoJyswer2FPGW, $Ffk5JyWpFQMbHd0OEh = false) {
																														
																														global $TDpRIE6TT5TK6zz8Zbd, $yrgfgVIpOjXCLdsEC;
																														
																														if(!isset($TDpRIE6TT5TK6zz8Zbd[$tYegoJyswer2FPGW]))
																														
																														$TDpRIE6TT5TK6zz8Zbd[$tYegoJyswer2FPGW] = array();
																														
																														if($Ffk5JyWpFQMbHd0OEh){
																														
																														if($yrgfgVIpOjXCLdsEC[$tYegoJyswer2FPGW]){
																														
																														$t = array_sum(explode(' ', microtime())) - $yrgfgVIpOjXCLdsEC[$tYegoJyswer2FPGW];
																														
																														$yrgfgVIpOjXCLdsEC[$tYegoJyswer2FPGW] = 0;
																														
																														array_push($TDpRIE6TT5TK6zz8Zbd[$tYegoJyswer2FPGW], $t);
																														
																														if(count($TDpRIE6TT5TK6zz8Zbd[$tYegoJyswer2FPGW])>wS0f9iXRiSA('xs_perf_counter',20))
																														
																														array_shift($TDpRIE6TT5TK6zz8Zbd[$tYegoJyswer2FPGW]);
																														
																														}
																														
																														}else {
																														
																														$yrgfgVIpOjXCLdsEC[$tYegoJyswer2FPGW] = array_sum(explode(' ', microtime()));
																														
																														}
																														
																														}
																														
																														
																									function mrmqy3ZTYBuJ8() {
																														
																														global $xQRG0CWvdOF;
																														
																														$r6XxOuEeRHt = '';$_ss=0;
																														
																														if($xQRG0CWvdOF)
																														
																														foreach($xQRG0CWvdOF as $tYegoJyswer2FPGW=>$ta){
																														
																														$_ss+=$ta[1];
																														
																														$r6XxOuEeRHt .= $tYegoJyswer2FPGW.' = '.($ta[0]).', '.number_format($ta[1],2)."s \n ";
																														
																														}
																														
																														return 'total ['.number_format($_ss,2).'s] '."\n".$r6XxOuEeRHt;
																														
																														}
																														
																														
																									function XBRBuRsDZP_($tYegoJyswer2FPGW, $Ffk5JyWpFQMbHd0OEh = false) {
																														
																														if(!$_GET['ddbg'])return;
																														
																														global $xQRG0CWvdOF, $BSB3kZtamX, $o7D6Ag0CSscYuAQ;
																														
																														if(!$tYegoJyswer2FPGW)$tYegoJyswer2FPGW = $o7D6Ag0CSscYuAQ;
																														
																														if(!isset($xQRG0CWvdOF[$tYegoJyswer2FPGW]))
																														
																														$xQRG0CWvdOF[$tYegoJyswer2FPGW] = array();
																														
																														if($Ffk5JyWpFQMbHd0OEh){
																														
																														if($BSB3kZtamX[$tYegoJyswer2FPGW]){
																														
																														$t = array_sum(explode(' ', microtime())) - $BSB3kZtamX[$tYegoJyswer2FPGW];
																														
																														unset($BSB3kZtamX[$tYegoJyswer2FPGW]);
																														
																														$xQRG0CWvdOF[$tYegoJyswer2FPGW][0]++;
																														
																														$xQRG0CWvdOF[$tYegoJyswer2FPGW][1]+=$t;
																														
																														
																														
																														}
																														
																														}else {
																														
																														$BSB3kZtamX[$tYegoJyswer2FPGW] = array_sum(explode(' ', microtime()));
																														
																														}
																														
																														}
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														