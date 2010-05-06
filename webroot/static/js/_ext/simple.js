Ext.ns('App.form');

/**
 * @extends App.form.FormPanel
 */
App.form.Simple = Ext.extend(App.form.FormPanel, {
	/** @lends App.form.Simple */
	defaults: {
		width: 265,
		msgTarget: 'side'
	},
	authHeight: true,
	frame: true,
	width: 400,
	grid: null,
	defaultType: 'textfield',
	text: {
		title: {
			globalErrors:"Product do not save"
		},
		button: {
			submit: "Save"
		},
		msg: {
			title: 'Opearation success'
		},
		error: {
			//errorCode: 'text'
		},
		fieldError: {
			//fidname: {errorCode: 'text'}
		}
	},
	
	buttons: [],
	
	initComponent : function() {
		App.form.Simple.superclass.initComponent.apply(this, arguments);
		this.getForm().url = this.url;
		this.addButton({
			text: this.text.button.submit,
			handler: this.actionSubmit,
			scope: this,
			formBind: true
		});
	},

	actionSubmit: function(button, event) {
		this.getForm().submit({
			success: this.handlerSubmitSuccess,
			failure: this.handlerSubmitFailure,
			scope: this,
			clientValidation: true
		});
	},

	handlerSubmitSuccess:  function(form, action) {
	}
});

Ext.reg('App.form.Simple', App.form.Simple);
