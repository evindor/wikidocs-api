var connect = require('connect'),
    http = require('http'),
    token = require('./access-token');

connect()
    .use(function(req, res, next) {
        if (req.url == '/token') {
            res.writeHead(200, {"Content-Type": "application/json"});
            res.write(JSON.stringify(token()));
            return res.end();
        }
        next();
    })
    .use(connect.static(__dirname))
    .listen(3030);
