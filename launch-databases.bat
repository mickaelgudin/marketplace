set "pathRedis=C:\Users\MGUD.GROUP\OneDrive - Hardis Group\Documents\Redis-x64-3.2.100"
set "pathMongo=C:\Program Files\MongoDB\Server\4.4\bin"
set "pathElasticSearch=C:\Users\MGUD.GROUP\OneDrive - Hardis Group\Documents\elasticsearch-7.13.0\bin"

cd %pathRedis%
start cmd /k redis-server.exe
start cmd /k redis-cli.exe

cd %pathMongo%
start cmd /k mongo

cd %pathElasticSearch%
start cmd /k elasticsearch.bat

cd /
cd wamp64\www\marketplace