/**
 * @namespace App.grid
 */
Ext.ns('App.grid');

/**
 * Class use one configuration for create store, grid and filters
 * 
 * @class App.grid.EditorGridPanel Defautl grid panel for our App.Core
 * @extends Ext.grid.EditorGridPanel
 * @constructor
 * @example
 * <code>
	columns: [
		{
			id: 'id', 
			header: 'Id', 
			sortable: true, 
			dataIndex: 'id',
			align: 'right',
			filter: { //add filter
				type: 'numeric' //if not set type used defaultFilter.type
			},
			editor: {
				xtype: 'textfield' // or other form fields editor 
			}
		}]
	</code>
 */
App.grid.EditorGridPanel = Ext.extend(Ext.grid.EditorGridPanel, {
	/** @lends App.grid.EditorGridPanel */
	url: null,
	border: false,
	loadMask: true,
	
	autoDestroy: false,
	closable: true,
	
	viewConfig: {
		forceFit: true
	},

	/**
	 * 
	 * @type {Object} 
	 */
	storeConfig: {
		autoDestroy: true,
		autoSave: false,
		remoteSort: true,
		method: 'POST',
		idProperty: 'id',
		root: 'data',
		totalProperty: 'total',
		successProperty: 'success'
		// need set url in inherit class for store work 
	},
	singleSelect: false,
	/**
	 * Default properties for filter create
	 * @type {Object} 
	 */
	defaultFilter: {
		type: 'string'
	},
	
	/**
	 * InitComponent {@see Ext.grid.EditorGridPanel.initComponent}
	 * Create store, plugins, toolbar
	 * @protected
	 */
	initComponent : function() {
		this.selModel = new Ext.grid.RowSelectionModel(this.singleSelect);
		// init filter plugin
		this.plugins = [this.createGridFilters()];
		//init store
		this.ds = new Ext.data.JsonStore(this.createStoreConfig());
		//atach event on exception
		this.ds.on('exception', this.onException, this);
		//init bottom toolbar use PagingToolbar
		this.bbar = new Ext.PagingToolbar(this.createPagingToolbarConfig(this.ds, this.plugins));
		//call parent init
		App.grid.EditorGridPanel.superclass.initComponent.call(this);
		// set callback for render event
		this.on('afterrender', this.onAfterGridRender, this);
		
		this.getBottomToolbar().add([
				'-', {
					text: 'Add',
					handler: this.onAdd,
					scope: this
				}, {
					text: 'Delete',
					handler: this.onDelete,
					scope: this
				}, {
					text: 'Save',
					handler: this.onSave,
					scope: this
				}]);
				
		this.menu = new Ext.menu.Menu({ //todo: use grid.fireEvent(item.event)
			grid: this.grid,
			items: [{
				text: 'Add',
				handler: this.onAdd,
				scope: this
			}, {
				text: 'Delete',
				handler: this.onDelete,
				scope: this
			}, {
				text: 'Save',
				handler: this.onSave,
				scope: this
			}]
		});
		this.on('rowcontextmenu', this.onRowContextMenu, this);
	},
	
	/**
	 * Add grid menu
	 * @param {App.grid.EditorGridPanel} grid
	 * @param {Integer} rowIndex
	 * @param {Ext.EventObject} e
	 */
	onRowContextMenu: function(grid, rowIndex, e){
		e.preventDefault(); // do not show standard browser menu
		this.menu.showAt([e.getPageX(),  e.getPageY()]);
	},
	/**
	 * onAdd
	 */
	onAdd: function (btn, ev) {
		this.store.add(new this.store.recordType({}));
	},
	/**
	 * onDelete
	 */
	onDelete: function () {
		var recs = this.getSelectionModel().getSelections();
		if (!recs.length) {
			return;
		}
		 
		for (var i = 0; i < recs.length; i++) {
			this.store.remove(recs[i]);
		}
		this.store.save();
	},
	/**
	 * onSave
	 */
	onSave: function () {
		this.store.save()
	},	/**
	 * On after render event load data to store
	 * @protected
	 */
	onAfterGridRender: function() {
		this.getStore().load();
	},
	
	onException : function(){
		alert('Editor-grid error');
	},
	
	/**
	 * Create store configuration from columns
	 * @return {Object}
	 */
	createStoreConfig: function() {
		var storeConfig = {};
		storeConfig.fields = [];
		for( var i=0; i < this.columns.length; i++) {
			//map grid fieds name to store fieds name  
			var field = {
					name: this.columns[i].dataIndex
				};
			if (this.columns[i].type) {
				field.type = this.columns[i].type;
			}
			storeConfig.fields[i] = field;
		}
		
		storeConfig.writer = new Ext.data.JsonWriter();
		
		if (typeof this.url == 'undefined') {
			throw 'Not set url in App.grid.EditorGridPanel';
		}
		
		storeConfig.proxy = new Ext.data.HttpProxy({
			api: {
				read : this.url + '/grid/',
				create : this.url + '/create/',
				update : this.url + '/save/',
				destroy : this.url + '/delete/'
			}
		});
		
		//add fields to storeConfig end return
		return Ext.apply(storeConfig, this.storeConfig);
	},
	
	/**
	 * Create paging toolbar config
	 * @param {Ext.data.Store} store
	 * @param {Array} plugins
	 * @return {Object}
	 */
	createPagingToolbarConfig: function(store, plugins){
		return {
			store: store,
			plugins: plugins,
			pageSize: 25
		};
	},
	
	/**
	 * Get Filtres plugin, from columns list 	
	 * type is ['numeric', 'string', 'date', 'list','boolean']
	 * 
	 * @return Ext.ux.grid.GridFilters
	 */
	createGridFilters: function() {
		var filters = [];
		for( var i=0; i < this.columns.length; i++) {
			if (!this.columns[i].filter) {
				continue;
			}
			var filter = {};
			//copy grid dataIndex to store dataIndex
			filter.dataIndex = this.columns[i].dataIndex;
			// extends filter by defaults values
			filter = Ext.apply(filter, this.columns[i].filter, this.defaultFilter);	
			filters[i] = filter;
		}
		//create GridFilters plugin and return
		return new Ext.ux.grid.GridFilters({filters: filters});
	}
});
