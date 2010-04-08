<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" 
	xmlns="http://www.w3.org/1999/xhtml"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="xml" encoding="UTF-8" indent="yes"
		omit-xml-declaration="yes"
		doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"
		doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN" />
	<xsl:preserve-space elements="pre" />
	
	<xsl:include href="decorator.xsl"/>
	
	<xsl:variable name="widgets.path">/xml/widgets</xsl:variable>
	<xsl:param name="basePath">/</xsl:param>
	<xsl:param name="mainServer"></xsl:param>
	<xsl:param name="staticServer"></xsl:param>
	
	<xsl:template match="content">
		<xsl:call-template name="window-decorator">
			<xsl:with-param name="contents">
				<xsl:apply-templates></xsl:apply-templates>
	    	</xsl:with-param>
	    	<xsl:with-param name="title"><xsl:text>Products</xsl:text></xsl:with-param>
	  	</xsl:call-template>
	</xsl:template>

	
	<xsl:template match="title">
		<xsl:value-of select="." />
	</xsl:template>
	
	
	<xsl:template match="widgets">
		<xsl:apply-templates select="default/auth/login"/>
	</xsl:template>
	
	
	<xsl:template match="/">
		<html xmlns="http://www.w3.org/1999/xhtml">

		<head>
			<title><xsl:value-of select="$mainServer"></xsl:value-of> </title>
		<link href="/static/css/main.css" media="all" rel="stylesheet" type="text/css" />
			<link href="favicon.ico" rel="shortcut icon"/>
			<link href="/static/favicon.png" type="image/png" rel="shortcut icon"/>

			<script charset="utf-8" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript">&#160;</script>
			<script charset="utf-8" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js" type="text/javascript">&#160;</script>
			
		</head>

<!-- Special block for ie -->
<xsl:comment><![CDATA[[if lt IE 7]> <body class="ie6"> <![endif]]]></xsl:comment> 
<xsl:comment><![CDATA[[if IE 7]> <body class="ie7"> <![endif]]]></xsl:comment>
<xsl:comment><![CDATA[[if IE 8]> <body class="ie8"> <![endif]]]></xsl:comment>
<xsl:comment>[if !IE]></xsl:comment> 
<body class="nginx-replace-me"> 
<xsl:comment><![CDATA[<![endif]]]></xsl:comment>
<!-- /Special block for ie -->
			<div id="page" class="sizer">
				<div class="clear header-height" ></div>	
				<div id="layout" >
					<div id="content" >
					<!-- Content -->
						<!-- Center Col -->
						<div class="center-col">
							<xsl:apply-templates select="/xml/content" />
						</div>
						<!-- /Center Col -->
						
						<!-- Right Col -->
						<div class="right-col">
							<xsl:apply-templates select="/xml/widgets/*/*/*/position[text()='right']/.."/>
						</div>
						<!-- /Right Col -->
						
						<!-- Left Col -->
						<div class="left-col">
							<xsl:call-template name="window-decorator">
								<xsl:with-param name="title"><xsl:text>Navigation</xsl:text></xsl:with-param>
								<xsl:with-param name="contents">
									<ul>
										<li class="first selected"><a href="http://{$mainServer}/a/blog/?user=PartnerStandard"><span>Blog</span></a></li>
										<li><a href="http://{$mainServer}/a/blog/index/add"><span>Add Post</span></a></li>
										<li class="last"><a href="#"><span>Test link</span></a></li>
									</ul>
						    	</xsl:with-param>
						  	</xsl:call-template>
						</div>
						<!-- /Left Col -->
					<!-- Content -->
					</div>
				</div>
		
				<div class="header-height sizer" id="header">
					<!-- HEADER-->
					<div class="window mainPanel">
						<div class="wbody">
							<xsl:apply-templates select="/xml/widgets/blog/auth/info"/>
						</div>
						<div class="footer">
							<span class="botton"></span>
							<span class="icon">&#160;</span>
							<span class="text"></span>
						</div>

					</div>
					<!-- /HEADER-->
				</div>
		
				<div class="clear footer-height" ></div>
				
			</div>
			<div class="footer-height sizer" id="footer">
				<!-- Footer -->
				<div class="window mainPanel">
					<div class="header">
						<span class="botton"></span>
						<span class="icon"></span>
						<span class="text">
							footer
						</span>
					</div>
					<div class="wbody">
						Treebune © 2009
					</div>
				</div>
				<!-- /Footer -->
		 	</div>
		</body>
		</html>
	</xsl:template>
	
</xsl:stylesheet>