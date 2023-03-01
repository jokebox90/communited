FROM php:8.2

# ENV SYMFONY_INSTALL_VERSION "6.2.*"

COPY ./docker/install.sh /usr/libexec/docker/install
RUN chmod +x /usr/libexec/docker/install
RUN /usr/libexec/docker/install

WORKDIR /webapp
COPY ./supervisor.conf /etc/supervisor/conf.d/webapp.conf
COPY ./composer.json /webapp/composer.json
COPY ./package.json /webapp/package.json

COPY ./docker/build.sh /usr/libexec/docker/build
RUN chmod +x /usr/libexec/docker/build
RUN /usr/libexec/docker/build

COPY ./docker/entrypoint.sh /usr/libexec/docker/entrypoint
RUN chmod +x /usr/libexec/docker/entrypoint

COPY ./docker/run.sh /usr/libexec/docker/run
RUN chmod +x /usr/libexec/docker/run

EXPOSE 8000

CMD [ "/usr/libexec/docker/run" ]
ENTRYPOINT [ "/usr/libexec/docker/entrypoint" ]