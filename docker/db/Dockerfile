FROM mariadb:latest

RUN chown -R mysql:mysql /var/lib/mysql

COPY docker-entrypoint-initdb.d /docker-entrypoint-initdb.d
COPY config.cnf /etc/mysql/my.cnf

RUN chmod a-w /etc/mysql/my.cnf

EXPOSE 3306

CMD ["mysqld"]
