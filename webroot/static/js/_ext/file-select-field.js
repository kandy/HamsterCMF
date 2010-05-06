Ext.ns('App.form');

/**
 * @extends Ext.form.TriggerField 
 */
App.form.FileSelectField = Ext.extend(Ext.form.TriggerField , {
	readOnly: true,
	//@todo: add triggerClass 
	window: {},
	initComponent : function() {
		App.form.FileSelectField.superclass.initComponent.apply(this, arguments);
		this.window = new App.window.File();
		this.window.on('file-select', this.onFileSelect, this);
	},
	onTriggerClick: function() {
		this.window.show();
	},
	onFileSelect: function(row) {
		this.setValue(row.get('id'));
		this.window.hide();
	}
});

Ext.reg('App.form.FileSelectField', App.form.FileSelectField);
Ext.reg('fileselectfield', App.form.FileSelectField);
