/**
 * @namespace App.tree
 */
Ext.ns('App.tree');
/**
 * @class App.tree.TreePanel
 */
App.tree.TreePanel = Ext.extend(Ext.tree.TreePanel, {
	/** @lends App.tree.TreePanel */
	useArrows: true,
	autoScroll: true,
	containerScroll: true,
	border: false,
	
	tools: [{
		id: 'refresh',
		handler: function(e, el, tree/*, config*/) {
			tree.getLoader().load(tree.getRootNode());
		}
	}],

	dataUrl: App.Core.getUrl('/backoffice/table/list'),
	rootVisible: false,
	root: {
		text: 'Menu',
		draggable: false,
		leaf: false, 
		children : [{
			text: 'Modules',
			draggable: false,
			leaf: false,
			expanded: true,
			cls : "folder",
			children : [{
				text: 'Users',
				leaf: true,
				module:{
					xtype: 'App.grid.User'
				}
			},{
				text: 'Transfers',
				leaf: true,
				module:{
					xtype: 'App.grid.Tranfer'
				}
			},{
				text: 'Products',
				leaf: true,
				module:{
					xtype: 'App.grid.Product'
				}
			},{
				text: 'Partner Statuses',
				leaf: true,
				module:{
					xtype: 'App.grid.PartnerStatus'
				}
			},{
				text: 'Calculation',
				leaf: true,
				module:{
					xtype: 'App.grid.Calculation'
				}
			}] 
		},{
			nodeType: 'async',
			text: 'Tables',
			leaf: false,
			draggable: false,
			id: 'table'
		}] 
	},
	initComponent : function() {
		App.tree.TreePanel.superclass.initComponent.call(this);
		this.on('click', this.onClick ,this)
	},
	
	onClick: function(node) {
		if (!node.leaf) {
			return;
		}
		var name = node.attributes.text;
		var tabPanel = Ext.getCmp('tabber'); //todo: find other method to get tab
		var tabs = tabPanel.find('title', name);

		if (tabs.length) {
			tabs[0].show();
		} else {
			if (node.attributes.module) {
				var tab = Ext.ComponentMgr.create(
						Ext.apply(
							node.attributes.module, 
							{title: name}
						)
				);
				tabPanel.add(tab).show();
			} else {
				Ext.Ajax.request({
					url: App.Core.getUrl('/backoffice/table/show/name/') + name,
					success: this.onRequestSuccess,
					scope: this
				});
			}	
		}
		
	},
	onRequestSuccess: function(response){
		var result = Ext.util.JSON.decode(response.responseText);
		if (result.name && result.cols) {
			var name = result.name;
			var tab = new App.grid.GridPanel({
				title: name,
				columns: result.cols,
				url: App.Core.getUrl('/backoffice/table/grid/name/') + name
			});
			Ext.getCmp('tabber').add(tab).show();
		}
	}
});
		
Ext.reg('App.tree.TreePanel', App.tree.TreePanel);