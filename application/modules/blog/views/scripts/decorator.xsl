<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	
	<!-- 
		Window decorator
		@param contents - node to decorate
		@param title - title content
		@param class - class add to window class
		 
	 -->
	<xsl:template name="window-decorator">
		<xsl:param name="contents">
			<xsl:apply-templates/>
		</xsl:param>
		<xsl:param name="title"></xsl:param>
		<xsl:param name="class"></xsl:param>
		<div class="window {$class}">
			<div class="header">
				<span class="botton"></span>
				<span class="icon"></span>
				<span class="text">
					<xsl:copy-of select="$title"/>
				</span>
			</div>
			<div class="wbody">
				<div class="body">
					<xsl:copy-of select="$contents"/>
				</div>
			</div>
			<div class="footer">
				<span class="botton"></span>
				<span class="icon">&#160;</span>
				<span class="text"></span>
			</div>
		</div>
	</xsl:template>

</xsl:stylesheet>