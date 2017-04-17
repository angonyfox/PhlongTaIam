FROM gcr.io/google_appengine/php

ENV DOCUMENT_ROOT=${APP_DIR}/public \
    NGINX_CONF_INCLUDE=config/docker/nginx-app.conf \
    PHP_INI_OVERRIDE=config/docker/php-app.ini

# Workaround for AUFS-related permission issue:
# See https://github.com/docker/docker/issues/783#issuecomment-56013588
RUN cp -R ${APP_DIR} ${APP_DIR}-copy; rm -r ${APP_DIR}; mv ${APP_DIR}-copy ${APP_DIR}; chmod -R 550 ${APP_DIR}; chown -R root.www-data ${APP_DIR}

RUN chmod u+w,g+w ${APP_DIR}/cache
RUN chmod u+w,g+w ${APP_DIR}/logs
RUN chmod u+w,g+w ${APP_DIR}/output

RUN ln -sf ${APP_DIR}/vendor/twbs/bootstrap/dist ${APP_DIR}/public/assets/vendor/bootstrap
RUN ln -sf ${APP_DIR}/vendor/kartik-v/bootstrap-fileinput ${APP_DIR}/public/assets/vendor/bootstrap-fileinput
RUN ln -sf ${APP_DIR}/vendor/components/jquery ${APP_DIR}/public/assets/vendor/jquery
