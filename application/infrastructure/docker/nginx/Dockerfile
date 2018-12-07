# Configure and start Nginx
FROM nginx
RUN mkdir -p /var/www/html
WORKDIR /var/www/html
ADD infrastructure/docker/nginx/server.conf /etc/nginx/conf.d/default.conf
ADD . /var/www/html
# Install vim
RUN apt-get update -y && apt-get install apt-file -y && apt-file update && apt-get install vim -y
