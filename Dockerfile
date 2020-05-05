FROM mattrayner/lamp:latest-1804
WORKDIR /app

EXPOSE 80/tcp

COPY ./web/ ./
COPY ./DB.sql /tmp

RUN sed -i '6i\\t\tDirectoryIndex sites/home.php' /etc/apache2/sites-enabled/000-default.conf

CMD ["/run.sh"]