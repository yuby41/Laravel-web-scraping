#!/bin/bash
echo "=== Diagnóstico de conexión SSH MySQL ==="

# 1. Acceder a la VM
vagrant ssh << 'VAGRANT_EOF'
echo "1. Verificando usuarios MySQL..."
mysql -u root -psecret << 'MYSQL_EOF'
-- Mostrar todos los usuarios homestead
SELECT user, host FROM mysql.user WHERE user = 'homestead';

-- Mostrar privilegios para localhost
SHOW GRANTS FOR 'homestead'@'localhost';

-- Si no existe, crearlo
CREATE USER IF NOT EXISTS 'homestead'@'localhost' IDENTIFIED BY 'secret';
GRANT ALL PRIVILEGES ON *.* TO 'homestead'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;
MYSQL_EOF

echo -e "\n2. Verificando configuración MySQL..."
sudo grep -E "(bind-address|socket)" /etc/mysql/mysql.conf.d/mysqld.cnf

echo -e "\n3. Verificando que MySQL escucha en 127.0.0.1:3306..."
sudo netstat -tlnp | grep :3306

echo -e "\n4. Probando conexión local desde dentro de la VM..."
mysql -h 127.0.0.1 -u homestead -psecret -e "SHOW DATABASES;" | grep prova
VAGRANT_EOF

echo -e "\n5. Probando túnel SSH manual..."
echo "Ejecuta en otra terminal:"
echo "ssh -L 3307:127.0.0.1:3306 -N vagrant@192.168.56.56"
echo "Luego en otra: mysql -h 127.0.0.1 -P 3307 -u homestead -psecret -e 'SHOW DATABASES;'"
