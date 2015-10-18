#!/usr/bin/bash
cmd="/application/php/bin/php /data/www/filter/http_server.php"
count=`ps aux |grep "$cmd" | grep -v "grep" | wc -l`

echo $count
if [ $count -lt 1 ]; then
ps aux |grep "$cmd" | grep -v "grep"| awk '{print $2}'|xargs kill -9
sleep 2
$cmd
echo "restart "$(date +%Y-%m-%d_%H:%M:%S) >/data/log/restart.log
fi
