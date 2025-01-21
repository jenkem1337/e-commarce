<?php
require 'vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;


function executeCommand(string $command): void {
    echo "Executing: $command\n";
    $output = [];
    $exitCode = null;
    exec($command, $output, $exitCode);

    if ($exitCode !== 0) {
        echo "Command failed with exit code $exitCode.\n";
        echo implode("\n", $output);
        exit($exitCode);
    }

    echo implode("\n", $output) . "\n";
}


$eCommerceAppDockerEnv = <<<EOT
DB_SERVER_NAME="mysql-database"
DB_NAME="e-commerce-db"
DB_USER = "root"
DB_PASSWORD = "rootpassword"
DB_SERVER_PORT = 3306
APP_PORT = 8000
REDIS_HOST = "refresh-token-cache"
REDIS_PORT = 6379
OBJECT_STORAGE_HOST = "http://minio"
OBJECT_STORAGE_PORT = 9000
OBJECT_STORAGE_URL = "http://minio:9000"
OBJECT_STORAGE_KEY = "ipEnuuW2ucXZUWE8C1Bg"
OBJECT_STORAGE_SECRET = "q9Ljh9Nnmy7VqAX0H85UmzDz4PcC8SqOIkXGBuXS"
CHECKOUT_READ_SERVICE_URI  = "http://checkout-read-service:3000"
CHECKOUT_WRITE_SERVICE_URI = "http://checkout-write-service:3000"
KAFKA_HOST = async-processor-broker:9092
EMAIL="admin@ecommerce.com"
SECRET_KEY="$2y$10\$YZM.npx0LPKqbmQjzWNTWeqX06MUkm6wtsS2jxdDtasWWXFzNhuES"
EOT;
file_put_contents('.env.docker', $eCommerceAppDockerEnv);

$actualProjectFolder = getcwd();

$checkoutServiceWriteFolder = __DIR__."/checkout-service/write-side";
$checkoutServiceReadFolder  = __DIR__."/checkout-service/read-side";

executeCommand("git clone https://github.com/jenkem1337/checkout-service.git");

chdir($checkoutServiceWriteFolder);

$checkoutWriteSideEnv = <<<EOT
JWT_SECRET_TOKEN=$2y$10\$YZM.npx0LPKqbmQjzWNTWeqX06MUkm6wtsS2jxdDtasWWXFzNhuES
POSTGRES_HOST=checkout-postgres-database
POSTGRES_DB_NAME=checkout_service_write_db
POSTGRES_USERNAME=postgres
POSTGRES_PASSWORD=admin
POSTGRES_PORT=5432
MESSAGE_QUEUE_PORT=9092
MESSAGE_QUEUE_HOST=checkout-projection-broker
E_COMMARCE_MONOLITH_SERVICE=http://php-proxy:80
APP_PORT=3000
EOT;
file_put_contents('.env.docker', $checkoutWriteSideEnv);

executeCommand("docker build -t checkout-write-side .");

chdir($checkoutServiceReadFolder);
$checkoutReadSideEnv = <<<EOT
JWT_SECRET_TOKEN=$2y$10\$YZM.npx0LPKqbmQjzWNTWeqX06MUkm6wtsS2jxdDtasWWXFzNhuES
MONGO_CLIENT=mongodb://root:password@checkout-mongo-database:27017/
MONGO_DB_NAME=checkout_db
MESSAGE_QUEUE_PORT=9092
MESSAGE_QUEUE_HOST=checkout-projection-broker
REDIS_PORT=6379
REDIS_HOST=idempotent-message-cache
APP_PORT=3000
EOT;
file_put_contents('.env.docker', $checkoutReadSideEnv);

executeCommand("docker build -t checkout-read-side .");
chdir($actualProjectFolder);

$virtualHostConfig = <<<EOT
<VirtualHost *:80>
    DocumentRoot /var/www/html

    # Authorization başlığını doğru şekilde ayarlamak
    SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=\$1
    
    # Web uygulamanızın kök dizini için izinler
    <Directory /var/www/html>
        AllowOverride All
        Require all granted
    </Directory>

    # PHP dosyalarını PHP-FPM üzerinden işlemeyi sağlamak
    <FilesMatch \.php$>
        SetHandler "proxy:fcgi://php-backend-fpm:9000"
    </FilesMatch>
</VirtualHost>
EOT;

file_put_contents("000-default.conf", $virtualHostConfig);


executeCommand("docker build -f Dockerfile.PHP-Proxy -t php-ecommerce-apache-proxy .");
executeCommand("docker build -f Dockerfile.PHP-FPM -t php-ecommerce-fpm-backend .");
executeCommand("docker build -f Dockerfile.AsyncProcessorBrokerController -t php-ecommerce-async-processor .");


