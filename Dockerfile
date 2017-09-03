FROM debian:jessie

# Updating packages repositories and installing prerequisite
RUN apt-get update && apt-get install -y \
	curl \
	git \
	unzip \
	wget


RUN echo "deb http://packages.dotdeb.org jessie all" >> /etc/apt/sources.list.d/dotdeb.org.list && \
    echo "deb-src http://packages.dotdeb.org jessie all" >> /etc/apt/sources.list.d/dotdeb.org.list && \
    wget -O- http://www.dotdeb.org/dotdeb.gpg | apt-key add -



    RUN \
      apt-get update && \
      apt-get install -y \
      vim \
      locales \
      iptables \
      php7.0-fpm \
      php7.0-mysql \
      php7.0-gd \
      php7.0-imagick \
      php7.0-dev \
      php7.0-curl \
      php7.0-opcache \
      php7.0-cli \
      php7.0-sqlite \
      php7.0-intl \
      php7.0-tidy \
      php7.0-imap \
      php7.0-json \
      php7.0-pspell \
      php7.0-recode \
      php7.0-common \
      php7.0-sybase \
      php7.0-sqlite3 \
      php7.0-bz2 \
      php7.0-mcrypt \
      php7.0-common \
      php7.0-apcu-bc \
      php7.0-memcached \
      php7.0-redis \
      php7.0-xml \
      php7.0-shmop \
      php7.0-mbstring \
      php7.0-zip \
      php7.0-soap \
      php-pear


# Preparing for installing nodejs
RUN curl -sL  https://deb.nodesource.com/setup_8.x |  bash -


# Installing nodejs and openjdk
RUN apt-get update &&  apt-get install -y nodejs

# Installing gulp npm module globally
RUN npm install -g gulp yarn

# Installing composer globally
RUN export DEBIAN_FRONTEND=noninteractive
RUN curl -sS https://getcomposer.org/installer | php

# Copying current machine /root/.ssh content inside the docker image
RUN mkdir -p /root/.ssh
COPY ssh /root/.ssh/
RUN chmod 600 /root/.ssh/id_rsa