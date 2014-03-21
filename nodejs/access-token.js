// npm install jwt-simple
var jwt = require('jwt-simple');

module.exports = function() {
    var wdApiId = 'demo',
        wdApiSecret = 'demo';

    var payload = {
        iss: 'https://wikidocs.com/v1/apps/' + wdApiId,
        iat: Math.round((new Date().getTime()/1000)),
        exp: Math.round((new Date().getTime()/1000)) + 3600*24,
        sub: 'userId-123',
        access: {}
    };
    payload.access['/content-123'] = 'full';

    return jwt.encode(payload, wdApiSecret);
}
