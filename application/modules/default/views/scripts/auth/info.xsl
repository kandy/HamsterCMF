<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"  
	xmlns="http://www.w3.org/1999/xhtml" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:template match="info">
		<xsl:if test="identity/id">
		<div class="identity">
			<div>Username: <xsl:value-of select="identity/username"></xsl:value-of></div>
			<div>Action: <a href="http://{$mainServer}/auth/logout">logout</a></div>
		</div>
		</xsl:if>
	</xsl:template>
	
</xsl:stylesheet>
