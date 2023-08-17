<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet 
  version="1.0"
  xmlns:sm="http://www.sitemaps.org/schemas/sitemap/0.9"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0"
  xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
  xmlns:video="http://www.google.com/schemas/sitemap-video/1.1"
  xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"
  xmlns:fo="http://www.w3.org/1999/XSL/Format"
  xmlns:xhtml="http://www.w3.org/1999/xhtml"
  xmlns="http://www.w3.org/1999/xhtml">
 
  <xsl:output method="html" indent="yes" encoding="UTF-8"/>

  <xsl:template match="/">
<html>
<head>
<title>
<xsl:if test="sm:urlset/sm:url/mobile:mobile">Mobile </xsl:if>
<xsl:if test="sm:urlset/sm:url/image:image">Images </xsl:if>
<xsl:if test="sm:urlset/sm:url/news:news">News </xsl:if>
<xsl:if test="sm:urlset/sm:url/video:video">Video </xsl:if>
XML Sitemap
<xsl:if test="sm:sitemapindex"> Index</xsl:if>
</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<style type="text/css">
	body {
		background-color: #fff;
		font-family: "Arial Narrow", "Helvetica", "Arial", sans-serif;
		margin: 0;
	}

	#top {

		background-color: #b1d1e8;
		font-size: 16px;
		padding-bottom: 40px;
	}

	nav {
		font-size: 24px;

		margin: 0px 30px 0px;
		border-bottom-left-radius: 6px;
		border-bottom-right-radius: 6px;
		background-color: #f3f3f3;
		color: #666;
		box-shadow: 0 10px 20px -12px rgba(0, 0, 0, 0.42), 0 3px 20px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2);
		padding: 10px 0;
		text-align: center;
		z-index: 1;
	}
	nav span {
		background-color: #ddd;
		font-size: 20px;
		padding: 10px;
		border-radius: 5px;
		display: inline-block;
	}

	h3 {
		margin: auto;
		padding: 10px;
		max-width: 600px;
		color: #666;
	}

	h3 span {
		float: right;
	}

	h3 a {
		font-weight: normal;
		display: block;
	}


	#cont {
		font-size: 18px;
		position: relative;
		border-radius: 6px;
		box-shadow: 0 16px 24px 2px rgba(0, 0, 0, 0.14), 0 6px 30px 5px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2);

		background: #f3f3f3;

		margin: -20px 30px 0px 30px;
		padding: 20px;
	}
	small {
		color: #666;
	}

	a:link,
	a:visited {
		color: #0180AF;
		text-decoration: underline;
	}

	a:hover {
		color: #666;
	}


	#footer {
		padding: 10px;
		text-align: center;
	}

	th,.th {
	    border-bottom: 2px solid #ddd;
	    text-align: center;
	    padding: 10px;
    }
    .tr {
		padding: 5px 2px;
	    border-top: 1px solid #ddd;
	    clear: both;
    }
	.tr:nth-of-type(odd) {
    	background-color: #f9f9f9;
	}
	.url2 {
		*text-align:right;
		margin-left: 50px;
	}
	.url2 .tdmain {
		float: none;
	}
	
	.tdinline {
		display: inline;
		margin:0px 2px;
		padding:0px 2px;
		font-style:italic;
	}
	.tdappend {
		*float:right;	
		text-align:right;
		color:#666;
		font-size: 90%;
	}
	.tdmain {
		float: left;
	}
	.tdmain span {
		padding: 2px 10px;
		font-size: 90%;
	}
	
@media (max-width: 640px) {
.tdmain {
	display:block;
	
}
.head1 {
	display:none;
}
.head2 {
	display:table-row;
}
.tdinline {
	display: inline;
}


}	
	.mx100 {
		max-width:100%;
	}
	</style>
</head>
<body>
	<div id="top">
		<nav>

<xsl:if test="sm:urlset/sm:url/mobile:mobile">Mobile </xsl:if>
<xsl:if test="sm:urlset/sm:url/image:image">Images </xsl:if>
<xsl:if test="sm:urlset/sm:url/news:news">News </xsl:if>
<xsl:if test="sm:urlset/sm:url/video:video">Video </xsl:if>
XML Sitemap<xsl:if test="sm:sitemapindex"> Index</xsl:if>
- <span><xsl:value-of select="sm:urlset/sm:url/sm:loc"/></span>
		</nav>
