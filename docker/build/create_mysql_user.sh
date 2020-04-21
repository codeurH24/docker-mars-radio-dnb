#!/bin/bash
if [ -e /stack/create_mysql_user.log]
then
    echo "Fichier create_mysql_user.log existe" >> /stack.log
else
    touch /stack/create_mysql_user.log
    mysql -u root -e "CREATE USER 'codeurh24'@'%' IDENTIFIED BY 'password';"
    mysql -u root -e "GRANT ALL PRIVILEGES ON *.* TO 'codeurh24'@'%';"
    echo "User mysql created" >> /stack.log
fi

exit