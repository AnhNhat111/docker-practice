<?php
class generateSSL
{
    private $domain;
    private $author;
    private $directory;
    public function __construct($domain, $author)
    {
        $this->domain = $domain;
        $this->author = $author;
        $this->directory = "$domain/$domain";

        if (!file_exists($this->domain)) {
            mkdir($this->domain,0775, true);
            mkdir("$this->domain/log",0775, true);
        }
    }

    public function generateFileOpenSSL()
    {
        $myfile = fopen("$this->domain/openssl.cnf", "w") or die("Unable to open file!");
        $content = "
            [req]
            default_bits = 2048
            prompt = no
            encrypt_key = yes
            distinguished_name = req_distinguished_name
            
            [req_distinguished_name]
            C = VN
            ST = Ho Chi Minh City
            L = Ho Chi Minh City
            O = $this->author
            OU = IT
            CN = $this->domain 
            
            [v3_ca]
            subjectKeyIdentifier = hash
            authorityKeyIdentifier = keyid,issuer:always
            basicConstraints = critical,CA:FALSE";

        fwrite($myfile, trim($content));
        fclose($myfile);
    }

    public function generateFileDomainExtension()
    {
        $domainExtensionFile = fopen("$this->directory.ext", "w") or die("Unable to open file $this->domain" . "ext !");

        $extContent = "
            authorityKeyIdentifier = keyid,issuer
            basicConstraints = CA:FALSE
            keyUsage = digitalSignature, nonRepudiation, keyEncipherment, dataEncipherment
            subjectAltName = @alt_names
            [alt_names]
            DNS.1 = $this->domain
            IP.1 = 127.0.0.1";

        fwrite($domainExtensionFile, trim($extContent));
        fclose($domainExtensionFile);
    }

    public function generateFileCmd()
    {
        $cmdFile = fopen("$this->domain/command.cmd", "w") or die("Unable to open file cmd!");
        $cmdContent = "
            openssl genrsa -out $this->domain/CA.key 2048
            openssl req -x509 -sha256 -new -nodes -days 3650 -key $this->domain/CA.key -out $this->domain/CA.pem --config $this->domain/openssl.cnf
            openssl genrsa -out $this->directory.key 2048
            openssl req -new -key $this->directory.key -out $this->directory.csr --config $this->domain/openssl.cnf
            openssl x509 -req -in $this->directory.csr -CA $this->domain/CA.pem -CAkey $this->domain/CA.key -CAcreateserial -days 3650 -sha256 -extfile $this->directory.ext -out $this->directory.crt";

        fwrite($cmdFile, trim($cmdContent));
        fclose($cmdFile);
        exec("$this->domain\command.cmd");
    }

    public function generateFileHost()
    {
        try {
            $this->generateFileOpenSSL();
            $this->generateFileDomainExtension();
            $this->generateFileCmd();
            $this->writeLog("test");
            return 'success !';
        } catch (Exception $e) {
            echo "<pre>";
            print_r($e->getMessage());
            echo "<pre>";
            die('Nhat is debuing...');
        }
    }

    public function writeLog(string $message)
    {
        $log  = "User: ".' - '.date("F j, Y, g:i a").PHP_EOL.
            "Attempt: " . json_encode($message) . PHP_EOL .
            "User: Testing" . PHP_EOL .
            "-------------------------" . PHP_EOL;

        file_put_contents("$this->domain/log/log_" . date("j.n.Y") . ".log", $log, FILE_APPEND);
    }
}

$ssl = new generateSSL('nhat.test.edu.vn', 'Anh Nhat');
$ssl->generateFileHost();