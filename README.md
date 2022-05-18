# ONE TIME SHARE PASSWORD AND SECRET

*Keep sensitive info out of your email & chat logs.*

## What is a One Time Secret? ##

A one-time secret is a link that can be viewed only once. A single-use URL.


## Why would I want to use it? ##

When you send people sensitive info like passwords and private links via email or chat, there are copies of that information stored in many places. If you use a one-time link instead, the information persists for a single viewing which means it can't be read by someone else later. This allows you to send sensitive information in a safe way knowing it's seen by one person only. Think of it like a self-destructing message.

## Dependencies

* Any recent Linux or windows platform that run PHP 7.2+ 
* No DB required 

## CronJob
* run cronjob every 1 hour to file "cron.php"
* syntax "0 * * * *"
e.g: "0 * * * * wget -q -O - https://xxx.xxx.com/cron.php >/dev/null 2>&1"



## Install One-Time Secret

* simple copy & past
* for more security please change "hiddentunnel" path and name in the index.php file
