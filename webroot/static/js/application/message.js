/**
 * App.Message
 * @extends Ext.util.Observable
 * @author Chris Scott
 */
App.Message = function(config) {
	Ext.onReady(this.onReady, this);
	App.Message.superclass.constructor.apply(this, arguments);
}
Ext.extend(App.Message, Ext.util.Observable, {

	/***
	 * response status codes.
	 */
	STATUS_EXCEPTION :          "exception",
	STATUS_VALIDATION_ERROR :   "validation",
	STATUS_ERROR:               "error",
	STATUS_NOTICE:              "notice",
	STATUS_OK:                  "ok",
	STATUS_HELP:				"help",

	/***
	 * adds a message to queue.
	 * @param {String} msg
	 * @param {Bool} status
	 */
	addMessage : function(msg, status) {
		var delay = 3;	// <-- default delay of msg box is 1 second.
		if (status == false) {
			delay = 5;	// <-- when status is error, msg box delay is 3 seconds.
		}
		// add some smarts to msg's duration (div by 13.3 between 3 & 9 seconds)
		delay = msg.length / 13.3;
		if (delay < 3) {
			delay = 3;
		}
		else if (delay > 9) {
			delay = 9;
		}

		this.msgCt.alignTo(document, 't-t');
		Ext.DomHelper.append(this.msgCt, {
            html: this.buildMessageBox(
                    status,
                    String.format.apply(String, Array.prototype.slice.call(arguments, 1))
                )
       }, true)
       .slideIn('t')
       .pause(delay)
       .ghost("t", {remove:true});
	},

	onReady : function() {
		// create the msgBox container.  used for App.addMessage
		this.msgCt = Ext.DomHelper.insertFirst(document.body, {id:'msg-div'}, true);
		this.msgCt.setStyle('position', 'absolute');
		this.msgCt.setStyle('z-index', 9999);
		this.msgCt.setWidth(300);
	},

	/***
	 * buildMessageBox
	 */
	buildMessageBox : function(title, msg) {
		switch (title) {
			case true:
				title = this.STATUS_OK;
				break;
			case false:
				title = this.STATUS_ERROR;
				break;
		}
		return [
			'<div class="app-msg">',
			'<div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>',
			'<div class="x-box-ml"><div class="x-box-mr"><div class="x-box-mc"><h3 class="x-icon-text icon-status-' + title + '">', title, '</h3>', msg, '</div></div></div>',
			'<div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>',
			'</div>'
		].join("\n");
	}
});


App.Message = new App.Message(); 