//executeCommand("docker volume create ecommerce-volume");
//executeCommand("docker network create mysql-db-net");
//executeCommand("docker container run -d -it -v ecommerce-volume:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=rootpassword -e MYSQL_USER=myuser -e MYSQL_PASSWORD=mypassword -e MYSQL_DATABASE=e-commerce-db --name temp-db --network mysql-db-net mysql:latest");
//sleep(15);
//executeCommand("type .\\e-commarce.sql | docker exec -i temp-db mysql -u root -prootpassword e-commerce-db");
//executeCommand("docker container rm -f temp-db");
//executeCommand("docker network rm mysql-db-net");
//
//executeCommand("docker volume create minio-volume");
//executeCommand("docker volume create postgres-checkout-service-volume");
//executeCommand("docker volume create mongodb-checkout-service-volume");
$eCommarceComposeData = [
    "services" => [
        //ecommarce mysql database service
        "mysql-database" => [
            "image" => "mysql:latest",
            "environment" => [
                "MYSQL_ROOT_PASSWORD" => "rootpassword",
                "MYSQL_PASSWORD" => "mypassword",
                "MYSQL_DATABASE" => "e-commerce-db",
                "MYSQL_USER" => "myuser"
            ],
            "volumes" => [
                "./e-commarce.sql:/docker-entrypoint-initdb.d/e-commarce.sql",
                "ecommerce-volume:/var/lib/mysql"
            ],
            "networks" => ["e-commarce-network"]
        ],
        'phpmyadmin' => [
            'image' => 'phpmyadmin/phpmyadmin:latest',
            'environment' => [
                'PMA_HOST' => 'mysql-database',
                'PMA_PORT' => '3306',
                'PMA_USER' => 'root',
                'PMA_PASSWORD' => 'rootpassword',
            ],
            'ports' => [
                '8082:80',
            ],
            'networks' => [
                'e-commarce-network',
            ],
        ],
    
        "checkout-postgres-database" => [
            "image" => "postgres:16-alpine",
            "environment" => [
                "POSTGRES_USER" => "postgres",
                "POSTGRES_PASSWORD" => "admin",
                "POSTGRES_DB" => "checkout_service_write_db"
            ],
            "volumes"=>[
                "postgres-checkout-service-volume:/var/lib/postgresql/data"
            ],
            "networks" => ["e-commarce-network"],
            "expose" => [
                "5432"
            ]
        ],
        "checkout-mongo-database" => [
            "image" => "mongo:latest",
            "environment" => [
                "MONGO_INITDB_ROOT_USERNAME" => "root",
                "MONGO_INITDB_ROOT_PASSWORD" => "password",
                "MONGO_INITDB_DATABASE" => "checkout_db"
            ],
            "networks" => ["e-commarce-network"],
            "volumes" => ["mongodb-checkout-service-volume:/data/db"],
            "expose" => ["27017"]
        ],
        "mongo-express" => [
            'image' => 'mongo-express',
            'restart' => 'always',
            'ports' => [
                '8081:8081',
            ],
            'environment' => [
                'ME_CONFIG_MONGODB_ADMINUSERNAME' => 'root',
                'ME_CONFIG_MONGODB_ADMINPASSWORD' => 'password',
                'ME_CONFIG_MONGODB_PORT' => 27017,
                'ME_CONFIG_MONGODB_SERVER' => "checkout-mongo-database",
                'ME_CONFIG_BASICAUTH_USERNAME' => "root",
                "ME_CONFIG_BASICAUTH_PASSWORD" => "root",
                "ME_CONFIG_MONGODB_ENABLE_ADMIN" => "true"
            ],
            "networks" => ["e-commarce-network"],
        ],
        //php-proxy service
        "php-proxy" => [
            "image" => "php-ecommerce-apache-proxy",
            "ports" => ["8000:80"],
            "depends_on" => ["async-processor-broker","php-backend-fpm", "minio", "mysql-database","refresh-token-cache"],
            "networks" => ["e-commarce-network"],
            "environment" => ["APP_ENV" => "docker"],
            "restart" => "always"

        ],
        "php-backend-fpm" => [
            "image" => "php-ecommerce-fpm-backend",
            "networks" => ["e-commarce-network"],
            "depends_on" => ["async-processor-broker","minio", "mysql-database","refresh-token-cache"],
            "environment" => ["APP_ENV" => "docker"],
            "restart" => "always"
        ],
        "php-async-processor-consumer" => [
            "image" => "php-ecommerce-async-processor",
            "networks" => ["e-commarce-network"],
            "depends_on"=>["async-processor-broker", "php-proxy", "php-backend-fpm", "mysql-database"],
            "environment" => ["APP_ENV" => "docker"],
            "restart" => "always"
        ],
        'async-processor-broker' => [
            'image' => 'apache/kafka:latest',
            'environment' => [
                'KAFKA_NODE_ID' => 1,
                'KAFKA_PROCESS_ROLES' => 'broker,controller',
                'KAFKA_LISTENERS' => 'PLAINTEXT://async-processor-broker:9092,CONTROLLER://async-processor-broker:9093',
                'KAFKA_ADVERTISED_LISTENERS' => 'PLAINTEXT://async-processor-broker:9092',
                'KAFKA_CONTROLLER_LISTENER_NAMES' => 'CONTROLLER',
                'KAFKA_LISTENER_SECURITY_PROTOCOL_MAP' => 'CONTROLLER:PLAINTEXT,PLAINTEXT:PLAINTEXT',
                'KAFKA_CONTROLLER_QUORUM_VOTERS' => '1@async-processor-broker:9093',
                'KAFKA_OFFSETS_TOPIC_REPLICATION_FACTOR' => 1,
                'KAFKA_TRANSACTION_STATE_LOG_REPLICATION_FACTOR' => 1,
                'KAFKA_TRANSACTION_STATE_LOG_MIN_ISR' => 1,
                'KAFKA_GROUP_INITIAL_REBALANCE_DELAY_MS' => 0,
                'KAFKA_NUM_PARTITIONS' => 3,
                'KAFKA_AUTO_CREATE_TOPICS_ENABLE' => true,
            ],
            'networks' => [
                'e-commarce-network',
            ],
            'expose' => [
                '9092',
                '9093',
            ],
            "restart" => "always"
        ],
        'checkout-projection-broker' => [
            'image' => 'apache/kafka:latest',
            'environment' => [
                'KAFKA_NODE_ID' => 1,
                'KAFKA_PROCESS_ROLES' => 'broker,controller',
                'KAFKA_LISTENERS' => 'PLAINTEXT://checkout-projection-broker:9092,CONTROLLER://checkout-projection-broker:9093',
                'KAFKA_ADVERTISED_LISTENERS' => 'PLAINTEXT://checkout-projection-broker:9092',
                'KAFKA_CONTROLLER_LISTENER_NAMES' => 'CONTROLLER',
                'KAFKA_LISTENER_SECURITY_PROTOCOL_MAP' => 'CONTROLLER:PLAINTEXT,PLAINTEXT:PLAINTEXT',
                'KAFKA_CONTROLLER_QUORUM_VOTERS' => '1@checkout-projection-broker:9093',
                'KAFKA_OFFSETS_TOPIC_REPLICATION_FACTOR' => 1,
                'KAFKA_TRANSACTION_STATE_LOG_REPLICATION_FACTOR' => 1,
                'KAFKA_TRANSACTION_STATE_LOG_MIN_ISR' => 1,
                'KAFKA_GROUP_INITIAL_REBALANCE_DELAY_MS' => 0,
                'KAFKA_NUM_PARTITIONS' => 3,
                'KAFKA_AUTO_CREATE_TOPICS_ENABLE' => true,
            ],
            'networks' => [
                'e-commarce-network',
            ],
            'expose' => [
                '9092',
                '9093',
            ],
            "restart" => "always"
        ],
        'checkout-write-service' => [
            'image' => 'checkout-write-side',
            'ports' => [
                '3000:3000',
            ],
            'restart' => 'always',
            'networks' => [
                'e-commarce-network',
            ],
            'environment' => [
                'NODE_ENV=docker',
            ],
            'depends_on' => [
                'checkout-projection-broker',
                'checkout-postgres-database',
            ]
        ],
        'checkout-read-service' => [
            'image' => 'checkout-read-side',
            'ports' => [
                '3001:3000',
            ],
            'restart' => 'always',
            'environment' => [
                'NODE_ENV=docker',
            ],
            'networks' => [
                'e-commarce-network',
            ],
            'depends_on' => [
                'checkout-projection-broker',
            ],
        ],
        'minio' => [
            'image' => 'minio/minio',
            'ports' => [
                '9000:9000',
                '9001:9001',
            ],
            'environment' => [
                'MINIO_ROOT_USER' => 'ROOTNAME',
                'MINIO_ROOT_PASSWORD' => 'CHANGEME123',
            ],
            'volumes' => [
                'minio-volume:/data',
            ],
            'command' => 'server /data --console-address ":9001"',
            'networks' => [
                'e-commarce-network',
            ],
        ],
        'mailhog' => [
            'image' => 'mailhog/mailhog',
            'container_name' => "mailhog",
            'ports' => [
                '1025:1025',
                '8025:8025',
            ],
            'networks' => [
                'e-commarce-network',
            ]
        ],
        'refresh-token-cache' => [
            'image' => 'redis:7-alpine',
            'expose' => [
                '6379',
            ],
            'networks' => [
                'e-commarce-network',
            ],
        ],
        'idempotent-message-cache' => [
            'image' => 'redis:7-alpine',
            'expose' => [
                '6379',
            ],
            'networks' => [
                'e-commarce-network',
            ],
        
        ]
    ],
    "volumes" => [
        "ecommerce-volume" => null,
        "minio-volume" => null,
        "postgres-checkout-service-volume" => null,
        "mongodb-checkout-service-volume" => null

    ],
    "networks" => [
        "e-commarce-network" => null
    ]
];

$yamlContent = Yaml::dump($eCommarceComposeData, 2, 4);
file_put_contents('compose.yaml', $yamlContent);
