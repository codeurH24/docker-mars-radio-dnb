FROM mattrayner/lamp:build-167-1804-php7

ADD run_server.sh /run_server.sh
RUN chmod +x /run_server.sh
# CMD ["/run_server.sh"]

ADD supervisord-server-symfony.conf /etc/supervisor/conf.d/supervisord-server-symfony.conf

RUN mkdir /stack

ADD create_mysql_user.sh /create_mysql_user.sh
RUN chmod +x /create_mysql_user.sh
ADD supervisord-z-create-mysql-user.conf /etc/supervisor/conf.d/supervisord-z-create-mysql-user.conf

CMD ["/run.sh"]

