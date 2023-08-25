FROM nginx:1.14-alpine

ARG USERNAME=developer
ARG USER_UID=1000
ARG USER_GID=$USER_UID

# Create the user
RUN groupadd --gid $USER_GID $USERNAME \
    && useradd --uid $USER_UID --gid $USER_GID -m $USERNAME

#COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
#COPY ./docker/nginx/config /etc/nginx/conf.d

USER $USERNAME

WORKDIR /var/www

CMD ["nginx", "-g", "daemon off;"]

#EXPOSE 80 443