 SSL Certificate Generation and Nginx Configuration Guide

## Generating SSL Certificate

- If you generate SSL using OpenSSL, you can open a terminal in the certs directory and follow the steps below:

# 1. Create the openssl.cnf file in the certs directory and paste the following code:

    ```ini
    [req]
    default_bits = 2048
    prompt = no
    encrypt_key = yes
    distinguished_name = req_distinguished_name

    [req_distinguished_name]
    C = VN
    ST = Ho Chi Minh City
    L = Ho Chi Minh City
    O = Anh Nhat
    OU = IT
    CN = domain

    [v3_ca]
    subjectKeyIdentifier = hash
    authorityKeyIdentifier = keyid,issuer:always
    basicConstraints = critical,CA:FALSE
    ```
# Create CA certificate:
    openssl genrsa -out CA.key 2048
    openssl req -x509 -sha256 -new -nodes -days 3650 -key CA.key -out CA.pem --config openssl.cnf

# Create SSL Certificate Signing Request:
    openssl genrsa -out domain.key 2048
    openssl req -new -key domain.key -out domain.csr --config openssl.cnf

# Content for domain.ext: - paste code on the below

    authorityKeyIdentifier = keyid,issuer
    basicConstraints = CA:FALSE
    keyUsage = digitalSignature, nonRepudiation, keyEncipherment, dataEncipherment
    subjectAltName = @alt_names
    [alt_names]
    DNS.1 = domain
    IP.1 = 127.0.0.1


# Sign SSL certificate:
    openssl x509 -req -in domain.csr -CA CA.pem -CAkey CA.key -CAcreateserial -days 365 -sha256 -extfile domain.ext -out domain.crt

# Add certificates for chorme
    1. chrome://settings/certificates
    2. on tab Authorities -> import -> choosen file CA.pem

note:
change domain to your doamin (ex: test.domain.vn)

# Config domain on directory in directory :
    docker/nginx/conf.d/your-domain

# example file domain config:

    server {
        listen 80;
        index index.php index.html;
        server_name domain;
        root /src/your-project;

        location / {
            try_files $uri $uri/ /index.php?$query_string;
            gzip_static on;
        }
    }

    server {
        listen 443 ssl;
        index index.php index.html;
        server_name doamin
        root /src/your-project;

        # ssl
        ssl_certificate certs/server.crt;
        ssl_certificate_key certs/server.key;

        ssl_protocols       TLSv1 TLSv1.1 TLSv1.2;
        ssl_ciphers         HIGH:!aNULL:!MD5;

        location ~ \.php$ {
            try_files $uri =404;
            fastcgi_split_path_info ^(.+\.php)(/.+)$;
            fastcgi_pass {container-name-source}:9000;
            fastcgi_index index.php;
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_param PATH_INFO $fastcgi_path_info;
        }

        location / {
            try_files $uri $uri/ /index.php?$query_string;
            gzip_static on;
        }
    }

