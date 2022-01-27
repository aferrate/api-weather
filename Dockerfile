FROM composer as builder
WORKDIR /app/
COPY composer.* ./
RUN composer install --ignore-platform-reqs

FROM php:7.3-cli-alpine3.15
ENV KEY "your-key"
ENV KEY_BKP "your-key"
ENV API_URL "https://api.openweathermap.org/data/2.5/"
ENV API_BKP "https://api.openweathermap.org/data/2.5/"
ENV SITE_ROOT "/usr/src/myapp"
COPY --from=builder /app/vendor /usr/src/myapp/vendor
COPY . /usr/src/myapp
WORKDIR /usr/src/myapp