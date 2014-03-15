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
