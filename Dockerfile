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


    RUN apt-get update
    RUN apt-get install -y bash wget git unzip sudo tzdata
    RUN echo "deb-src http://deb.debian.org/debian jessie main" >> /etc/apt/sources.list
    RUN echo "deb-src http://deb.debian.org/debian jessie-updates main" >> /etc/apt/sources.list
    RUN echo "deb-src http://security.debian.org jessie/updates main" >> /etc/apt/sources.list
    RUN apt-get install -y apt-transport-https lsb-release ca-certificates
    RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
    RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" >> /etc/apt/sources.list
    RUN echo "deb-src https://packages.sury.org/php/ $(lsb_release -sc) main" >> /etc/apt/sources.list
    RUN apt-get update




    RUN \
      apt-get update && \
      apt-get install -y \
      vim \
      locales \
      iptables \
      php7.1-fpm \
      php7.1-mysql \
      php7.1-gd \
      php7.1-imagick \
      php7.1-dev \
      php7.1-curl \
      php7.1-opcache \
      php7.1-cli \
      php7.1-sqlite \
      php7.1-intl \
      php7.1-tidy \
      php7.1-imap \
      php7.1-json \
      php7.1-pspell \
      php7.1-recode \
      php7.1-common \
      php7.1-sybase \
      php7.1-sqlite3 \
      php7.1-bz2 \
      php7.1-mcrypt \
      php7.1-common \
      php7.1-apcu-bc \
      php7.1-memcached \
      php7.1-redis \
      php7.1-xml \
      php7.1-shmop \
      php7.1-mbstring \
      php7.1-zip \
      php7.1-soap \
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