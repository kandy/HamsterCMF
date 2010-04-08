<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"  
	xmlns="http://www.w3.org/1999/xhtml" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	
	<xsl:template match="content">
		<h2>Confirm code</h2>
		<form method="POST" action="/user/confirm-email-code">
			<div>
				Code: <input type="text" name="code" value="{code}"/>
				<input title="Submit" type="submit" value="Confirm" />
			</div>
		</form>
	</xsl:template>
		
</xsl:stylesheet>
