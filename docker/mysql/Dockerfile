FROM mysql:5.7
ARG USER_ID
ARG GROUP_ID
RUN if [ ${USER_ID:-0} -ne 0 ] && [ ${GROUP_ID:-0} -ne 0 ]; then \
usermod -u ${USER_ID} mysql && \
groupmod -g ${GROUP_ID} mysql \
;fi
