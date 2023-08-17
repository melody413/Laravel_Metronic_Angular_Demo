<?php // This file is protected by copyright law and provided under license. Reverse engineering of this file is strictly prohibited.
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														$bwmUtTVtiQvt=639312055;$iqDJNyNOos=29800405;$k_ipyf_LnyT=770806814;$UuxisysyIwIBtcrF8_S=267470892;$TUMsBIQyQKN7eB=285920652;$C7X2KIEj2QaqfASD=180185974;$w6Y27OXGAyoNZm_S=857023444;$sgbORDBY4l98Z=799120398;$yNduR8BF8RA6cW_=847530844;$OhNxDEOYGTS4QSLY5=119176682;$Y4BWtoT8Ulj3in=333566258;$WgcUCygBRsA=175864908;$kqQJFH6u8iJQZzYlpJf=53585319;$hNWUkh7f_cQsi=133091389;$hRCoQG3iwTh=65228520;$E4aOmdmJDpZdRd=806401463;$Pzgiw57Fogsi_Lb=146304344;$FRaJ3sPxBf_m46Wt=510138736;$nY1IwE5Gizs3lS=603147217;$HuBZoV1Hw=860697311;$oZ8ufBQDlHVpUB7Wfo=829301706;$qahF6n_FbQ9NorFUV=250921909;$pIMsm4b3Y3bXByxcJ=589563852;$aJrHknplYSEdrgtraN=906880551;$ifFKJU6uXyNNP=602401368;$V8SOOq8gPBOfGkBqqy=854338358;$YAgVRtpT5=342734024;$L7MVAm5pG=370268577;$SZSk34MH8oi=222966904;$gSqee1FW8YVFsD=351904807;$VppJpXqWZcRbDC=27535439;$cp68fV2DWC3Hja4vmcn=297625912;$g0GRIqyYwOX=901453229;$rs3mWHezjoCDNECOdA=141785009;$I3QxjYWsYg=52801158;$OlKHSsqK2Vv7alL5=750314542;$c8pNX8EHA7JhHT=90659743;$aNLwpD8zRgufA3L=902614387;$SuO02r9_IJP_OX0Z=72941384;$udEctN1efX7SJFb4GIt=462763026;$Dx4lBFtu4=294360417;$zytKI1VEd8sP=888034706;$ts0qZ7fFgmmj7lFnXGk=79645677;$jcbaIWD1OwhUyy8cKEv=422312245;$SYjkVnZCDilf0DPTOQ=582522296;$XGxjMMRnrl=438727612;$PGAfpJbHhBpOVGIqz=511738309;$dYl9q2NpwhTEDGEeiXh=964758320;$fWsC3inXFph79ui=16979057;$uBP0Ttynaw__4bA=395857253;?><?php if(!defined('HqmBMPQB4QfPS'))return;include plQDGddmmXu9xZB.'page-top.inc.php'; $mH9xDZdG24h = $_REQUEST['crawl']; if($_GET['act']=='interrupt'){ Ndm7I4IRr(guXHCq5aVeE,''); echo '<h2>The "stop" signal has been sent to a crawler.</h2>'; }else if(file_exists($fn=pbAiQcHEGrGKkyqo4Q.m093Bbc4Eg)&&(time()-filemtime($fn)<10*60)){ $UQnrRfuME=true; $mH9xDZdG24h = 1; } if($mH9xDZdG24h){ ?>
																														<div id="maincont">
																														<?php if($UQnrRfuME) echo '<h4>Crawling already in progress.<br/>Last log access time: '.date('Y-m-d H:i:s',@filemtime($fn)).'<br><small><a href="index.'.$AdhM211IF7voW.'?op=crawl&act=interrupt">Click here</a> to interrupt it.</small></h4>'; else { echo '<h4>Please wait. Sitemap generation in progress...</h4>'; if($_POST['bg']) echo '<div class="block2head">Please note! The script will run in the background until completion, even if browser window is closed.</div>'; } ?>
																														<script type="text/javascript">
																														var lastupdate = 0;
																														var framegotsome = false;
																														
																									function onoQiUUTV()
																														{
																														var cd = new Date();
																														if(!lastupdate)return false;
																														var df = (cd - lastupdate)/1000;
																														<?php if($grab_parameters['xs_autoresume']){?>
																														var re = document.getElementById('rlog');
																														re.innerHTML = 'Auto-restart monitoring: '+ cd + ' (' + Math.round(df) + ' second(s) since last update)';
																														var ifr = document.getElementById('cproc');
																														var frfr = window.frames['clog'];
																														
																														var doresume = (df >= <?php echo intval($grab_parameters['xs_autoresume']);?>);
																														if(typeof frfr != 'undefined') {
																														if( (typeof frfr.pageLoadCompleted != 'undefined') &&
																														!frfr.pageLoadCompleted)
																														{
																														
																														framegotsome = true;
																														doresume = false;
																														}
																														
																														if(!frfr.document.getElementById('glog')) {
																														
																														}
																														}
																														if(doresume)
																														{
																														var rle = document.getElementById('runlog');
																														lastupdate = cd;
																														if(rle)
																														{
																														rle.style.display  = '';
																														rle.innerHTML = cd + ': resuming generator ('+Math.round(df)+' seconds with no response)<br />' + rle.innerHTML;
																														}
																														var lc = ifr.src;
																														lc = lc.replace(/resume=\d*/,'resume=1')
																														lc = lc.replace(/seed=[\d\.]*/,'seed='+Math.random())
																														
																														ifr.src = lc;
																														}
																														<?php } ?>
																														}
																														window.setInterval('onoQiUUTV()', 1000);
																														</script>
																														<iframe id="cproc" name="clog" style="width:100%;height:300px;border:0px" frameborder=0 src="index.<?php echo $AdhM211IF7voW?>?op=crawlproc&bg=<?php echo $_REQUEST['bg']?>&resume=<?php echo $_REQUEST['resume']?>&seed=<?php echo rand(1E8,1E9);?>"></iframe>
																														<!--
																														<div id="rlog2" style="bottom:5px;position:fixed;width:100%;font-size:12px;background-color:#fff;z-index:2000;padding-top:5px;border-top:#999 1px dotted"></div>
																														-->
																														<div id="rlog" style="overflow:auto;"></div>
																														<div id="runlog" style="overflow:auto;height:100px;display:none;"></div>
																														</div>
																														<?php }else if(!$l01jRFDKtWtW) { ?>
																														<div id="sidenote">
																														<?php include plQDGddmmXu9xZB.'page-sitemap-detail.inc.php'; ?>
																														</div>
																														<div id="shifted">
																														<h2><i class="material-icons inline-icon">autorenew</i>  Create Sitemap</h2>
																														<form action="index.<?php echo $AdhM211IF7voW?>?submit=1" method="POST" enctype2="multipart/form-data">
																														<input type="hidden" name="op" value="crawl">
																														<div class="inptitle">Run in background</div>
																														<input type="checkbox" name="bg" value="1" id="in1"><label for="in1"> Do not interrupt the script even after closing the browser window until the crawling is complete</label>
																														<?php if(@file_exists(pbAiQcHEGrGKkyqo4Q.TYR4q027D0OWvh)){ if(@file_exists(pbAiQcHEGrGKkyqo4Q.crI8G26xJzM) &&(filemtime(pbAiQcHEGrGKkyqo4Q.crI8G26xJzM)>filemtime(pbAiQcHEGrGKkyqo4Q.TYR4q027D0OWvh)) ){ $GPOoHO73PfAv = @U2Jtr5yOrK(raSnfm1S9eiZTlT(pbAiQcHEGrGKkyqo4Q.crI8G26xJzM, true)); } if(!$GPOoHO73PfAv){ $mFUcZxJGA4itwRbJ = @U2Jtr5yOrK(raSnfm1S9eiZTlT(pbAiQcHEGrGKkyqo4Q.TYR4q027D0OWvh, true)); $GPOoHO73PfAv = $mFUcZxJGA4itwRbJ['progpar']; } ?>
																														<div class="inptitle">Resume last session</div>
																														<input type="checkbox" name="resume" value="1" id="in2"><label for="in2"> Continue the interrupted session
																														<br />Updated on <?php $JCX7szygGJHpwpKh = filemtime(pbAiQcHEGrGKkyqo4Q.TYR4q027D0OWvh); echo date('Y-m-d H:i:s',$JCX7szygGJHpwpKh); if(time()-$JCX7szygGJHpwpKh<600)echo ' ('.(time()-$JCX7szygGJHpwpKh).' seconds ago) '; ?>,
																														<?php echo	'Time elapsed: '.Qf2NDrS4XaXiG9Hz5($GPOoHO73PfAv[0]).',<br />Pages crawled: '.intval($GPOoHO73PfAv[3]). ' ('.intval($GPOoHO73PfAv[7]).' added in sitemap), '. 'Queued: '.$GPOoHO73PfAv[2].', Depth level: '.$GPOoHO73PfAv[5]. '<br />Current page: '.$GPOoHO73PfAv[1].' ('.number_format($GPOoHO73PfAv[10],1).')'; } ?>
																														</label>
																														<div class="inptitle">Click button below to start crawl manually:</div>
																														<div class="inptitle">
																														<input class="button" type="submit" name="crawl" value="Start Creating Sitemap">
																														</div>
																														</form>
																														<h2>Cron job setup</h2>
																														You can use the following command line to setup the cron job for sitemap generator:
																														<div class="inptitle">/usr/bin/php <?php echo dirname(dirname(__FILE__)).'/runcrawl.php'?></div>
																														<h2>Web Cron setup</h2>
																														If you cannot setup a regular cron task on your server, you can try a web cron instead:
																														<div class="inptitle"><?php 	echo $wfIIHtYqT4pr.'/index.php?op=crawlproc&resume=1'?></div>
																														</div>
																														<?php } include plQDGddmmXu9xZB.'page-bottom.inc.php'; 
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														
																														