<h3>
<span><a href="https://www.xml-sitemaps.com">www.xml-sitemaps.com</a></span>
<xsl:choose>
<xsl:when  test="sm:sitemapindex"> 
Total sitemap files listed in this index: <xsl:value-of select="count(sm:sitemapindex/sm:sitemap)"/>
</xsl:when>
<xsl:otherwise> 
The number of pages in this sitemap file: <xsl:value-of select="count(sm:urlset/sm:url)"/>
<xsl:if test="sm:urlset/sm:url/video:video">
The number of videos: <xsl:value-of select="count(sm:urlset/sm:url/video:video)"/>
</xsl:if>
</xsl:otherwise>
</xsl:choose>
</h3>
	</div>
<div id="cont">


<xsl:apply-templates />
</div>

<div id="footer">
<!--Created with Standalone Sitemap Generator,
Copyright (c)2005-2019 <a href="https://www.xml-sitemaps.com/standalone-google-sitemap-generator.html">XML Sitemaps</a>
-->
</div>

</body>
</html>
  </xsl:template>
 
 
  <xsl:template match="sm:sitemapindex">
  <div class="tbl">
<div class="th">URL /
Last Modified</div>

<xsl:for-each select="sm:sitemap">
<div class="tr"> 
<xsl:variable name="loc"><xsl:value-of select="sm:loc"/></xsl:variable>
<xsl:variable name="pno"><xsl:value-of select="position()"/></xsl:variable>

<div class="tdmain">
<span><xsl:value-of select="$pno"/></span>
<a href="{$loc}"><xsl:value-of select="sm:loc"/></a>
</div>
<div class="tdappend">
<xsl:apply-templates/> 
</div>
</div>

</xsl:for-each>
</div>
  </xsl:template>
 
  <xsl:template match="sm:urlset">
  <div class="tbl">

<div class="th">
URL
<xsl:if test="sm:url/sm:lastmod"> / Last Modified</xsl:if>
<xsl:if test="sm:url/sm:changefreq"> / Change Frequency</xsl:if>
<xsl:if test="sm:url/sm:priority"> / Priority</xsl:if>
</div>
<xsl:for-each select="sm:url">
<div class="tr"> 
<xsl:variable name="loc"><xsl:value-of select="sm:loc"/></xsl:variable>
<xsl:variable name="pno"><xsl:value-of select="position()"/></xsl:variable>

<div class="tdmain">
<span><xsl:value-of select="$pno"/></span><a href="{$loc}"><xsl:value-of select="sm:loc"/></a></div>
<div class="tdappend">
<xsl:apply-templates select="sm:*"/> 
</div>
</div>

<xsl:apply-templates select="xhtml:*"/> 
<xsl:apply-templates select="image:*"/> 
<xsl:apply-templates select="video:*"/> 
</xsl:for-each>
</div>
  </xsl:template>

<xsl:template match="sm:loc|image:loc|image:caption|video:*">
</xsl:template>

<xsl:template match="sm:lastmod|sm:changefreq|sm:priority">
<div class="tdinline">
	<xsl:apply-templates/>
</div>
</xsl:template>

  <xsl:template match="xhtml:link">
  <div class="tr">
<xsl:variable name="altloc"><xsl:value-of select="@href"/></xsl:variable>

<div class="tdmain">
<span><xsl:value-of select="@hreflang"/></span>
<a href="{$altloc}"><xsl:value-of select="@href"/></a>
</div>
<xsl:apply-templates/> 
</div>
  </xsl:template>
  <xsl:template match="image:image">
<div class="tr"> 
<xsl:variable name="loc"><xsl:value-of select="image:loc"/></xsl:variable>
<div class="url2">
<div class="tdmain"><a href="{$loc}"><xsl:value-of select="image:loc"/></a></div>
<div class="mx100"><xsl:value-of select="image:caption"/></div>
</div>
<xsl:apply-templates/> 
</div>

  </xsl:template>
  <xsl:template match="video:video">
<div class="tr"> 
<xsl:variable name="loc"><xsl:choose><xsl:when test="video:player_loc != ''"><xsl:value-of select="video:player_loc"/></xsl:when><xsl:otherwise><xsl:value-of select="video:content_loc"/></xsl:otherwise></xsl:choose></xsl:variable>
<xsl:variable name="thumb"><xsl:value-of select="video:thumbnail_loc"/></xsl:variable>
<div class="url2">
<div class="tdmain"><a href="{$loc}"><xsl:choose><xsl:when test="video:player_loc != ''"><xsl:value-of select="video:player_loc"/></xsl:when><xsl:otherwise><xsl:value-of select="video:content_loc"/></xsl:otherwise></xsl:choose></a></div>
<div class="mx100"><xsl:value-of select="video:title"/></div>
<xsl:if test="video:thumbnail_loc != ''"><img src="{$thumb}" alt="" class="mx100" /></xsl:if>
</div>
<xsl:apply-templates/> 
</div>
  </xsl:template>

</xsl:stylesheet>
