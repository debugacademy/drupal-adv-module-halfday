FROM gitpod/workspace-mysql

USER gitpod

RUN sudo apt-get -q update && \
    sudo apt-get install -y tig && \
    sudo rm -rf /var/lib/apt/lists/*

RUN sudo apt-get purge composer -y; exit 0

RUN mkdir ~/bin
RUN echo 'export PATH=$PATH:~/bin:${GITPOD_REPO_ROOT}/vendor/bin' >> ~/.bashrc
RUN echo 'alias launch="gp preview $(drush uli --uri=$(gp url 8888))"' >> ~/.bashrc
RUN echo 'alias uli="drush uli --uri=$(gp url 8888)"' >> ~/.bashrc
RUN echo 'alias composer=~/bin/composer' >> ~/.bashrc

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar ~/bin/composer
RUN curl -OL https://github.com/vrana/adminer/releases/download/v4.7.8/adminer-4.7.8.php && \
    mv adminer-4.7.8.php ~/bin/adminer.php
