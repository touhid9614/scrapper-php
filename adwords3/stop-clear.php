<?php

exec ("ps aux |  grep -i php | grep clear.php | grep -v grep | awk '{print $2}' | xargs kill");
exec ("ps aux |  grep -i php | grep gubagoo-query.php | grep -v grep | awk '{print $2}' | xargs kill");
exec ("ps aux |  grep -i php | grep -v grep | awk '{print $2}' | xargs kill");
