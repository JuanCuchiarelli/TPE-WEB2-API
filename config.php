<?php
// Constantes obligatorias dadas por la cátedra
const MYSQL_USER = 'root';
const MYSQL_PASS = '';
const MYSQL_DB = 'db_buscador_conciertos'; 
const MYSQL_HOST = 'localhost';

function getDBConnection() {
    try {
        // 1. Nos conectamos al servidor para verificar si la base existe
        $pdo = new PDO("mysql:host=" . MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // 2. Si no existe, la creamos
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . MYSQL_DB . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
        
        // 3. Nos conectamos formalmente a la base de datos
        $db = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DB . ";charset=utf8mb4", MYSQL_USER, MYSQL_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // 4. AUTO-DEPLOY REFORZADO (Cada tabla tiene su propio IF NOT EXISTS)
        
        // Tabla de usuarios
        $db->exec("CREATE TABLE IF NOT EXISTS `usuarios` (
            `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(50) NOT NULL UNIQUE,
            `password` varchar(255) NOT NULL,
            PRIMARY KEY (`id_usuario`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // Insertamos el usuario webadmin / admin solo si la tabla está vacía
        $checkUser = $db->query("SELECT id_usuario FROM usuarios WHERE username = 'webadmin'");
        if ($checkUser->rowCount() == 0) {
            $passwordHash = password_hash('admin', PASSWORD_DEFAULT);
            $req = $db->prepare("INSERT INTO `usuarios` (`username`, `password`) VALUES ('webadmin', ?)");
            $req->execute([$passwordHash]);
        }

        // Tabla de bandas (Categorías - Rol B) con IF NOT EXISTS
        $db->exec("CREATE TABLE IF NOT EXISTS `bandas` (
            `id_banda` int(11) NOT NULL AUTO_INCREMENT,
            `nombre` varchar(200) NOT NULL,
            `genero` varchar(200) NOT NULL,
            `pais_de_origen` varchar(200) NOT NULL,
            `img` varchar(300) NOT NULL,
            `descripcion` text NOT NULL,
            PRIMARY KEY (`id_banda`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // Insertamos bandas de prueba iniciales si la tabla quedó vacía
        $checkBandas = $db->query("SELECT id_banda FROM bandas");
        if ($checkBandas->rowCount() == 0) {
            $db->exec("INSERT INTO `bandas` (`id_banda`, `nombre`, `genero`, `pais_de_origen`, `img`, `descripcion`) VALUES 
            (1, 'Divididos', 'Rock', 'Argentina', '', 'La aplanadora del rock.'),
            (2, 'Metallica', 'Thrash Metal', 'Estados Unidos', '', 'Banda legendaria.');");
        }

        // Tabla de conciertos (Ítems - Tu Rol A) con IF NOT EXISTS
        $db->exec("CREATE TABLE IF NOT EXISTS `conciertos` (
            `id_concierto` int(11) NOT NULL AUTO_INCREMENT,
            `fecha` date NOT NULL,
            `lugar` varchar(200) NOT NULL,
            `ciudad` varchar(200) NOT NULL,
            `id_banda` int(11) NOT NULL,
            `precio_platea` int(11) NOT NULL,
            `precio_campo` int(11) NOT NULL,
            `precio_popular` int(11) NOT NULL,
            PRIMARY KEY (`id_concierto`),
            FOREIGN KEY (`id_banda`) REFERENCES `bandas` (`id_banda`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // Insertamos conciertos de prueba iniciales si la tabla quedó vacía
        $checkConciertos = $db->query("SELECT id_concierto FROM conciertos");
        if ($checkConciertos->rowCount() == 0) {
            $db->exec("INSERT INTO `conciertos` (`id_concierto`, `fecha`, `lugar`, `ciudad`, `id_banda`, `precio_platea`, `precio_campo`, `precio_popular`) VALUES
            (1, '2026-10-15', 'Estadio Vélez Sarsfield', 'Buenos Aires', 1, 15000, 10000, 6000),
            (2, '2026-11-20', 'Estadio River Plate', 'Buenos Aires', 2, 45000, 30000, 18000);");
        }
        
        return $db;
        
    } catch (PDOException $e) {
        die("Error de conexión o deploy: " . $e->getMessage());
    }
}
