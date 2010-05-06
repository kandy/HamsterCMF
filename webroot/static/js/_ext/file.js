Ext.ns('App.window');

/**
 * @extends Ext.Window
 */
App.window.File = Ext.extend(Ext.Window, {
	title: 'Select file',
	closeAction: 'hide',
	width: 600,
	height:400,
	layout:'border',
	plain: true,
	components: [{
		xtype: 'App.grid.GridPanel',
		region: 'center',
		url: App.Core.getUrl('/backoffice/file/grid'),
		columns: [{
				id: 'id', 
				header: 'Id', 
				width: 40, 
				sortable: true, 
				dataIndex: 'id'
			},{
				header: 'Name', 
				dataIndex: 'name',
				width: 140,
				filter: {
					type: 'string'
				}
			}, {
				header: 'Preview',
				sortable: false, 
				dataIndex: 'id',
				renderer: function(value){
					return String.format('<a href="/a/index/file/id/{0}" target="_blanck"><img src="/a/index/file-preview/id/{0}" /></a>', value);
				}
			}]
		}, {
		region: 'south',
		collapsible: true,
		xtype: 'form',
		frame: true,
		hideBorders: true,
		hideLabels :true,
		fileUpload: true,
		height: 44,
		padding: 5,
		items: [{
				xtype: 'fileuploadfield',
				width: 300,
				fieldLabel: '',
				name: 'file'
			}	
		]
	}],
	
	getGrid: function(){
		return this.items.get(0);
	},
	getFormPanel: function(){
		return this.items.get(1);
	},
	
	initComponent : function() {
		this.addEvents(['file-select']);
		App.window.File.superclass.initComponent.apply(this, arguments);
		this.add(this.components);
		this.addButton('Upload', this.onSubmit, this);
		
		this.getGrid().on('rowdblclick', this.onRowDblClick, this);
	},
	onSubmit: function() {
		this.getFormPanel().getForm().submit({
			url: App.Core.getUrl('/backoffice/file/upload'),
			success: function() {
				this.getGrid().getStore().load();
				this.getFormPanel().getForm().reset();
			},
			scope: this
		});
	},
	onRowDblClick: function (grid, rowIndex, e) {
		this.fireEvent('file-select', grid.getStore().getAt(rowIndex));
	}
});