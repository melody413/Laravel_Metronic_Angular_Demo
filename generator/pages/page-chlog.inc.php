<?php // This file is protected by copyright law and provided under license. Reverse engineering of this file is strictly prohibited.
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									$PEgqWfLwjrb=758231287;$ilUN8tpT1g=592460309;$VqKb5otSgN9X6i=741775242;$wo8uWWm_JE9=82849640;$J0TARjsvGs_lcHq7=747074230;$iPEdYuraz=802553104;$eEVpRVZwWp62CvM=65183376;$ITtmZkYmtCjyV1=490936391;$Ab3I4snyNwGoaW31Jf=26933946;$tBmlBEqB2t=269473311;$IMGi4gyfas3deSt5=958649202;$g2aSfTznvwVdnzCo0=625190576;$yXnuYBOyE2txWEaPuU=761209927;$MDVHpOyFhEPlE0h0=743216293;$wfEXWgahq9uKD=115588202;$O0qBhq4SC=894078574;$UN4ZVq7AN72Uz=978017903;$g1ewxXSndiKZYCh=201981116;$Kg06WLIVh=441313904;$nXJmKAhswFhZ=613834961;$Vrg8_yiG0p8mGqX5ix=778167052;$PGu84vGwVm_f8p=186047128;$FVyyW0K04T2V=775271970;$cwxiaDUkHW=33477841;$afpx_BwkaZRcPxsSGUg=91325424;$gAxCdw6o2D=768230561;$i0GRBq2hSG9qAonMl=835395618;$DUICtWWwSnEz33LvjX=741264657;$DKs2UWCYS=602158047;$Oc0BUt0M7n11R2Bu4D6=764888605;$er5hMShN1mW3bGXx=6206616;$ct09ud7Qx=18126042;$x7mHqxiFWv95si=812076782;$mYwP2i88L=870873980;$ImNq8LIgKSz6V=156042203;$GS4kEaXPv2OA=813909002;$s8TwAxoiW7Y2TZRX84i=939485919;$TpAPYa5t5=948514266;$cHlhe6Klro5Ljh8d2r=783955336;$UrajIvtBHJnzAOx_=178374122;$P33EWEx7MclAkz=884208733;$fuZ9vhJfVaJw=522264980;$El5WbLwtu_dh71w=888941612;$nhDppxeNfh4=763030537;$g3FNP6dan8AXVGRwzA=440337034;$JRJr3LZ9UO=694243895;$k5XOUTFfM5AUnuh=962119340;$bbAhKQ5LSrGbT_4=663505932;$LwjQ8Q3n83eNI=43638099;$Ss5VHvopIgNRz=273807039;?><?php if(!defined('HqmBMPQB4QfPS'))return;include plQDGddmmXu9xZB.'page-top.inc.php'; $sbVHaTKsEq1 = i_hAx1zOITGPbGiqp(); if($grab_parameters['xs_chlogorder'] == 'desc') rsort($sbVHaTKsEq1); $cqwuL6Jndz0Km=$_GET['log']; if($cqwuL6Jndz0Km){ ?>
																									<div id="sidenote">
																									<div class="block1head">
																									Crawler logs
																									</div>
																									<div class="block1">
																									<?php for($i=0;$i<count($sbVHaTKsEq1);$i++){ $Vw1UiQ2aZ = vkf20yZ21Nwf($sbVHaTKsEq1[$i]); if($i+1==$cqwuL6Jndz0Km)echo '<u>'; ?>
																									<a href="index.<?php echo $AdhM211IF7voW?>?op=chlog&log=<?php echo $i+1?>" title="View details"><?php echo date('Y-m-d H:i',$Vw1UiQ2aZ['time'])?></a>
																									( +<?php echo count($Vw1UiQ2aZ['newurls'])?> -<?php echo count($Vw1UiQ2aZ['losturls'])?>)
																									</u>
																									<br>
																									<?php	} ?>
																									</div>
																									</div>
																									<?php } ?>
																									<div id="<?php  echo $cqwuL6Jndz0Km?'shifted':'maincont'?>" >
																									<h2><i class="material-icons inline-icon">history</i> Site History</h2>
																									<?php if($cqwuL6Jndz0Km){ $Vw1UiQ2aZ = vkf20yZ21Nwf($sbVHaTKsEq1[$cqwuL6Jndz0Km-1]); ?><h4><?php echo date('j F Y, H:i',$Vw1UiQ2aZ['time'])?></h4>
																									<div class="inptitle">New URLs (<?php echo count($Vw1UiQ2aZ['newurls'])?>)</div>
																									<textarea style="width:100%;height:300px"><?php echo @htmlspecialchars(implode("\n",$Vw1UiQ2aZ['newurls']))?></textarea>
																									<div class="inptitle">Removed URLs (<?php echo count($Vw1UiQ2aZ['losturls'])?>)</div>
																									<textarea style="width:100%;height:300px"><?php echo @htmlspecialchars(implode("\n",$Vw1UiQ2aZ['losturls']))?></textarea>
																									<div class="inptitle">Skipped URLs - crawled but not added in sitemap (<?php echo count($Vw1UiQ2aZ['urls_list_skipped'])?>)</div>
																									<textarea style="width:100%;height:300px"><?php foreach($Vw1UiQ2aZ['urls_list_skipped'] as $k=>$v)echo @htmlspecialchars($k.' - '.$v)."\n";?></textarea>
																									<?php 
																									function icf39resvZXWu19E($nl){ $lc = ''; $it = 0; if($nl) foreach($nl as $l=>$il){ $lc .= $l."\n"; foreach($il as $i=>$c){ $lc .= "\t".$i."\n"; $it++; } } return array($it,$lc); } ?>
																									<?php $ni = icf39resvZXWu19E($Vw1UiQ2aZ['newurls_i']); ?>
																									<div class="inptitle">New images (<?php echo $ni[0]?>)</div>
																									<textarea style="width:100%;height:300px"><?php echo @htmlspecialchars($ni[1])?></textarea>
																									<?php $ni = icf39resvZXWu19E($Vw1UiQ2aZ['losturls_i']); ?>
																									<div class="inptitle">Removed images (<?php echo $ni[0]?>)</div>
																									<textarea style="width:100%;height:300px"><?php echo @htmlspecialchars($ni[1])?></textarea>
																									<?php $ni = icf39resvZXWu19E($Vw1UiQ2aZ['newurls_v']); ?>
																									<div class="inptitle">New videos (<?php echo $ni[0]?>)</div>
																									<textarea style="width:100%;height:300px"><?php echo @htmlspecialchars($ni[1])?></textarea>
																									<?php $ni = icf39resvZXWu19E($Vw1UiQ2aZ['losturls_v']); ?>
																									<div class="inptitle">Removed videos (<?php echo $ni[0]?>)</div>
																									<textarea style="width:100%;height:300px"><?php echo @htmlspecialchars($ni[1])?></textarea>
																									<?php }else{ ?>
																									<table class="ltable">
																									<tr class=block1head>
																									<th>No</th>
																									<th>Date/Time</th>
																									<th>Indexed pages</th>
																									<th>Processed pages</th>
																									<th>Skipped pages</th>
																									<th>Proc.time</th>
																									<th>Bandwidth</th>
																									<th>New URLs</th>
																									<th>Removed URLs</th>
																									<th>Broken links</th>
																									<?php if($grab_parameters['xs_imginfo'])echo '<th>Images</th>';?>
																									<?php if($grab_parameters['xs_videoinfo'])echo '<th>Videos</th>';?>
																									<?php if($grab_parameters['xs_newsinfo'])echo '<th>News</th>';?>
																									<?php if($grab_parameters['xs_rssinfo'])echo '<th>RSS</th>';?>
																									</tr>
																									<?php  $JBemLwS2R_IVV6kO1=array(); for($i=0;$i<count($sbVHaTKsEq1);$i++){ $Vw1UiQ2aZ = vkf20yZ21Nwf($sbVHaTKsEq1[$i]); if(!$Vw1UiQ2aZ)continue; foreach($Vw1UiQ2aZ as $k=>$v)if(!is_array($v))$JBemLwS2R_IVV6kO1[$k]+=intval($v);else $JBemLwS2R_IVV6kO1[$k]+=count($v); ?>
																									<tr class=block1>
																									<td><?php echo $i+1?></td>
																									<td><a href="index.php?op=chlog&log=<?php echo $i+1?>" title="View details"><?php echo date('Y-m-d H:i',$Vw1UiQ2aZ['time'])?></a></td>
																									<td><?php echo number_format($Vw1UiQ2aZ['ucount'])?></td>
																									<td><?php echo number_format($Vw1UiQ2aZ['crcount'])?></td>
																									<td><?php echo count($Vw1UiQ2aZ['urls_list_skipped'])?></td>
																									<td><?php echo number_format($Vw1UiQ2aZ['ctime'],2)?>s</td>
																									<td><?php echo number_format($Vw1UiQ2aZ['tsize']/1024/1024,2)?></td>
																									<td><?php echo $Vw1UiQ2aZ['newurls']?count($Vw1UiQ2aZ['newurls']):'-'?></td>
																									<td><?php echo $Vw1UiQ2aZ['losturls']?count($Vw1UiQ2aZ['losturls']):'-'?></td>
																									<td><?php echo $Vw1UiQ2aZ['u404']?count($Vw1UiQ2aZ['u404']):'-'?></td>
																									<?php if($grab_parameters['xs_imginfo'])echo '<td>'.$Vw1UiQ2aZ['images_no'].'</td>';?>
																									<?php if($grab_parameters['xs_videoinfo'])echo '<td>'.$Vw1UiQ2aZ['videos_no'].'</td>';?>
																									<?php if($grab_parameters['xs_newsinfo'])echo '<td>'.$Vw1UiQ2aZ['news_no'].'</td>';?>
																									<?php if($grab_parameters['xs_rssinfo'])echo '<td>'.$Vw1UiQ2aZ['rss_no'].'</td>';?>
																									</tr>
																									<?php }?>
																									<tr class=block1>
																									<th colspan=2>Total</th>
																									<th><?php echo number_format($JBemLwS2R_IVV6kO1['ucount'])?></th>
																									<th><?php echo number_format($JBemLwS2R_IVV6kO1['crcount'])?></th>
																									<th>-</th>
																									<th><?php echo number_format($JBemLwS2R_IVV6kO1['ctime'],2)?>s</th>
																									<th><?php echo number_format($JBemLwS2R_IVV6kO1['tsize']/1024/1024,2)?> Mb</th>
																									<th><?php echo ($JBemLwS2R_IVV6kO1['newurls'])?></th>
																									<th><?php echo ($JBemLwS2R_IVV6kO1['losturls'])?></th>
																									<th>-</th>
																									<?php if($grab_parameters['xs_imginfo'])echo '<th></th>';?>
																									<?php if($grab_parameters['xs_videoinfo'])echo '<th></th>';?>
																									<?php if($grab_parameters['xs_newsinfo'])echo '<th></th>';?>
																									<?php if($grab_parameters['xs_rssinfo'])echo '<th></th>';?>
																									</tr>
																									</table>
																									<?php } ?>
																									</div>
																									<?php include plQDGddmmXu9xZB.'page-bottom.inc.php'; 
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									
																									