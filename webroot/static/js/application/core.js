Ext.ns('App');
/**
 * @class Main App.Core core, a singleton
 */
App.Core = Ext.extend(Ext.util.Observable, {
	/** @lends App.Core */
	
	PHPSESSID: 'PHPSESSID',
	
	getUrl: function(url){
		return ''+ url;
	},
    
	logout : function() {
		Ext.Ajax.request({
			url: App.Core.getUrl('/auth/logout/'),
			success: function(){
				window.location.href = '/';
			}
		});
	},
	
	setUserIdentity : function(identity) { 
		this.userIdentity = identity;
	},

	setUserSettings : function(settings) {
		this.userSettings = settings;
	},

	isLoggedIn : function(yes, no) {
		var mask = new Ext.LoadMask(Ext.getBody(), {msg:"Please wait..."});
		mask.show();

		Ext.Ajax.request({
			url: App.Core.getUrl('/auth/info'),
			success: function(response){
				mask.hide();
				var result = Ext.util.JSON.decode(response.responseText);
				this.setUserIdentity(result.identity);
				if (result.identity && result.identity.id) {
					this.setUserSettings(result.settings);
					this.localize();
					yes.call(this);
				} else {
					no.call(this);
				}
			},
			failure: function(){
				mask.hide();
				//@todo: show static error screan
			},
			scope: this
		});
	},
	errorBox: function() {
		
	},
	start : function() {
		//add auto refresh for update session state
		//new Ext.Updater("loading").startAutoRefresh(250, App.Core.getUrl('/auth/info'));
        this.viewPort = new Ext.Viewport({
            layout: 'border',
            items: [{
                region: 'north',
                border: false
            },{
                region: 'center',
                xtype: 'tabpanel', // TabPanel itself has no title
                closeAction: 'hide',
                activeTab : 0,
                items: [{
                    //todo: add info or help tab
                    title: 'Help'
                },{
                    xtype: 'App.grid.User',
                    url: '/backoffice/users'
                }],
                id: 'tabber'
            },{
                region: 'west',
                title: 'Navigation',
                collapsible: true,
                //treepanel
                xtype: 'App.tree.TreePanel',
                width: 200,
                autoScroll: true,
                split: true
           }]
        });
        this.viewPort.show();
	}
});

App.Core = new App.Core();