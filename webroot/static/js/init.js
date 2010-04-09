(function(basePath) {
	var scripts = [
		'ext/ext-base.js',
		'ext/ext-all.js',
		'ext/ux-all.js',
        'js/application/core.js',
        'js/application/grid.js',
        'js/application/user.js',
	];

	for (i in scripts) {
		document.writeln([
			'<script type="text/javascript" src="',
            basePath || '/',
            scripts[i],
			'"></script>'
		].join(''));
    }
})('/static/');
