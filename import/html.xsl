<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="utf-8" indent="yes"/>
<xsl:template match="article">
<xsl:for-each select="textfile[@type='maintext']/paragraph">
	<xsl:if test="txt != ''">
<!--
		<xsl:if test="@style = 'h0'">
			<h1><xsl:value-of select="txt" /></h1>
		</xsl:if>
-->
		<xsl:if test="@style = 'ov0'">
			<h2><xsl:value-of select="txt" /></h2>
		</xsl:if>
		<xsl:if test="@style = 'z0'">
			<h3><xsl:value-of select="txt" /></h3>
		</xsl:if>
		<xsl:if test="@style = 'g0'">
			<p><xsl:value-of select="txt" /></p>
		</xsl:if>
	</xsl:if>
</xsl:for-each>
<!--
<xsl:for-each select="textfile[@type='picturetext']">
	<img>
		<xsl:attribute name="src">
			<xsl:value-of select="@originalfilename" />
		</xsl:attribute>
		<xsl:attribute name="alt">
			<xsl:for-each select="paragraph">
				<xsl:if test="@style = 'b0'"><xsl:value-of select="txt" /></xsl:if><xsl:if test="@style = 'b9'"> (<xsl:value-of select="txt" />)</xsl:if>
			</xsl:for-each>
		</xsl:attribute>
	</img>
</xsl:for-each>
-->
</xsl:template>
</xsl:stylesheet>