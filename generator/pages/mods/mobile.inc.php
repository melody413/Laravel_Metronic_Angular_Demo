<?php
																													
																												class SG_Mobile
																												{
																												    var $title = 'Mobile XML Sitemap';
																												    //var $optdesc = 'It will be stored in the same folder as XML sitemap, but with different filename';
																												    var $optdesc = '';
																												    var $option = 'xs_makemob';
																												    var $foption = 'xs_mobilefilename';
																												
																												    var $tpl = '';
																												    var $smfile = '', $smurl = '', $enabled = false, 
																												    $fop = array(), $params = array(), $parser = '', $wr_urls = 0;
																												
																												    
																									function SG_Mobile($params)
																												    {
																														$this->enabled = $params[$this->option];
																														$fapp = ($params['xs_compress']==1) ? '.gz' : '';
																														$this->smfile = preg_replace('#[^\\/]+?\.xml$#', $params[$this->foption], $params['xs_smname']).$fapp;
																														$this->smurl  = preg_replace('#[^\\/]+?\.xml$#', $params[$this->foption], $params['xs_smurl']).$fapp;
																													}
																												
																													
																									function check_perms()
																													{
																												        if(
																												        $this->enabled && 
																												        !is_writable($this->smfile) && !is_writable(dirname($this->smfile))
																												        	)
																												        	return '<br>Sitemap file is not writable: <b>'.$this->smfile.'</b>';
																													}
																												
																												    
																									function fn_start($params, $fop, $parser)
																												    {
																												    	global $is_dom2;
																												    	if(!$this->enabled) return;
																												    	$this->fop = $fop;
																												    	$this->params = $params;
																												    	$this->parser = $parser;
																												
																												    	$bcont = implode('', file(CTYPEDIR.'sitemap_mob_tpl.xml'));
																												       	preg_match('#^(.*)%URLS_LIST_FROM%(.*)%URLS_LIST_TO%(.*)$#is', $bcont, $this->tpl);
																													  	$this->tpl[1] = str_replace('%GEN_URL%', $is_dom2.'/', $this->tpl[1]);
																												
																												      	
																												       	$this->pf = $this->fop['fopen']($this->smfile.$this->fapp, 'w');
																												       	$rc = str_replace('%INIT_URL%', $params['xs_initurl'], $this->tpl[1]);
																												     	$this->fop['fwrite']($this->pf, $rc);
																												
																												    }
																												
																												    
																									function fn_proc($url_repl)
																												    {
																												    	if(!$this->enabled) return;
																												
																												   		if($this->params['xs_mobileincmask'])
																												   		if(!preg_match('#'.str_replace(' ', '|', preg_quote($this->params['xs_mobileincmask'],'#')).'#',$url_repl['URL']))
																												   			return;
																												    	
																												    	if($this->wr_urls>=50000)return;
																												
																												    	$this->wr_urls++;
																														$this->fop['fwrite']($this->pf, $this->parser->parseContVar($this->tpl[2], $url_repl));
																												
																												    }
																												
																												    
																									function fn_finish()
																												    {
																												    	if(!$this->enabled) return;
																														$this->fop['fwrite']($this->pf, $this->tpl[3]);
																													  	$this->fop['fclose']($this->pf);
																												    }
																												
																												}
																												global $sm_proc_list, $grab_parameters;
																												
																												$sm_proc_list[] = new SG_Mobile($grab_parameters);
																												?>