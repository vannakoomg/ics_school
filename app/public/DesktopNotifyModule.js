var DesktopNotify = (function(){

	var bindUIElements = function() {
        	window.addEventListener('load', getPermission);
	};

	var init = function() {
		bindUIElements();
	};

    	var getPermission = function () {
		if (window.Notification && Notification.permission !== "granted") {
			Notification.requestPermission(function (status) {
				if (Notification.permission !== status) {
					Notification.permission = status;
				}
			});
		}
	};

    var send = function (message, tag) {

        if (typeof(tag) == "undefined") {
            tag = "default-notification";
        }

        if (window.Notification && Notification.permission === "granted") {
            new Notification(message, {tag: tag});
        }

        // If the user hasn't told if he wants to be notified or not
        // Note: because of Chrome, we are not sure the permission property
        // is set, therefore it's unsafe to check for the "default" value.
        else if (window.Notification && Notification.permission !== "denied") {
            Notification.requestPermission(function (status) {
                if (Notification.permission !== status) {
                    Notification.permission = status;
                }

                if (status === "granted") {
                    new Notification(message, {tag: tag});
                }

            });
        }
    };

	return {
		init: init,
		send: send
	}

})();

DesktopNotify.init();