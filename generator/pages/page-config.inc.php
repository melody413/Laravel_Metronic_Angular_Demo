<?php // This file is protected by copyright law and provided under license. Reverse engineering of this file is strictly prohibited.
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									$zZ8upkuCo6Tbl=849969635;$qnWJfI0QqrTmp3k0T=691191093;$DcXBJQ0yFdgv8zSNu=564100242;$r8ka5bqf8=507673679;$eke129NLDmNqfnr=772019675;$W0jBIHTdsd=630747889;$YcE52sPOAuzu0hRiE=869012413;$tYLn1pc5AhSOp2H5EwK=364331260;$xU0vazYNInVEWnTGmo=111810392;$nawtmIPqvy99mRVuSx=867683097;$KMTWCu9VbevpXVl=660016663;$yTrXDQyo_btA6559id=156044037;$AjuCa4v287Lh5F=711408508;$xV9CqRpRDkUiouIf=360777471;$dHnJM_BbSUBauHQD=297956368;$W9aQIUkpqh0pn7GKh=262452773;$QJz8NtqwS1=667167978;$bZKymdgBE4j8hBw4Nf=199843028;$knWJj693GEI1yHjhuhN=154180565;$wdABcEKQP4CbTlnD8=540475775;$IJVwpTjQMO3iGNAipYc=448530434;$xZN3JaYOj=681483380;$LqJcLVBvBs=723708981;$rsnmtcd9ievMD7=553886283;$Fo3VBZWxSN2X=463176116;$FuDFUnyKQpkgTSF=464702509;$SEpk0edEE=456053229;$bpUgrkjYXop37=242418027;$I7gCjRUBrba53Bae6=143450775;$WIxkfsh_CQR2=635434077;$Zg9jI9dMMSOu1aTo8=761544383;$SML7GEBdEqtINT1=736606027;$flZkerMZXY=966522156;$PYuNaqYvWlYOm7CW=147771707;$NQwQRuTPgETpzYI=158879044;$wyBes2afqjj0ob=179592806;$w9jV0FDAIdG_jx=208178571;$kdOPz05sFj=930763399;$PIMBvacmgDrcx9=397221726;$oTuvPex6vjSQAA=86377844;$zQJs14_wATOV=383896250;$t0_8qeeoN9ugco=563443570;$T4OAfgwLJaz=368265627;$pH_AicG887dN7qZ=921364794;$Iz7ZiGNAK1C=692704999;$yliGD9qTQlc=681439379;$yIRFxw3vOX=367312974;$pWfiqYJ7Yv=564005564;$gX5f71p1vniQ=662055769;$p_ymOTXr01=607640795;?><?php if(!defined('HqmBMPQB4QfPS'))return;if(!defined('cgB1TBw9vbUx'))exit(); $ezWktjge8ufdauNMri = $otwBPs6XvlOVi2 = ''; if($grab_parameters['xs_is_demo']) $otwBPs6XvlOVi2 = 'Settings cannot be changed in this DEMO instance.'; if(!is_writable(pbAiQcHEGrGKkyqo4Q)){ $ezWktjge8ufdauNMri .= '<br>Datastorage folder is not writable: <b>'.pbAiQcHEGrGKkyqo4Q.'</b>'; }else if(file_exists(SR9aofkxi4) && !is_writable(SR9aofkxi4)){ $otwBPs6XvlOVi2 .= '<br>Configuration file is not writable: <b>'.SR9aofkxi4.'</b>'; }   $token = $_COOKIE["configtkn"];if(!$grab_parameters['xs_is_demo'] && isset($_POST['save']) && is_writable(SR9aofkxi4)){ 
                                                                                            		if( !$token || ($_POST["tkn"] !== $_COOKIE["configtkn"]))
                                                                                            		{
                                                                                            			$ezWktjge8ufdauNMri = 'Form token is incorrect, please try again';
                                                                                            		}
                                                                                            		else
                                                                                            		{
																									$grab_parameters['xs_initurl'] = trim($_POST['initurl']); $grab_parameters['xs_freq'] = $_POST['freq']; $grab_parameters['xs_lastmod'] = $_POST['lastmod']; $grab_parameters['xs_lastmodtime'] = $_POST['lastmodtime']; $grab_parameters['xs_priority'] = $_POST['priority']; $grab_parameters['xs_autopriority'] = $_POST['autopriority']?1:0; $grab_parameters['xs_max_pages'] = $_POST['max_pages']; $grab_parameters['xs_max_depth'] = $_POST['max_depth']; $grab_parameters['xs_exec_time'] = $_POST['exec_time']; $grab_parameters['xs_memlimit'] = $_POST['mem_limit']; $grab_parameters['xs_savestate_time'] = $_POST['savestate_time']; $grab_parameters['xs_delay_req'] = $_POST['delay_req']; $grab_parameters['xs_delay_ms'] = $_POST['delay_ms']; $grab_parameters['xs_yping'] = $_POST['OJ8k_fcCmhQXS2XxF']; $grab_parameters['xs_smname'] = u_sv_filename($_POST['smname'],'xml'); $grab_parameters['xs_excl_urls'] = $_POST['excl_urls']; $grab_parameters['xs_incl_urls'] = $_POST['incl_urls']; $grab_parameters['xs_noincl_urls'] = $_POST['noincl_urls']; $grab_parameters['xs_incl_only'] = $_POST['incl_only']; $grab_parameters['xs_parse_only'] = $_POST['parse_only']; $grab_parameters['xs_ind_attr'] = $_POST['ind_attr']; $grab_parameters['xs_smurl'] = $_POST['smurl']; if($_POST['changepass']) { $grab_parameters['xs_login'] = trim($_POST['xslogin']); if($_POST['xspassword']!='-----') { $grab_parameters['xs_password'] = trim($_POST['xspassword']) ? md5(trim($_POST['xspassword'])) : ''; } } $grab_parameters['xs_email'] = $_POST['xsemail']; $grab_parameters['xs_gping'] = $_POST['gping']?1:0; $grab_parameters['xs_chlog'] = $_POST['gchlog']?1:0; $grab_parameters['xs_extlinks'] = $_POST['extlinks']?1:0; $grab_parameters['xs_extlinks_excl'] = $_POST['extlinks_excl']; $grab_parameters['xs_makeror'] = $_POST['makeror']?1:0; $grab_parameters['xs_maketxt'] = $_POST['maketxt']?1:0; if($sm_proc_list) foreach($sm_proc_list as $fCFbByTRhrlRf0Mvv) { $grab_parameters[$fCFbByTRhrlRf0Mvv->ef04NXRrsB_tUwyvJL] = $_POST[$fCFbByTRhrlRf0Mvv->ef04NXRrsB_tUwyvJL]?1:0; if($fCFbByTRhrlRf0Mvv->ef04NXRrsB_tUwyvJL) $grab_parameters[$fCFbByTRhrlRf0Mvv->AyzHK7HwV2rWNLOaTr] = $_POST[$fCFbByTRhrlRf0Mvv->AyzHK7HwV2rWNLOaTr]; } $grab_parameters['xs_webinfo'] = $_POST['webinfo']?1:0; $grab_parameters['xs_makehtml'] = $_POST['makehtml']?1:0; $grab_parameters['xs_htmlname'] = u_sv_filename($_POST['htmlname'],'html'); $grab_parameters['xs_htmlpart'] = $_POST['htmlpart']; $grab_parameters['xs_htmlsort'] = $_POST['htmlsort']; $grab_parameters['xs_htmlstruct'] = $_POST['htmlstruct'];     $grab_parameters['xs_makemob'] = $_POST['makemob']?1:0; if($_POST['makemob']) { $grab_parameters['xs_mobilefilename'] = u_sv_filename($_POST['mobilefilename'],'xml',true); $grab_parameters['xs_mobileincmask'] = $_POST['mobileincmask']; } $grab_parameters['xs_sm_size'] = $_POST['sm_size']; $grab_parameters['xs_sm_filesize'] = $_POST['sm_filesize']; $grab_parameters['xs_purgelogs'] = $_POST['purge']; $grab_parameters['xs_autoresume'] = $_POST['autoresume']; $grab_parameters['xs_ref_list_store'] = $_POST['ref_list_store']; $grab_parameters['xs_maxref'] = $_POST['maxref']; $grab_parameters['xs_no_cookies'] = $_POST['cookies']?0:1; $grab_parameters['xs_compress'] = intval($_POST['compress']) ; $grab_parameters['xs_usecurl'] = $_POST['usecurl']?1:0; $grab_parameters['xs_memsave'] = $_POST['memsave']?1:0; $grab_parameters['xs_inc_skip'] = '\.('.preg_replace('#\s+#','|',trim($_POST['incl'])).')'; $grab_parameters['xs_exc_skip'] = '\.('.preg_replace('#\s+#','|',trim($_POST['excl'])).')'; $grab_parameters['xs_ipconnection'] = $_POST['serveripaddr']; $grab_parameters['xs_angroups'] = $_POST['angroups']; $grab_parameters['xs_moreurls'] = $_POST['moreurls']; $grab_parameters['xs_allow_subdomains'] = $_POST['allow_subdomains']?1:0; $grab_parameters['xs_cleanpar'] = preg_replace('#\s+#','|',trim($_POST['cleanpar'])); $grab_parameters['xs_canonical'] = $_POST['canonical']?1:0; $grab_parameters['xs_checkver'] = $_POST['checkver']?1:0; $grab_parameters['xs_disable_xsl'] = $_POST['xslon']?0:1; $grab_parameters['xs_nobrand'] = $_POST['nobrand']?1:0; $grab_parameters['xs_robotstxt'] = $_POST['robotson']?1:0; $grab_parameters['xs_hreflang'] = $_POST['hreflang']?1:0; $grab_parameters['xs_alt_lang'] = $_POST['alt_lang']; $grab_parameters['xs_utf8'] = $_POST['xsutf'] ? 1 : 0; $grab_parameters['xs_inc_ajax'] = $_POST['xsajax'] ? 1 : 0; $grab_parameters['xs_lastmod_notparsed'] = $_POST['lmnp']?1:0; $grab_parameters['xs_debug'] = $_POST['dbg']?1:0; $grab_parameters['xs_http_language'] = $_POST['http_language']; hD3Lv_naJGSGFjIZoLV(SR9aofkxi4, $grab_parameters); $otwBPs6XvlOVi2 = 'Configuration has been saved'; $configsaved = true;}} 	if(!$configsaved){$token = md5(rand(1E6,1E8));setcookie("configtkn", $token, time() + 60 * 60 * 24);} $sbVHaTKsEq1 = i_hAx1zOITGPbGiqp(); if(count($sbVHaTKsEq1)>0){ $wCEl3rHImmPo = array_pop($sbVHaTKsEq1); $Vw1UiQ2aZ = vkf20yZ21Nwf($wCEl3rHImmPo); } $cHMa4Ehv6 = $grab_parameters['xs_smname']; $JyepEyNGkQPx = ($grab_parameters['xs_compress']==1) ? '.gz' : ''; $RAbY3D8m71TlL = array(basename($grab_parameters['xs_smname']));     if($grab_parameters['xs_makemob'])$RAbY3D8m71TlL[] = $grab_parameters['xs_mobilefilename']; $PmLS3l9Qi9s4_B = dirname($grab_parameters['xs_smname']); foreach($RAbY3D8m71TlL as $_smf){ $fdLpmJ7308fYDLhyK = $PmLS3l9Qi9s4_B . '/'.$_smf; if(!@is_writable($fdLpmJ7308fYDLhyK) && !(@is_writable(dirname($fdLpmJ7308fYDLhyK)) && !file_exists($fdLpmJ7308fYDLhyK) ) ) { $ezWktjge8ufdauNMri .= '<br>Sitemap file is not writable: <b>'.$fdLpmJ7308fYDLhyK.'</b>'; } } $durGzKjqcdDWuBhr = $grab_parameters['xs_sm_size'] ? $grab_parameters['xs_sm_size'] : 50000; for($i=0;$i<ceil($Vw1UiQ2aZ['ucount']/$durGzKjqcdDWuBhr);$i++) { $fdLpmJ7308fYDLhyK = (($Vw1UiQ2aZ['ucount']>$durGzKjqcdDWuBhr) ? QJ7ieWoyGceu_OpURmm($i+1,$cHMa4Ehv6):$cHMa4Ehv6).$JyepEyNGkQPx; if(!@is_writable($fdLpmJ7308fYDLhyK) && !(@is_writable(dirname($fdLpmJ7308fYDLhyK)) && !file_exists($fdLpmJ7308fYDLhyK) ) ) { if($pf = @ZnnVBnrMRumpN($fdLpmJ7308fYDLhyK)) @fclose($pf); $ezWktjge8ufdauNMri .= '<br>Sitemap file is not writable: <b>'.$fdLpmJ7308fYDLhyK.'</b>'; } } if($sm_proc_list)foreach($sm_proc_list as $fCFbByTRhrlRf0Mvv) $ezWktjge8ufdauNMri .= $fCFbByTRhrlRf0Mvv->cRpihDKkpPX_sUhI(); $durGzKjqcdDWuBhr = $grab_parameters['xs_htmlpart']; $cHMa4Ehv6 = $grab_parameters['xs_htmlname']; for($i=0;$i<ceil($Vw1UiQ2aZ['ucount']/$durGzKjqcdDWuBhr);$i++) { $fdLpmJ7308fYDLhyK = (($Vw1UiQ2aZ['ucount']>$durGzKjqcdDWuBhr) ? QJ7ieWoyGceu_OpURmm($i+1,$cHMa4Ehv6,true):$cHMa4Ehv6); if(!is_writable($fdLpmJ7308fYDLhyK) && !is_writable(dirname($fdLpmJ7308fYDLhyK)) ) $ezWktjge8ufdauNMri .= '<br>Sitemap file is not writable: <b>'.$fdLpmJ7308fYDLhyK.'</b>'; } include plQDGddmmXu9xZB.'page-top.inc.php'; ?>
																									<!--
																									<div id="sidenote">
																									<?php ?>
																									<div class="block1head">
																									1. General Parameters
																									</div>
																									<div class="block1">
																									Define website URL, sitemap filename and URL, sitemap types.
																									</div>
																									<div class="block1head">
																									2. Sitemap Entry Attributes
																									</div>
																									<div class="block1">
																									Pages update frequency, last modification time, priority and other attributes.
																									</div>
																									<div class="block1head">
																									3. Miscellaneous Settings
																									</div>
																									<div class="block1">
																									Login and password, email notification, compression, search engines pings etc.
																									</div>
																									<div class="block1head">
																									4. Narrow Indexed Pages Set
																									</div>
																									<div class="block1">
																									Exclude specific filenames, filetypes, folders etc.
																									</div>
																									<div class="block1head">
																									5. Crawler Limitations, Finetune
																									</div>
																									<div class="block1">
																									Limit sitemap size, links depth level, maximum running time etc.
																									</div>
																									<div class="block1head">
																									6. Advanced Settings
																									</div>
																									<div class="block1">
																									Server's IP address, session ID parameters etc.
																									</div>
																									</div>
																									-->
																									<div id="maincont">
																									<?php $ezWktjge8ufdauNMri = isset($_GET['errmsg']) ? $_GET['errmsg'] : $ezWktjge8ufdauNMri; if($ezWktjge8ufdauNMri){ ?>
																									<div class="note">
																									<div class="block2head">
																									An error occured
																									</div>
																									<div class="block1">
																									<?php echo strip_tags($ezWktjge8ufdauNMri, '<b><br>');?>
																									</div>
																									</div>
																									<?php }?>
																									<?php if($otwBPs6XvlOVi2){ ?>
																									<div class="note">
																									<div class="block1head">
																									Note
																									</div>
																									<div class="block1">
																									<?php echo $otwBPs6XvlOVi2?>
																									</div>
																									</div>
																									<?php }?>
																									<h2><i class="material-icons inline-icon">settings</i> Configuration</h2>
																									<ul id="cfgnav" >
																									<li><a href="#cfg1" onclick="return UdZwGx6WdJbW6QFH(this)">Main options</a></li>
																									<li><a href="#cfg2" onclick="return UdZwGx6WdJbW6QFH(this)">Sitemap Types</a></li>
																									<li><a href="#cfg3" onclick="return UdZwGx6WdJbW6QFH(this)">Attributes</a></li>
																									<li><a href="#cfg4" onclick="return UdZwGx6WdJbW6QFH(this)">Customize</a></li>
																									<li><a href="#cfg5" onclick="return UdZwGx6WdJbW6QFH(this)">Crawler rules</a></li>
																									<li><a href="#cfg6" onclick="return UdZwGx6WdJbW6QFH(this)">Advanced</a></li>
																									</ul>
																									<form name="sgform" action="" method="POST" enctype2="multipart/form-data">
																									<input type="hidden" name="tkn" value="<?php echo $token;?>">
																									<input type="hidden" name="op" value="<?php echo $op?>">
																									<input type="hidden" name="save" value="1">
																									<div id="dcfg1">
																									<div class="inptitle">Starting URL:</div>
																									<input type="text" name="initurl" size="70" value="<?php echo htmlentities($grab_parameters['xs_initurl'])?>">
																									<br /><small>
																									Please enter the <b>full</b> http address for your site, only
																									the links within the starting directory will be included.</small>
																									<div class="inptitle">Save sitemap to:</div>
																									<input type="text" name="smname" size="70" value="<?php echo htmlentities($grab_parameters['xs_smname'])?>">
																									<br /><small>
																									Please enter complete file name, including the path. Make sure that the file is existing and has write permissions allowed.
																									<br />Hint: current path to Sitemap generator is: <?php echo dirname(dirname(__FILE__))?>/
																									</small>
																									<div class="inptitle">Your Sitemap URL:</div>
																									<input type="text" name="smurl" size="70" value="<?php echo htmlentities($grab_parameters['xs_smurl'])?>">
																									<br/><br/>
																									</div>
																									<div id="dcfg2">
																									<div id="configother">
																									<small style="color:#600">(*) Note that any extra sitemap type will require additional resources to complete the process</small>
																									<div class="inptitle">Create XML Sitemap:</div>
																									<input type="checkbox" name="webinfo" <?php echo $grab_parameters['xs_webinfo']?'checked':''?> id="in11"><label for="in11"> Create sitemap in XML format</label>
																									<div class="inptitle">Create Text Sitemap:</div>
																									<input type="checkbox" name="maketxt" <?php echo $grab_parameters['xs_maketxt']?'checked':''?> id="in122"><label for="in122"> Create sitemap in Text format</label>
																									<div class="inptitle">Create ROR Sitemap:</div>
																									<input type="checkbox" name="makeror" <?php echo $grab_parameters['xs_makeror']?'checked':''?> id="in13"><label for="in13"> Create sitemap in ROR format</label>
																									<br><small>It will be stored in the same folder as XML sitemap, but with different filename: ror.xml</small>
																									<div class="inptitle">Create HTML Sitemap:</div>
																									<input type="checkbox" onclick="sWtCFebJTmez('sm_html_div')" name="makehtml" <?php echo $grab_parameters['xs_makehtml']?'checked':''?> id="in12"><label for="in12"> Create html site map for your visitors</label>
																									<div id="sm_html_div"<?php echo $grab_parameters['xs_makehtml']?'':' style="display:none"'?>>
																									<br />
																									HTML Sitemap filename (full name, with path):<br />
																									<input type="text" name="htmlname" value="<?php echo htmlentities($grab_parameters['xs_htmlname'])?>" size="70">
																									</div>
																									<div class="inptitle">Create Images Sitemap:
																									<?php $xz = 'n_img';?>
																									Not available - <a href="https://www.xml-sitemaps.com/generator-addons.html" target="_blank">click here to order an add-on</a>
																									<?php $xz = '/n_img';?>
																									</div>
																									<?php ?>
																									<div class="inptitle">Create Video Sitemap:
																									<?php $xz = 'n_video';?>
																									Not available - <a href="https://www.xml-sitemaps.com/generator-addons.html" target="_blank">click here to order an add-on</a>
																									<?php $xz = '/n_video';?>
																									</div>
																									<?php ?>
																									<div class="inptitle">Create News Sitemap:
																									<?php $xz = 'n_news';?>
																									Not available - <a href="https://www.xml-sitemaps.com/generator-addons.html" target="_blank">click here to order an add-on</a>
																									<?php $xz = '/n_news';?>
																									</div>
																									<?php ?>
																									<div class="inptitle">Create RSS feed:
																									<?php $xz = 'n_rss';?>
																									Not available - <a href="https://www.xml-sitemaps.com/generator-addons.html" target="_blank">click here to order an add-on</a>
																									<?php $xz = '/n_rss';?>
																									</div>
																									<?php ?>
																									<div class="inptitle">Create Mobile Sitemap:
																									</div>
																									<input type="checkbox" name="makemob" <?php echo $grab_parameters['xs_makemob']?'checked':''?> id="mobinfo1" onclick="sWtCFebJTmez('sm_mob_div')"><label for="mobinfo1">
																									Create a separate mobile sitemap</label>
																									<div id="sm_mob_div"<?php echo $grab_parameters['xs_makemob']?'':' style="display:none"'?>>
																									<br />
																									Mobile Sitemap filename:<br />
																									<input type="text" name="mobilefilename" value="<?php echo htmlentities($grab_parameters['xs_mobilefilename'])?>" size="70">
																									<br />
																									Mobile pages inclusion mask (optional):<br />
																									<input type="text" name="mobileincmask" value="<?php echo htmlentities($grab_parameters['xs_mobileincmask'])?>" size="70">
																									<br /><small>Separate substrings with spaces</small>
																									</div>
																									<?php if($sm_proc_list)foreach($sm_proc_list as $fCFbByTRhrlRf0Mvv) { ?>
																									<div class="inptitle">Create <?php echo $fCFbByTRhrlRf0Mvv->Z8F0gPCCw_jy?>:</div>
																									<input type="checkbox" onclick="sWtCFebJTmez('<?php echo $fCFbByTRhrlRf0Mvv->ef04NXRrsB_tUwyvJL?>_div')" name="<?php echo $fCFbByTRhrlRf0Mvv->ef04NXRrsB_tUwyvJL?>" <?php echo $grab_parameters[$fCFbByTRhrlRf0Mvv->ef04NXRrsB_tUwyvJL]?'checked':''?> id="in<?php echo $fCFbByTRhrlRf0Mvv->ef04NXRrsB_tUwyvJL;?>"><label for="in<?php echo $fCFbByTRhrlRf0Mvv->ef04NXRrsB_tUwyvJL;?>"> Create <?php echo $fCFbByTRhrlRf0Mvv->Z8F0gPCCw_jy;?></label>
																									<br><small><?php echo $fCFbByTRhrlRf0Mvv->N7CNTmwoY34?></small>
																									<div id="<?php echo $fCFbByTRhrlRf0Mvv->ef04NXRrsB_tUwyvJL?>_div"<?php echo $grab_parameters[$fCFbByTRhrlRf0Mvv->ef04NXRrsB_tUwyvJL]?'':' style="display:none"'?>>
																									Sitemap filename:<br />
																									<input type="text" name="<?php echo $fCFbByTRhrlRf0Mvv->AyzHK7HwV2rWNLOaTr?>" value="<?php echo htmlentities($grab_parameters[$fCFbByTRhrlRf0Mvv->AyzHK7HwV2rWNLOaTr])?>" size="70">
																									</div>
																									<?php }?>
																									<br/><br/>
																									</div>
																									</div>
																									<div id="dcfg3">
																									<div id="configattr">
																									<div class="inptitle">Change frequency:</div>
																									<select name="freq">
																									<option value="">Do not specify</option>
																									<?php $r3H0rzloQGqQ = array('Always','Hourly','Daily','Weekly','Monthly','Yearly','Never'); foreach($r3H0rzloQGqQ as $fa) echo ' <option value="'.strtolower($fa).'"'.(strtolower($fa)==$grab_parameters['xs_freq']?' selected':'').'>'.$fa.'</option>'; ?>
																									</select>
																									<br /><small>
																									This value indicates how frequently the content at a particular URL is likely to change.
																									</small>
																									<?php $C2xQhNcpA4z53ubqFIE = substr(str_replace('|',' ',$grab_parameters['xs_inc_skip']),3,-1); $nPXPmG7LlqkCfgpAvGz = substr(str_replace('|',' ',$grab_parameters['xs_exc_skip']),3,-1); $lm = $grab_parameters['xs_lastmod']; $mGXFV5Ms7 = $grab_parameters['xs_lastmodtime']; ?>
																									<div class="inptitle">Last modification:</div>
																									<input<?php echo $lm==0?' checked':''?> type="radio" name="lastmod" value="0" id="lm1"><label for="lm1"> None</label>
																									<br><input<?php echo $lm==1?' checked':''?> type="radio" name="lastmod" value="1" id="lm2"><label for="lm2"> Use server's response</label>
																									<br><input<?php echo $lm==2?' checked':''?> type="radio" name="lastmod" value="2" id="lm3"><label for="lm3"> Use current time</label>
																									<br><input<?php echo $lm==3?' checked':''?> type="radio" name="lastmod" value="3" id="lm4"><label for="lm4"> Use this date/time:</label>
																									<input type="text" name="lastmodtime" size=30 value="<?php echo $mGXFV5Ms7?htmlentities($mGXFV5Ms7):date('Y-m-d H:i:s')?>">
																									<br /><small>
																									The time the URL was last modified. You can let the generator set this field from your server's response headers or to specify your own date and time.
																									</small>
																									<div class="inptitle">Priority:</div>
																									<input type="text" name="priority" size="5" value="<?php echo htmlentities($grab_parameters['xs_priority'])?>">
																									<br /><small>
																									The priority of a particular URL relative to other pages on the same site. The value for this tag is a number between 0.0 and 1.0.
																									</small>
																									<div class="inptitle">Automatic Priority:</div>
																									<input type="checkbox" name="autopriority" <?php echo $grab_parameters['xs_autopriority']?'checked':''?> id="autopriority"><label for="autopriority"> Automatically assign priority attribute</label>
																									<br><small>Enable this option to automatically reduce priority depending on the page's depth level</small>
																									<div class="inptitle">Individual attributes:</div>
																									<textarea name="ind_attr" rows="4" cols="40"><?php echo htmlentities($grab_parameters['xs_ind_attr'])?></textarea>
																									<br><small>define specific frequency and priority attributes here in the following format:
																									<br/>"url substring,lastupdate YYYY-mm-dd,frequency,priority".
																									<br/><b>example:</b>
																									<br/>page.php?product=,2005-11-14,monthly,0.9
																									</small>
																									<br/>
																									<br/><br/>
																									</div>
																									</div>
																									<div id="dcfg4">
																									<div id="miscset">
																									<div class="inptitle">Require authorization to access generator interface:</div>
																									<input type="checkbox" name="changepass" onclick="sWtCFebJTmez('loginform');" id="chgpass" />
																									<label for="chgpass">Set or modify login/password</label>
																									<div id="loginform" style="display:none">
																									Login:<br/><input type="text" name="xslogin" value="<?php echo htmlentities($grab_parameters['xs_login'])?>" size="70">
																									<br/>
																									Password:<br/><input type="password" name="xspassword" value="" size="70" autocomplete="new-password">
																									</div>
																									<br/>
																									<div class="inptitle">Send email notifications:</div>
																									<input type="text" name="xsemail" value="<?php echo htmlentities($grab_parameters['xs_email'])?>" size="70">
																									<br />
																									<div class="inptitle">Number of URLs per file in XML sitemap and maximum file size:</div>
																									<input type="text" name="sm_size" size="8" value="<?php echo htmlentities($grab_parameters['xs_sm_size'])?>"> URLs per file,
																									<input type="text" name="sm_filesize" size="12" value="<?php echo htmlentities($grab_parameters['xs_sm_filesize'])?>"> Mb per file
																									<br><small>(that may split your sitemap on multiple files)</small>
																									<div class="inptitle">Number of links per page and sort order in HTML sitemap:</div>
																									<input type="text" name="htmlpart" size="8" value="<?php echo htmlentities($grab_parameters['xs_htmlpart'])?>">
																									<select name="htmlsort">
																									<?php $r3H0rzloQGqQ = array('Unsorted (default)','Alphabetical (asc)','Alphabetical (desc)','Randomize'); foreach($r3H0rzloQGqQ as $k=>$fa) echo ' <option value="'.$k.'"'.($k==$grab_parameters['xs_htmlsort']?' selected':'').'>'.$fa.'</option>'; ?>
																									</select>
																									<select name="htmlstruct">
																									<?php $r3H0rzloQGqQ = array('Tree-like (default)','Folders list','Plain list'); foreach($r3H0rzloQGqQ as $k=>$fa) echo ' <option value="'.$k.'"'.($k==$grab_parameters['xs_htmlstruct']?' selected':'').'>'.htmlentities($fa).'</option>'; ?>
																									</select>
																									<div class="inptitle">Compress sitemap using GZip:</div>
																									<input <?php echo $grab_parameters['xs_compress']==0?'checked':''?> type="radio" name="compress" value="0" id="comp0"><label for="comp0">Create uncompressed .xml sitemap only</label>
																									<br />
																									<input <?php echo $grab_parameters['xs_compress']==1?'checked':''?> type="radio" name="compress" value="1" id="comp1"><label for="comp1">Create compressed .xml.gz sitemap only</label>
																									<br />
																									<input <?php echo $grab_parameters['xs_compress']==2?'checked':''?> type="radio" name="compress" value="2" id="comp2"><label for="comp2">Create both compressed and uncompressed sitemap</label>
																									<div class="inptitle">Inform (ping) Search Engines upon completion (Google, Yahoo, Ask, Moreover, Live):</div>
																									<input type="checkbox" name="gping" <?php echo $grab_parameters['xs_gping']?'checked':''?> id="in2"><label for="in2"> Ping Search Engines when generation is done</label>
																									<br>
																									<!--
																									<div class="inptitle">Send "weblogUpdate" type of Ping Notification to:</div>
																									<textarea name="weblogup" rows="2" cols="40"><?php echo htmlentities($grab_parameters['xs_weblog_ping'])?></textarea>
																									-->
																									<div class="inptitle">Calculate changelog:</div>
																									<input type="checkbox" name="gchlog" <?php echo $grab_parameters['xs_chlog']?'checked':''?> id="in3"><label for="in3"> Calculate Change Log after completion</label>
																									<br><small>please note that this option requires more resources to complete</small>
																									<div class="inptitle">Store the external links list:</div>
																									<input type="checkbox" name="extlinks" <?php echo $grab_parameters['xs_extlinks']?'checked':''?> id="inextlinks"><label for="inextlinks"> Store External Links List</label>
																									<br><small>this option increases memory usage</small>
																									<div>Excluding matching URLs:</div>
																									<textarea name="extlinks_excl" rows="2" cols="40"><?php echo htmlentities($grab_parameters['xs_extlinks_excl'])?></textarea>
																									<br/><br/>
																									</div>
																									</div>
																									<div id="dcfg5">
																									<div id="narrow">
																									<div class="inptitle">Exclude from sitemap extensions:</div>
																									<input type="text" name="excl" size="90" value="<?php echo htmlentities($nPXPmG7LlqkCfgpAvGz)?>">
																									<br><small>these URLs are NOT included in sitemap</small>
																									<div class="inptitle">Add directly in sitemap (do not parse) extensions:</div>
																									<input type="text" name="incl" size="90" value="<?php echo htmlentities($C2xQhNcpA4z53ubqFIE)?>">
																									<br><small>these URLs ARE included in sitemap, although not retrieved from server</small>
																									<div class="inptitle">Exclusion preset:</div>
																									<select style="width:220px" onchange="xQRPXSaizfHSr(this.value)">
																									<option value="0">Select one to apply</option>
																									<option value="1">osCommerce</option>
																									<option value="2">Joomla</option>
																									<option value="3">Simple Machines Forum</option>
																									<option value="4">vBulletin</option>
																									<option value="5">phpBB</option>
																									<option value="6">Gallery 2</option>
																									<option value="7">CubeCart</option>
																									</select>
																									<br><small>changing this setting will automatically prepopulate the options below with preset data</small>
																									<script type="text/javascript">
																									
																									function xQRPXSaizfHSr(set)
																									{
																									document.forms['sgform'].elements['excl_urls'].value = aexc[set];
																									document.forms['sgform'].elements['incl_urls'].value = anop[set];
																									}
																									var aexc = new Array();
																									var anop = new Array();
																									aexc[0] = anop[0] = '';
																									aexc[1] = "redirect.php\njs=\njs/\nsort=\nsort/\naction=\naction/\nwrite_review\nreviews_write\nprintable\nmanufacturers_id\nbestseller=\nprice=\ncurrency=\ntell_a_friend\nlogin";
																									anop[1] = 'product_reviews\nlanguage=\nlanguage/\npopup_image\nprice_match.php';
																									aexc[2] = 'print=\ndo_pdf=\npop=1\ntask=emailform\ntask=trackback\ntask=rss';
																									anop[2] = '';
																									aexc[3] = 'dlattach\nsort,\naction=\n.new.html\n.msg\nprev_next';
																									anop[3] = '';
																									aexc[4] = 'attachment.php\ncalendar.php\ncron.php\neditpost.php\nimage.php\nmember.php\nmemberlist.php\nmisc.php\nnewattachment.php\nnewreply.php\nnewthread.php\nonline.php\nprivate.php\nprofile.php\nregister.php\nsearch.php\nusercp.php\ngoto=\np=\nsort=\norder=\nmode=';
																									anop[4] = '';
																									aexc[5] = 'p=\nmode=\nmark=\norder=\nhighlight=\nprofile.php\nprivmsg.php\nposting.php\nview=previous\nview=next\nsearch.php';
																									anop[5] = 'view=print';
																									aexc[6] = 'core.UserLogin\ncore.UserRecoverPassword\ng2_return\nsearch.\nslideshow';
																									anop[6] = 'g2_keyword\ng2_imageViewsIndex';
																									aexc[7] = 'ccUser=\nskins\nthumbs\nsort_\nredir\nreview=\ntell\nact=taf\nlanguage=';
																									anop[7] = 'prod_';
																									</script>
																									<div class="inptitle">Exclude URLs:
																									<span class="inpdesc">noindex, nofollow</span>
																									</div>
																									<textarea name="excl_urls" rows="4" cols="40"><?php echo htmlentities($grab_parameters['xs_excl_urls'])?></textarea>
																									<br><small>do NOT include URLs that contain these substrings, one string per line</small>
																									<div class="inptitle">Add directly in sitemap (do not parse) URLs:
																									<span class="inpdesc">index, nofollow</span>
																									</div>
																									<textarea name="incl_urls" rows="3" cols="40"><?php echo htmlentities($grab_parameters['xs_incl_urls'])?></textarea>
																									<br><small>do not retrieve pages that contain these substrings in URL, but still INCLUDE them in sitemap</small>
																									<div class="inptitle">Crawl, but do not include URLs:
																									<span class="inpdesc">noindex, follow</span>
																									<span class="new">new</span>
																									</div>
																									<textarea name="noincl_urls" rows="3" cols="40"><?php echo htmlentities($grab_parameters['xs_noincl_urls'])?></textarea>
																									<br><small>crawl pages that contain these substrings in URL, but do NOT include them in sitemap</small>
																									<div class="inptitle">"Include ONLY" URLs:
																									<span class="inpdesc">index <i>only matching</i></span>
																									</div>
																									<input type="text" name="incl_only" size="90" value="<?php echo htmlentities($grab_parameters['xs_incl_only'])?>">
																									<br><small>leave this field empty by default. Fill it if you would like to include into sitemap ONLY those URls that match the specified string, separate multiple matches with space.</small>
																									<br/>
																									<div class="inptitle">"Parse ONLY" URLs:
																									<span class="inpdesc">follow <i>only matching</i></span></div>
																									<input type="text" name="parse_only" size="90" value="<?php echo htmlentities($grab_parameters['xs_parse_only'])?>">
																									<br><small>leave this field empty by default. Fill it if you would like to parse (crawl) ONLY those URls that match the specified string, separate multiple matches with space.</small>
																									<br/>
																									<br/><br/>
																									</div>
																									<div id="configopt">
																									<div class="inptitle">Maximum pages:</div>
																									<input type="text" name="max_pages" size="5" value="<?php echo htmlentities($grab_parameters['xs_max_pages'])?>">
																									<br /><small>
																									This will limit the number of pages crawled. You can enter "0" value for unlimited crawling.
																									<?php if($t_jfu3tklMMMXcFmJ){ ?>
																									<br />
																									<b style="color:red">THIS IS A TRIAL VERSION of sitemap generator, it will NOT index more than 500 pages</b>
																									<?php } ?>
																									</small>
																									<div class="inptitle">Maximum depth level:</div>
																									<input type="text" name="max_depth" size="5" value="<?php echo htmlentities($grab_parameters['xs_max_depth'])?>">
																									<small>"0" for unlimited</small>
																									<div class="inptitle">Maximum execution time, seconds:</div>
																									<input type="text" name="exec_time" size="5" value="<?php echo htmlentities($grab_parameters['xs_exec_time'])?>">
																									<small>"0" for unlimited</small>
																									<div class="inptitle">Maximum memory usage, MB:</div>
																									<input type="text" name="mem_limit" size="5" value="<?php echo htmlentities($grab_parameters['xs_memlimit'])?>">
																									<small>"0" for default. Note: might not work depending on the server configuration.</small>
																									<div class="inptitle">Save the script state, every X seconds:</div>
																									<input type="text" name="savestate_time" size="5" value="<?php echo htmlentities($grab_parameters['xs_savestate_time'])?>">
																									<small>this option allows to resume crawling operation if it was interrupted. "0" for no saves</small>
																									<div class="inptitle">Make a delay between requests, X seconds after each N requests:</div>
																									<input type="text" name="delay_ms" size="5" value="<?php echo htmlentities($grab_parameters['xs_delay_ms'])?>"> s
																									after each
																									<input type="text" name="delay_req" size="5" value="<?php echo htmlentities($grab_parameters['xs_delay_req'])?>"> requests
																									<br/><small>This option allows to reduce the load on your webserver. "0" for no delay</small>
																									<br/><br/>
																									</div>
																									</div>
																									<div id="dcfg6">
																									<div id="configopt2">
																									<div class="inptitle">Allow subdomains:</div>
																									<input type="checkbox" name="allow_subdomains" <?php echo $grab_parameters['xs_allow_subdomains']?'checked':''?> id="allow_subdomains1"><label for="allow_subdomains1"> include pages from any website subdomain</label>
																									<div class="inptitle">Additional "Starting URLs":</div>
																									<textarea name="moreurls" rows="2" cols="40"><?php echo htmlentities($grab_parameters['xs_moreurls'])?></textarea>
																									<div class="inptitle">Support cookies:</div>
																									<input type="checkbox" name="cookies" <?php echo $grab_parameters['xs_no_cookies']?'':' checked'?> id="cook1"><label for="cook1"> Support cookies</label>
																									<div class="inptitle">Use robots.txt file:</div>
																									<input type="checkbox" name="robotson" <?php echo $grab_parameters['xs_robotstxt']?'checked':''?> id="rob1"><label for="rob1"> use robots.txt file</label>
																									<div class="inptitle">Detect canonical URL meta tags:</div>
																									<input type="checkbox" name="canonical" <?php echo $grab_parameters['xs_canonical']?'checked':''?> id="can1"><label for="can1"> enable canonical URLs</label>
																									<div class="inptitle">Crawl Ajax content:</div>
																									<input type="checkbox" name="xsajax" <?php echo $grab_parameters['xs_inc_ajax']?'checked':''?> id="aj3"><label for="aj3"> AJAX content</label>
																									<br />
																									<small>the site must comply with "crawlable ajax" <a href="https://developers.google.com/webmasters/ajax-crawling/docs/getting-started">specs</a></small>
																									<?php $jziZtzrMm = str_replace('|',' ',$grab_parameters['xs_cleanpar']); ?>
																									<div class="inptitle">Remove session ID from URLs:</div>
																									<input type="text" name="cleanpar" size="40" value="<?php echo htmlentities($jziZtzrMm)?>">
																									<br />
																									<small>common session parameters (separate with spaces): PHPSESSID, sid, osCsid</small>
																									<div class="inptitle">Include hreflang for language URLs in sitemap:
																									<span class="new">new</span>
																									</div>
																									<input type="checkbox" name="hreflang" <?php echo $grab_parameters['xs_hreflang']?'checked':''?> id="can2"><label for="can2"> detect hreflang attribute</label>
																									<br />
																									<small>automatically detect hreflang on crawled website, <a href="https://support.google.com/webmasters/answer/189077?hl=en">details</a></small>
																									<div class="inptitle">Custom alternative language pages:
																									<span class="new">new</span>
																									</div>
																									<textarea name="alt_lang" rows="2" cols="40"><?php echo htmlentities($grab_parameters['xs_alt_lang']);?></textarea>
																									<br /><small>Specify alternative language versions for your pages: enter your page URL followed by a list of language identifier with alternative URLs, example:<br />
																									http://www.example.com/<br />
																									de http://www.example.com/de/<br />
																									es http://www.example.com/es/<br />
																									</small>
																									<div class="inptitle">Use IP address for crawling:</div>
																									<input type="text" name="serveripaddr" size="40" value="<?php echo htmlentities($grab_parameters['xs_ipconnection'])?>">
																									<br><small>Hint: SERVER[SERVER_ADDR] - <?php echo htmlentities($_SERVER['SERVER_ADDR'])?></small>
																									<div class="inptitle">Use CURL extension for http requests:</div>
																									<input type="checkbox" name="usecurl" <?php echo $grab_parameters['xs_usecurl']?'checked':''?> id="curl1"><label for="curl1"> Use CURL extension</label>
																									<div class="inptitle">Enable stylesheet for XML sitemap:</div>
																									<input type="checkbox" name="xslon" <?php echo $grab_parameters['xs_disable_xsl']?'':'checked'?> id="canxsl2"><label for="canxsl2"> enable XSL stylesheet</label>
																									<div class="inptitle">Remove "Created by.." links from sitemap:</div>
																									<input type="checkbox" name="nobrand" <?php echo $grab_parameters['xs_nobrand']?'checked':''?> id="nobrand2"><label for="nobrand2"> remove "created by" links</label>
																									<div class="inptitle">Store referring links:
																									<span class="new">new</span></div>
																									<input type="checkbox" name="ref_list_store" <?php echo $grab_parameters['xs_ref_list_store']?'checked':''?> id="reflinks2"><label for="reflinks2"> store referring links</label>
																									<br><small>this option increases memory usage</small>
																									<div class="inptitle">Maximum referring pages to store:</div>
																									<input type="text" name="maxref" size="5" value="<?php echo htmlentities($grab_parameters['xs_maxref'])?>">
																									<br><small>max referring URLs per page</small>
																									<div class="inptitle">Site uses UTF-8 charset:</div>
																									<input type="checkbox" name="xsutf" <?php echo $grab_parameters['xs_utf8']?'checked':''?> id="can3"><label for="can3"> UTF8 charset</label>
																									<div class="inptitle">Monitor crawler window and automatically resume if it stops in X seconds:</div>
																									<input type="text" name="autoresume" size="5" value="<?php echo htmlentities($grab_parameters['xs_autoresume'])?>">
																									<div class="inptitle">Show debug output when crawling:</div>
																									<input type="checkbox" name="dbg" <?php echo $grab_parameters['xs_debug']?'checked':''?> id="dbg1"><label for="dbg1"> enable debug output</label>
																									<div class="inptitle">Check for new versions of sitemap generator:</div>
																									<input type="checkbox" name="checkver" <?php echo $grab_parameters['xs_checkver']?'checked':''?> id="checkver1"><label for="checkver1"> check for new versions</label>
																									<div class="inptitle">Purge log records older than X days:</div>
																									<input type="text" name="purge" size="5" value="<?php echo htmlentities($grab_parameters['xs_purgelogs'])?>">
																									<div class="inptitle">Custom groups for "analyze" tab:</div>
																									<input type="text" name="angroups" size="40" value="<?php echo htmlentities($grab_parameters['xs_angroups'])?>">
																									<br />
																									</div>
																									</div>
																									<input class="button" type="submit" name="bsave" value="Save Changes" >
																									</form>
																									<script language="Javascript">
																									<!--
																									
																									function UdZwGx6WdJbW6QFH(elthis){
																									wZX_Z1G9e5p1YfVezKo(elthis.href)
																									return true;
																									}
																									
																									function wZX_Z1G9e5p1YfVezKo(parthref){
																									var part = parthref.substring(parthref.indexOf('#')+1);
																									if(parthref.indexOf('#')<0)part='cfg1';
																									var nel = document.getElementById('cfgnav');
																									var lis = nel.getElementsByTagName('a');
																									for(var lid=0;lid<lis.length;lid++){
																									var del = document.getElementById('dcfg'+(lid+1));
																									var liel = lis[lid];
																									console.log(lid,liel,del);
																									if(liel.href.indexOf(part)>=0){
																									liel.className = 'active';
																									del.style.display = '';
																									}else {
																									del.style.display = 'none';
																									liel.className = '';
																									}
																									}
																									return true;
																									}
																									wZX_Z1G9e5p1YfVezKo(document.location.href)
																									
																									function sWtCFebJTmez(eid)
																									{
																									var gel = document.getElementById(eid);
																									var isvis = gel.style.display ? 1 : 0;
																									gel.style.display = isvis ? '' : 'none';
																									var th = document.getElementById('h'+eid);
																									if(th)
																									{
																									var al = ['[+]', '[-]'];
																									var rl = ['collapse', 'expand'];
																									th.innerHTML = al[isvis]+th.innerHTML.substring(3, 100);
																									th.innerHTML = th.innerHTML.replace(rl[isvis], rl[1-isvis]);
																									}
																									}
																									
																									
																									
																									
																									
																									//-->
																									</script>
																									</div>
																									<?php if(G05LA0VhMkOj4Hg){ ?>
																									<div class="block1 licensed">
																									Licensed to:<br />
																									<small><?php echo str_rot13(G05LA0VhMkOj4Hg);?></small>
																									</div>
																									<?php } include plQDGddmmXu9xZB.'page-bottom.inc.php'; 
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									