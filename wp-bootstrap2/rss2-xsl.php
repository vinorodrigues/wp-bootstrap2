<?php
  header('Content-Type: text/xsl');
  echo '<?xml version="1.0" encoding="utf-8"?>' . PHP_EOL;

  $path = dirname( $_SERVER['PHP_SELF'] );
?>
<xsl:stylesheet version="1.0"
  xmlns="http://www.w3.org/1999/xhtml"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:atom="http://www.w3.org/2005/Atom" >
<xsl:output method="html" indent="yes"
  doctype-system='http://www.w3.org/TR/html4/strict.dtd'
  doctype-public='-//W3C//DTD HTML 4.01//EN' />

<xsl:template match="/">
  <xsl:apply-templates select="rss/channel" />
</xsl:template>

<xsl:template match="rss/channel">

<html>
<head>
  <title><xsl:value-of select="atom:title" /></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="<?= $path . '/css/bootstrap.min.css ' ?>" />
  <style> body { padding-top: 60px; } </style>
  <link rel="stylesheet" type="text/css" href="<?= $path . '/css/bootstrap-responsive.min.css ' ?>" />
</head>

<body>

<div class="navbar navbar-inverse navbar-fixed-top"><div class="navbar-inner"><div class="container">
  <a href="{link}" class="brand"><xsl:apply-templates select="title" /></a>
  <ul class="nav pull-right"><li>
  <a class="pull-right" href="http://wikipedia.org/wiki/RSS"><img src="<?= $path . '/img/rss.png' ?>" /></a>
  </li></ul>
</div></div></div>

<div class="container">
<xsl:apply-templates select="item" />
</div>
  
</body>
</html>

</xsl:template>

<xsl:template match="item">
  <h2><a href="{link}"><xsl:apply-templates select="title" /></a></h2>
  <p><xsl:apply-templates select="description" disable-output-escaping="yes" /></p>
  <xsl:if test="pubDate"><small class="text-info"><xsl:apply-templates select="pubDate" /></small></xsl:if>
  <xsl:if test="updated"><small class="muted"><br /><xsl:apply-templates select="updated" /></small></xsl:if>
  <hr />
</xsl:template>

<xsl:template match="title">
  <xsl:value-of select="." />
</xsl:template>

<xsl:template match="description">
  <xsl:value-of select="." />
</xsl:template>

<xsl:template match="pubDate">
  <xsl:value-of select="." />
</xsl:template>

<xsl:template match="updated">
  <xsl:value-of select="." />
</xsl:template>

<xsl:template match="atom:link">
  <a href="{.}"><xsl:value-of select="." /></a>
</xsl:template>

<xsl:template match="link">
  <a href="{.}"><xsl:value-of select="." /></a>
</xsl:template>

</xsl:stylesheet>
