set "pathRedis=C:\wamp64\www\nosqlredis"
set "pathMongo=C:\Program Files\MongoDB\Server\4.4\bin"
set "pathElasticSearch=C:\Program Files\elasticsearch-7.13.0\bin"

cd %pathRedis%
start cmd /k redis-server.exe
start cmd /k redis-cli.exe

cd %pathMongo%
start cmd /k mongo

cd %pathElasticSearch%
start cmd /k elasticsearch.bat

cd /
cd wamp64\www\marketplace