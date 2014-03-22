var connect = require('connect'),
    http = require('http'),
    wd = require('wikidocs');

connect()
    .use(function(req, res, next) {
        if (req.url == '/token') {
            res.writeHead(200, {"Content-Type": "application/json"});
            res.write(JSON.stringify(wd.generateAccessToken({
                wdAppId: 'demo',
                wdAppSecret: 'demo',
                userId: '123',
                access: {'/content-123': 'full'},
            })));
            return res.end();
        }
        next();
    })
    .use(connect.static(__dirname))
    .listen(3030);
