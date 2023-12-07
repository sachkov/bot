FROM nginx

COPY ./nginx.conf /etc/nginx/nginx.conf

ENV USER_ID=1000 GROUP_ID=1000

RUN addgroup --gid ${GROUP_ID} user

RUN adduser --disabled-password --gecos '' --uid $USER_ID --gid $GROUP_ID user
