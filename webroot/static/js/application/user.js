/**
 * @class App.grid.User
 * @extends App.grid.GridPanel
 */
App.grid.User = Ext.extend(App.grid.EditorGridPanel, {
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
        },
        editor: { xtype: 'textfield'}
    	
    },{
        header: 'Email',
        width: 120,
        dataIndex: 'email',
        editor: { xtype: 'textfield', vtype: 'email'}
//			renderer: function(value, metaData, record) {
//				return record.get('partnerStatusName');
//			}
    },{
        header: 'Created at',
        width: 140,
        sortable: true,
        dataIndex: 'createdAt',
        editor: { xtype: 'datefield'}
    }],
	/**
	 * initComponent
	 * @protected
	 */
	initComponent : function() {
		App.grid.User.superclass.initComponent.call(this);
   		this.getBottomToolbar()
            .add(['-', {
					text: 'Add',
					handler: function(){
                        new Ext.Window({
                            title: 'Compose message',
                            collapsible: true,
                            maximizable: true,
                            width: 750,
                            height: 500,
                            minWidth: 300,
                            minHeight: 200,
                            layout: 'fit',
                            plain: true,
                            bodyStyle: 'padding: 5px;',
                            buttonAlign: 'center',
                            items: [{
                                xtype: 'form',
                                baseCls: 'x-plain',

                                defaults: {
                                    label: 55,
                                    xtype: 'textfield',
                                    anchor:'100%',
                                },
                                items: [{
                                    xtype: 'combo',
                                    store: ['test@example.com', 'someone-else@example.com' ],
                                    fieldLabel: 'Send To',
                                    name: 'to'
                                },{
                                    fieldLabel: 'Subject',
                                    name: 'subject'
                                }, {
                                    xtype: 'textarea',
                                    fieldLabel: 'Message text',
                                    hideLabel: true,
                                    name: 'msg',
                                }]
                            }],
                            buttons: [{
                                text: 'Send'
                            },{
                                text: 'Cancel'
                            }]
                        }).show();
                    },
					scope: this
				}]);

        
	},
	createStoreConfig: function(){
		var storeConfig = App.grid.User.superclass.createStoreConfig.call(this);
//		storeConfig.fields.push({name: 'sponsor'});
//		storeConfig.fields.push({name: 'partnerStatusName'});
		return storeConfig;
	}
});

		
Ext.reg('App.grid.User', App.grid.User);
