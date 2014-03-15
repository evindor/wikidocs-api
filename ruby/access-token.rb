# sudo gem install jwt
require 'JWT'

wdApiId = 'demo'
wdApiSecret = 'demo'

payload = {
	"iss" => 'https://wikidocs.com/v1/apps/' + wdApiId,
	"iat" => Time.now.getutc.to_i,
	"exp" => Time.now.getutc.to_i + 3600*24,
	"sub" => "userId-123",
	"access" => {
		"/content-123" => "full"
	}
};

accessToken = JWT.encode(payload, wdApiSecret)

print accessToken, "\n"