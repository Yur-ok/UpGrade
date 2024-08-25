FROM ubuntu:22.04

# Устанавливаем SSH-сервер
RUN apt-get update && apt-get install -y openssh-server

# Создаем директорию для SSH-демона
RUN mkdir /var/run/sshd
RUN mkdir /root/.ssh

# Устанавливаем пароль для пользователя root
RUN echo 'root:root' | chpasswd

# Разрешаем вход под root
RUN sed -i 's/#PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config

# Открываем порт 22 для SSH
EXPOSE 22

# Запускаем SSH-сервер
CMD ["/usr/sbin/sshd", "-D"]
