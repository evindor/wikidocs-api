function wdTrackConnectionStatus(app, elem) {
	function stateChangeHandler(elem, stateHtml) {
		return function () {
			elem.innerHTML = stateHtml;
		};
	}
    app.on('connected'   , stateChangeHandler(elem, '<span style="color: green">connected</span>'));
    app.on('connecting'  , stateChangeHandler(elem, '<span style="color: yellow">connecting</span>'));
    app.on('disconnected', stateChangeHandler(elem, '<span style="color: red">disconnected</span>'));
}

function wdShowOnlineUsers(yourSid, doc, yourElem, usersElem) {
	// removes all element of a dom element
	function emptyElem(elem){
		while (elem.firstChild) {
			elem.removeChild(elem.firstChild);
		}
	}
	// renders a single user and inserts it in a container
	function renderUser(session, elem) {
		var u = document.createElement("span");
		u.style.color = '#' + wdColors[wdTelepointerId(session)];
		u.appendChild(document.createTextNode(session.sub + ' '));
		elem.appendChild(u);
	}
	// re-renders all users
	function rerenderOnlineUsers() {
		emptyElem(usersElem);
		emptyElem(yourElem);
		doc.subscriptions.forEach(function (session) {
			if (yourSid !== session.sid) {
				renderUser(session, usersElem);
			} else {
				renderUser(session, yourElem);
			}
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
// default Wikidocs colors (should be the same as the stylesheet colors)
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