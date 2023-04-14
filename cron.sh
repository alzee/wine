#!/bin/bash
#
# vim:ft=sh
# 5 5 * * * /home/al/w/jiu/cron.sh

############### Variables ###############

############### Functions ###############

############### Main Part ###############

cd ~/w/jiu/
. .env.local

# DATABASE_URL="mysql://root:toor@127.0.0.1:3306/jiu?serverVersion=mariadb-10.5.18&charset=utf8mb4"
# echo $DATABASE_URL
t=${DATABASE_URL#*//} # root:toor@127.0.0.1:3306/jiu?serverVersion=mariadb-10.5.18&charset=utf8mb4
user=${t%%:*}
# echo $user
tt=${t%%@*} # root:toor
passwd=${tt##*\:}
# echo $passwd
tt=${t%%\?*} # root:toor@127.0.0.1:3306/jiu
db=${tt##*/}
# echo $db
tt=${t#*@} # 127.0.0.1:3306/jiu
host=${tt%\:*}
# echo $host
tt=${tt#*\:} # 3306/jiu
port=${tt%/*}
# echo $port

dir=~/w/$db.sql
mkdir -p $dir; cd $dir
git status &> /dev/null
[ "$?" -eq 128 ] && git init
mysqldump --skip-extended-insert -u$user -p$passwd -h $host -P $port $db  > $db.sql
git add .
git commit -m "mysqldump" --no-gpg-sign > /dev/null
git push &> /dev/null
