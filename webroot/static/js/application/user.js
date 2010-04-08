/**
 * @class App.grid.User
 * @extends App.grid.GridPanel
 */
App.grid.User = Ext.extend(App.grid.GridPanel, {
	/** @lends App.grid.User */
	title: 'Users',
	columns: [{
        id: 'id',
        header: 'Id',
        width: 40,
        sortable: true,
        dataIndex: 'id'
    },{
        header: 'Name',
        dataIndex: 'username',
        width: 140,
        filter: {
            type: 'string'
        }
    },{
        header: 'Email',
        width: 120,
        dataIndex: 'email'
//			renderer: function(value, metaData, record) {
//				return record.get('partnerStatusName');
//			}
    },{
        header: 'Created at',
        width: 140,
        sortable: true,
        dataIndex: 'createdAt'
    }],
	/**
	 * initComponent
	 * @protected
	 */
	initComponent : function() {
		App.grid.User.superclass.initComponent.call(this);
	},
	createStoreConfig: function(){
		var storeConfig = App.grid.User.superclass.createStoreConfig.call(this);
//		storeConfig.fields.push({name: 'sponsor'});
//		storeConfig.fields.push({name: 'partnerStatusName'});
		return storeConfig;
	}
});

		
Ext.reg('App.grid.User', App.grid.User);
