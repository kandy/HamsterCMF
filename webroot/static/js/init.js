//Ext.BLANK_IMAGE_URL = '/ext/resources/images/default/s.gif';
Ext.ns('App');
(function(basePath) {
	var scripts = [
        'application/core.js',
        'application/grid.js',
        'application/user.js',
	];

	Ext.each(scripts, function(item){
		document.writeln(
			String.format('<script type="text/javascript" src="{0}{1}"></script>', basePath || '/', item)
		);
	});
})('/static/js/');
