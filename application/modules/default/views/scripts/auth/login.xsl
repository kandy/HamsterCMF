<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"  
	xmlns="http://www.w3.org/1999/xhtml" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:template match="content|login">
		<xsl:for-each select="messages/*">
			<div class="message error">
				<xsl:value-of select="text()"></xsl:value-of>
			</div>
		</xsl:for-each>
		<xsl:copy-of select="form/form" />
	</xsl:template>
	
</xsl:stylesheet>
