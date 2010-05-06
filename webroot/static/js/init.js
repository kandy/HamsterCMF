(function(basePath, cached_version) {
	var scripts = [
		'ext/ext-base.js',
		'ext/ext-all.js',
		'ext/ux-all.js',
        'js/application/core.js',
        'js/application/grid.js',
        'js/application/editor-grid-panel.js',
        'js/application/user.js',
        'js/application/tree-panel.js'
	];

	for (var i in scripts) {
		document.writeln([
			'<script type="text/javascript" src="',
            basePath || '/',
            scripts[i],
            '?',
            cached_version || +(new Date()),
			'"></script>'
		].join(''));
    }
})('/static/', false);
