<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE stylesheet [
  <!ENTITY % w3centities-f PUBLIC "-//W3C//ENTITIES Combined Set//EN//XML" "http://www.w3.org/2003/entities/2007/w3centities-f.ent">
]>
<xsl:stylesheet version="1.0"
  xmlns="http://www.w3.org/1999/xhtml"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:content="http://purl.org/rss/1.0/modules/content/"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:atom="http://www.w3.org/2005/Atom"
  xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
  xmlns:wfw="http://wellformedweb.org/CommentAPI/"
  xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
  exclude-result-prefixes=""
>
<xsl:output method="html"
  doctype-system='http://www.w3.org/TR/html4/strict.dtd'
  doctype-public='-//W3C//DTD HTML 4.01//EN'
  omit-xml-declaration="yes"
  indent="yes" />

<xsl:template match="/">
  <xsl:apply-templates select="rss/channel" />
</xsl:template>

<xsl:template match="rss/channel">

<html>
<head>
  <title><xsl:value-of select="atom:title" /></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="./bootstrap.min.css" />
  <style> body { padding-top: 60px; } </style>
  <link rel="stylesheet" type="text/css" href="./bootstrap-responsive.min.css" />
</head>

<body>

<div class="navbar navbar-fixed-top"><div class="navbar-inner"><div class="container">
  <a href="{link}" class="brand" title="{description}"><xsl:apply-templates select="title" /></a>
  <ul class="nav pull-right"><li>
  <a class="pull-right" href="http://wikipedia.org/wiki/RSS"><img src="./../img/rss.png" /></a>
  </li></ul>
</div></div></div>

<div class="container">
<xsl:apply-templates select="item" />
<xsl:if test="copyright">
	<xsl:apply-templates select="copyright" />
</xsl:if>
</div>

</body>
</html>

</xsl:template>

<xsl:template match="item">
  <h2><a href="{link}"><xsl:value-of select="title" /></a></h2>
  <xsl:choose>
    <xsl:when test="content:encoded">
      <xsl:value-of select="content:encoded" disable-output-escaping="yes" />
    </xsl:when>
    <xsl:otherwise>
      <xsl:value-of select="description" disable-output-escaping="yes" />
    </xsl:otherwise>
  </xsl:choose>
  <xsl:choose>
    <xsl:when test="updated">
      <xsl:apply-templates select="updated" />
    </xsl:when>
    <xsl:otherwise>
      <xsl:if test="pubDate"><xsl:apply-templates select="pubDate" /></xsl:if>
    </xsl:otherwise>
  </xsl:choose>
  <hr />
</xsl:template>

<xsl:template match="pubDate">
  <small class="text-info"><i class="icon-calendar"></i><xsl:value-of select="." /></small>
</xsl:template>

<xsl:template match="updated">
  <small class="muted"><xsl:value-of select="." /></small>
</xsl:template>

<xsl:template match="atom:link">
  <a href="{.}"><xsl:value-of select="." /></a>
</xsl:template>

<xsl:template match="link">
  <a href="{.}"><xsl:value-of select="." /></a>
</xsl:template>

<xsl:template match="copyright">
  <p class="muted"><xsl:value-of select="." /></p>
</xsl:template>

</xsl:stylesheet>
