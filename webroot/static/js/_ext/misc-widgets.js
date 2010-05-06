Ext.ns("App.Form");
/**
 * @class implements form element, a required checkbox
 */
App.Form.RequiredCheckbox = Ext.extend(Ext.form.Checkbox, {
	/** @lends App.Form.RequiredCheckbox */
	validateMessage: 'This checkbox must be checked.',
	msgTarget : 'under',

	isValid : function() {
		return this.checked;
	},

	handler: function(checkbox) {
		checkbox.validate();
	},

	validate : function(){
		if (this.checked) {
			// use implementation from Field as function is deactivated for Checkbox
			Ext.form.Field.prototype.clearInvalid.call(this);
		} else {
			// use implementation from Field as function is deactivated for Checkbox
			Ext.form.Field.prototype.markInvalid.call(this, this.validateMessage);
		}
		return this.checked;
	}
});
Ext.reg('App.Form.RequiredCheckbox', App.Form.RequiredCheckbox);


Ext.form.VTypes["tb"] = /^[\$]?[\d]*(.[\d]{2})?$/;
Ext.form.VTypes["tbMask"] = /[\d\$.]/;
Ext.form.VTypes["tbText"] = 'Not a valid tb amount.  Must be in the format "$123.45" ($ symbol and cents optional).';


Ext.override(Ext.TabPanel, {
	/**
	 * @cfg {String} closeAction
	 * The action to take when the close header tool is clicked:
	 *
	 * '{@link #close}' : Default
	 * {@link #close remove} the tab from the DOM and {@link Ext.Component#destroy destroy}
	 * it and all descendant Components. The tab will not be available to be
	 * redisplayed via the {@link #show} method.
	 *
	 * '{@link #hide}' :
	 * {@link #hide} the tab by setting visibility to hidden .
	 * The tab will be available to be redisplayed via the {@link #show} method.
	 */ 
	closeAction: 'close' ,
	// private
	onBeforeShowItem : function(item){
		this.unhideTabStripItem(item);
		if(item != this.activeTab){
			this.setActiveTab(item);
			return false;
		}
	},
	// private
	onStripMouseDown : function(e){
		if(e.button !== 0){
			return;
		}
		e.preventDefault();
		var t = this.findTargets(e);
		if(t.close){
			if (this.closeAction == 'close') {
				if (t.item.fireEvent('beforeclose', t.item) !== false) {
					t.item.fireEvent('close', t.item);
					this.remove(t.item);
				}
			} else {// closeAction == 'hide'
				this.hideTabStripItem(t.item);
				t.item.hide();
			}
			return;
		}
		if(t.item && t.item != this.activeTab){
			this.setActiveTab(t.item);
		}
	}
});

//Add support multi column tables 
Ext.override(Ext.data.DataWriter, {
	/**
	 * Converts a Record to a hash
	 * @param {Record}
	 * @private
	 */
	toHash : function(rec) {
		var map = rec.fields.map,
			data = {},
			raw = (this.writeAllFields === false && rec.phantom === false) ? rec.getChanges() : rec.data,
			m;
			
		if (Ext.isArray(this.meta.idProperty)) {
			for(var prop=0; prop < this.meta.idProperty.length; prop++) {
				if((m = map[this.meta.idProperty[prop]])){
					data[m.mapping ? m.mapping : m.name] = raw[this.meta.idProperty[prop]];
				}
			}
		} else {
			 data[this.meta.idProperty] = rec.id;
		}
		
		Ext.iterate(raw, function(prop, value){
			if((m = map[prop])){
				data[m.mapping ? m.mapping : m.name] = value;
			}
		});
		
		return data;
	}
});

Ext.override(Ext.data.DataReader, {
	isData : function(data) {
		if(data && Ext.isObject(data)) {
			if (Ext.isArray(this.meta.idProperty)) {
				for(var prop = 0; prop < this.meta.idProperty.length; prop++) {
					if (Ext.isEmpty(data[this.meta.idProperty[prop]])) {
						return false;
					}
				}
				return true;
			} else {
				return Ext.isEmpty(data[this.meta.idProperty]) ?false:true;
			}
		} else {
			return false;
		}
	}
});

Ext.override(Ext.data.JsonReader, {
	buildExtractors : function() {
		if(this.ef){
			return;
		}
		var s = this.meta, Record = this.recordType,
			f = Record.prototype.fields, fi = f.items, fl = f.length;
	
		if(s.totalProperty) {
			this.getTotal = this.getJsonAccessor(s.totalProperty);
		}
		if(s.successProperty) {
			this.getSuccess = this.getJsonAccessor(s.successProperty);
		}
		this.getRoot = s.root ? this.getJsonAccessor(s.root) : function(p){return p;};
		if (s.id || s.idProperty) {
			if (Ext.isArray(s.idProperty)) {
				var ids = {};
				for(var prop = 0; prop < this.meta.idProperty.length; prop++) {
					ids[prop] = this.getJsonAccessor(s.idProperty[prop]);
				}
				this.getId = function(rec) {
					var r =[];
					for (var prop in ids) {
						var f = ids[prop](rec);
						r.push(Ext.isEmpty(f)?null:f);
					}
					return r.join('-');
				};
				
			} else {
				var g = this.getJsonAccessor(s.id || s.idProperty);
				this.getId = function(rec) {
					var r = g(rec);
					return (r === undefined || r === "") ? null : r;
				};
			}
		} else {
			this.getId = function(){return null;};
		}
		var ef = [];
		for(var i = 0; i < fl; i++){
			f = fi[i];
			var map = (f.mapping !== undefined && f.mapping !== null) ? f.mapping : f.name;
			ef.push(this.getJsonAccessor(map));
		}
		this.ef = ef;
	}
});
