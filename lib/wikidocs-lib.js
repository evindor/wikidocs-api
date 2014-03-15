function stateChangeHandler(elem, stateHtml) {
    return function () {
        elem.innerHTML = stateHtml;
    };
}
function trackConnectionStatus(app, elem) {
    app.on('connected'   , stateChangeHandler(elem, '<span style="color: green">connected</span>'));
    app.on('connecting'  , stateChangeHandler(elem, '<span style="color: yellow">connecting</span>'));
    app.on('disconnected', stateChangeHandler(elem, '<span style="color: red">disconnected</span>'));
}

function showOnlineUsers(doc, usersHTML) {
	function rerenderOnlineUsers() {
		while (usersHTML.firstChild) {
			usersHTML.removeChild(usersHTML.firstChild);
		}
		doc.subscriptions.forEach(function (session) {
			var u = document.createElement("span");
			u.style.color = '#' + wdColors[wdTelepointerId(session)];
			u.appendChild(document.createTextNode(session.sub + ' '));
			usersHTML.appendChild(u);
		});
	}
	doc.on('subscribed', rerenderOnlineUsers);
	doc.on('unsubscribed', rerenderOnlineUsers);
}

function wdTelepointerId(session) {
	function hashCode(str) {
		var hash = 0,
			chr,
			i;
		for (i = 0; i < str.length; i++) {
			chr = str.charCodeAt(i);
			hash = ((hash << 5) - hash) + chr;
			hash = hash & hash; // Convert to 32bit integer
		}
		return hash;
	}
	function tpHashCode(session) {
		var hc;
		var sub = session['sub'];
		if (null !== sub) {
			hc = hashCode('' + sub);
		} else {
			hc = hashCode(session['sid']);
		}
		return hc;
	}
	return (Math.abs(tpHashCode(session)) % 10);
}

var wdColors = {
	0: 'b82d88',
	1: '1f87c7',
	2: 'f5d607',
	3: 'aaa6d1',
	4: 'e94544',
	5: '95d0ce',
	6: 'd5bcb0',
	7: '49852d',
	8: 'f399a0',
	9: '881520'
};
