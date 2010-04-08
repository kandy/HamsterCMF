<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" 
	xmlns="http://www.w3.org/1999/xhtml"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:php="http://php.net/xsl"
	>

	<xsl:output method="xml" encoding="UTF-8" indent="yes"
		doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"
		doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"
		omit-xml-declaration="yes" 
		media-type="text/html"/>
	<xsl:preserve-space elements="pre" />
	
	<xsl:template match="/">
		<html>
			<head>
				<title>Ulybka</title>
			</head>
			<body>
				<xsl:apply-templates select="/xml/content"/>
			</body>
		</html>
	</xsl:template>
	
	<xsl:template match="content">
		<h1>Hi user!</h1>
		Email confirm code is <a href="/user/confirm-email-code/?code={parameter/code}"><xsl:value-of select="parameter/code"/></a>
	</xsl:template>
	
</xsl:stylesheet>
