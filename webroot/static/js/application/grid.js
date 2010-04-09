/**
 * @namespace App.grid
 */
Ext.ns('App.grid')


/**
 * Class use one configuration for create store, grid and filters
 * 
 * @class Defautl grid panel for our App.Core
 * @extends Ext.grid.GridPanel
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
			}
		}]
	</code>
 */
App.grid.GridPanel = Ext.extend(Ext.grid.GridPanel, {
	/** @lends App.grid.GridPanel */
	
	border: false,
	loadMask: true,
	forceFit: true,
	
	autoDestroy: false,
	closable: true,
	/**
	 * 
	 * @type {Object} 
	 */
	storeConfig: {
		remoteSort: true,
		method: 'POST',
		idProperty: 'id',
		root: 'data',
		totalProperty: 'total',
		successProperty: 'success'
		// need set url in inherit class for store work 
	},
	viewConfig: {
		forceFit: true
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
	 * InitComponent {@see Ext.grid.GridPanel.initComponent}
	 * Create store, plugins, toolbar
	 * @protected
	 */
	initComponent : function() {
		if (this.url) {
			this.storeConfig.url =  this.url;
		}
		
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
		App.grid.GridPanel.superclass.initComponent.call(this);
		// set callback for render event
		this.on('afterrender', this.onAfterGridRender, this);
	},
	
	/**
	 * On render event load data to store
	 * @protected
	 */
	onAfterGridRender: function() {
		this.getStore().load(); //@todo: check it can move to stire config (autoLoad)
	},
	
	onException : function(){
        alert('Error: @todo: Create message box');
		//App.Core.showInternalServerErrorMessageBox();
	},
	
	/**
	 * Create store configuration from columns
	 * @return {Object}
	 */
	createStoreConfig: function() {
		var fields = [];
		for( var i=0; i < this.columns.length; i++) {
			//map grid fieds name to store fieds name  
			var field = {
					name: this.columns[i].dataIndex
				};
			fields[i] = field;
		}
		//add fields to storeConfig end return
		return Ext.apply({fields:fields}, this.storeConfig);
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
		}
	},
	
	/**
	 * Get Filtres plugin, from columns list 	
	 * type is ['numeric', 'string', 'date', 'list', 'boolean']
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

Ext.reg('App.grid.GridPanel', App.grid.GridPanel);

