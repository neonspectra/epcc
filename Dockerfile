# This is meant to run a full version of the creator in standalone mode.
# No external databases or volume mounts required.

FROM node:24-alpine AS node-build
WORKDIR /app
COPY package.json package-lock.json webpack.mix.js ./
COPY resources ./resources
COPY public ./public
RUN npm install
RUN npm run production

FROM php:8.4-fpm-alpine

EXPOSE 80
CMD ["s6-svscan", "/etc/s6"]

HEALTHCHECK --interval=1m --timeout=3s \
    CMD curl -f http://localhost/ || exit 1

RUN apk add --no-cache nginx sqlite s6 curl unzip git \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS libxml2-dev sqlite-dev oniguruma-dev curl-dev mariadb-connector-c-dev \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql fileinfo dom curl mbstring \
    && apk del .build-deps

COPY .docker/s6/ /etc/s6/
COPY .docker/nginx.conf /etc/nginx/

# The timezone must be set or else the pdf exporter, and anything else that uses date functions, will fail.
RUN echo '\ndate.timezone = "UTC"' >> /usr/local/etc/php/php.ini

# Install Composer without pulling in Alpine's php packages.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#########
# Everything after this changes somewhat frequently
#########

# So the RUN commands are done in the proper context
USER www-data:www-data
WORKDIR /var/www/html/

# Actual App
COPY --chown=www-data:www-data . ./
COPY --chown=www-data:www-data --from=node-build /app/public /var/www/html/public

# PHP vendor packages
RUN composer install --no-interaction --no-dev --optimize-autoloader

# SQLite Database prep
ENV DB_DATABASE=/var/www/html/database/database.sqlite
RUN touch $DB_DATABASE && \
    sed -i 's/\\n/ /g' /var/www/html/database/database.sql && \
    sqlite3 --init /var/www/html/database/database.sql $DB_DATABASE

# Optional display-only version info (used by /api/version)
ARG EPCC_DISPLAY_VERSION
ARG EPCC_DISPLAY_VERSION_NAME
ARG EPCC_DISPLAY_COMMIT
ARG EPCC_DISPLAY_RELEASE_DATE
ENV EPCC_DISPLAY_VERSION=$EPCC_DISPLAY_VERSION
ENV EPCC_DISPLAY_VERSION_NAME=$EPCC_DISPLAY_VERSION_NAME
ENV EPCC_DISPLAY_COMMIT=$EPCC_DISPLAY_COMMIT
ENV EPCC_DISPLAY_RELEASE_DATE=$EPCC_DISPLAY_RELEASE_DATE

# Set default mode to standalone
RUN mv standalone.env .env && php artisan key:generate

# Needed for nginx to run
USER root
