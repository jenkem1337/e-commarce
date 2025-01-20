<?php

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

executeCommand("docker volume create mysql-volume");
executeCommand("docker container run -d -it -v mysql-volume:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=rootpassword -e MYSQL_USER=myuser -e MYSQL_PASSWORD=mypassword -e MYSQL_DATABASE=e-commarce-db --name mysql-db mysql:latest");
executeCommand("docker exec -it mysql-db mysql -u root -prootpassword e-commarce-db < e-commarce.sql");