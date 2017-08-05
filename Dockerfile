FROM debian:jessie

# Updating packages repositories and installing prerequisite
RUN apt-get update && apt-get install -y \
	curl \
	git \
	php5 \
	php5-curl \
	php5-sqlite \
	php5-xdebug \
	php-pear \
	php5-dev \
	unzip \
	wget

# Preparing for installing nodejs
RUN curl -sL https://deb.nodesource.com/setup_8.x |  bash -

# Adding backports for openjdk-8-jdk
RUN awk '$1 ~ "^deb" { $3 = $3 "-backports"; print; exit }' /etc/apt/sources.list > /etc/apt/sources.list.d/backports.list

# Installing nodejs and openjdk
RUN apt-get update && apt-get install -y nodejs

# Installing gulp npm module globally
RUN npm install -g gulp yarn

# Installing composer globally
RUN export DEBIAN_FRONTEND=noninteractive
RUN curl -sS https://getcomposer.org/installer | php

# Copying current machine /root/.ssh content inside the docker image
RUN mkdir -p /root/.ssh
COPY ssh /root/.ssh/
RUN chmod 600 /root/.ssh/id_rsa