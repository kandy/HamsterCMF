<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"  
	xmlns="http://www.w3.org/1999/xhtml" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	
	<xsl:template match="content">
	<!-- hCard microformat -->
	<div id="hcard-{user/username}" class="vcard">
		<img  src="http://www.gravatar.com/avatar/{gravatar}" alt="photo of {user/username}" class="photo"/>
		<span class="fn n">
			<h2 class="given-name"><xsl:value-of select="user/username"/></h2>
			<!--
			<span class="additional-name"></span>
			<span class="family-name"></span>
			-->
		</span>
		
		<dl class="adr">
			<dt>Country:</dt> <dd class="country-name"><xsl:value-of select="user/countryCode"/></dd>
			<dt>Email:</dt> <dd><a class="email" href="mailto:{user/email}"><xsl:value-of select="user/email"/></a></dd>
			<dt>Phone:</dt> <dd class="tel"><xsl:value-of select="user/phone"/></dd>
		</dl>
	</div>
	</xsl:template>
		
</xsl:stylesheet>
