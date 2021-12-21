
<?php

use PDO as PDO;
use PDOException as PDOException;

class DbContext {
    private static $db = null;

    public static function initialize() {
        if(empty(self::$db)) {
            try {
                self::$db = new PDO('sqlite:DB/database.sqlite');
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
    }

    public static function getInstance() {
        return self::$db;
    }

    public static function generateSchema() {
        $queue = '
        CREATE TABLE IF NOT EXISTS queue (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            timestamp VARCHAR(100) NOT NULL,
            user_name VARCHAR(100) NOT NULL,
            user_lastname VARCHAR(100) NOT NULL,
            email VARCHAR(25) NOT NULL,
            phone INTEGER(12) NOT NULL,
            card VARCHAR(100) NOT NULL,
            id_card INTEGER(12) NOT NULL,
            city VARCHAR(20) NOT NULL,
            concessionaire VARCHAR(100) NOT NULL,
            createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
            sent BOOLEAN DEFAULT 0,
            sentAt DATETIME DEFAULT NULL,
            errorMessage VARCHAR(25) DEFAULT "NULL"
            )';

            $showcase = '
            CREATE TABLE IF NOT EXISTS showcase (
                id INTEGER PRIMARY KEY,
                city VARCHAR(20) NOT NULL,
                concessionaire VARCHAR(250) NOT NULL,
                brand VARCHAR(20) NOT NULL
                )';

            $fill_showcase = 'INSERT INTO showcase (\'id\',\'city\',\'concessionaire\',\'brand\')
                                VALUES
                                (1,\'BOGOTA\',\'NARITA MOTORS CALLE 145 AUTOP NORTE COSTADO OCC\',\'CITROEN\'),
                                (2,\'BOGOTA\',\'DERCOCENTER CALLE 72 CALLE 72 A DOS CUADRAS DE LA AV CARACAS\',\'CITROEN\'),
                                (3,\'BOGOTA\',\'AUTOMOTORES EUROPA ZONA AUTOMOTRIZ MORATO\',\'CITROEN\'),
                                (4,\'BOGOTA\',\'DERCOCENTER CALLE 13 CALLE 13 # 43 - 55\',\'CITROEN\'),
                                (5,\'BOGOTA\',\'DERCOCENTER CALLE 26 AV BOYACA CON CALLE 26\',\'CITROEN\'),
                                (6,\'BOGOTA\',\'LA MAISON CR 11 CON CALLE 99 CHICO\',\'CITROEN\'),
                                (7,\'BOGOTA\',\'AUTONIZA AUTOPISTA NORTE # 221-91\',\'CITROEN\'),
                                (8,\'BOGOTA\',\'DERCOCENTER CRA 7A CARRERA 7 # 129-29\',\'CITROEN\'),
                                (9,\'BOGOTA\',\'COMAGRO Calle 63 A #30-15 Frente al Estadio el Campín\',\'CITROEN\'),
                                (10,\'BOGOTA\',\'DS STORE CR 11 CON CALLE 99 CHICO\',\'DS\'),
                                (11,\'BOGOTA\',\'PETITE DS STORE CR 7A CARRERA 7 # 129-29\',\'DS\'),
                                (12,\'MEDELLIN\',\'VEHICULOS DEL CAMINO CARRERA 43 A # 31-121\',\'CITROEN\'),
                                (13,\'MEDELLIN\',\'AUTOZEN LAS VEGAS CRA 48 NO. 19 SUR 20 AV LAS VEGAS\',\'CITROEN\'),
                                (14,\'CALI\',\'COLEGAS AV. PASOANCHO #77 -99\',\'CITROEN\'),
                                (15,\'CALI\',\'AUTAMA SUR CARRERA 66B # 9-110 SOBRE LA AUTOPISTA SUR\',\'CITROEN\'),
                                (16,\'CALI\',\'AUTAMA NORTE AV 3 NORTE # 60N - 65\',\'CITROEN\'),
                                (17,\'BUCARAMANGA\',\'CENTRAL MOTORS CARRERA 27 # 56 - 24\',\'CITROEN\'),
                                (18,\'CARTAGENA\',\'AUTONORTE CARTAGENA AVENIDA DEL PIE DEL CERRO CALLE 30 # 18A - 152\',\'CITROEN\'),
                                (19,\'CUCUTA\',\'FERSAUTOS DIAGONAL SANTANDER NO. 11-119 BARRIO CAOBOS\',\'CITROEN\'),
                                (20,\'PEREIRA\',\'CASAUTOS AVENIDA 30 DE AGOSTO # 105 - 90\',\'CITROEN\'),
                                (21,\'IBAGUE\',\'DERCOCENTER IBAGUE AV MIROLINDO # 66 - 64\',\'CITROEN\'),
                                (22,\'MANIZALES\',\'ANDINA AUTOMOTRIZ AV ALBERTO MENDOZA 87 - 62\',\'CITROEN\'),
                                (23,\'PASTO\',\'CASA BURALGO AV. PANAMERICANA NO.27-27 BARRIO EL BOSQUE\',\'CITROEN\'),
                                (24,\'MONTERIA\',\'AUTOZEN MONTERIA CALLE 41 NO. 14-151\',\'CITROEN\'),
                                (25,\'BARRANQUILLA\',\'AUTONORTE BARRANQUILLA AVENIDA CIRCUNVALAR CALLE 110 # 43C – 91\',\'CITROEN\'),
                                (26,\'VILLAVICENCIO\',\'ALCALA VILLAVICENCIO CALLE 2 N° 33-79 ANILLO VIAL\',\'CITROEN\'),
                                (27,\'NEIVA\',\'OROCAR AV 26 # 35 - 14\',\'CITROEN\'),
                                (28,\'TUNJA\',\'ALCALA TUNJA CL 52 # 5 - 125, PISO 2\',\'CITROEN\'),
                                (29,\'BOGOTA\',\'ALCALA MOTOR 127 AV CLL. 127 NO. 19-74\',\'SUZUKI\'),
                                (30,\'TUNJA\',\'ALCALA MOTOR TUNJA CL 52 # 5 - 125, PISO 2\',\'SUZUKI\'),
                                (31,\'VILLAVICENCIO\',\'ALCALA MOTOR V/VICENCIO CALLE 2 N° 33-79 ANILLO VIAL\',\'SUZUKI\'),
                                (32,\'YOPAL\',\'ALCALA MOTOR YOPAL CRA 19 NO.21-05\',\'SUZUKI\'),
                                (33,\'ARMENIA\',\'AUTAMA ARMENIA CRA. 19 NO. 7A-52\',\'SUZUKI\'),
                                (34,\'CALI\',\'AUTAMA CALI AV 3 NORTE # 60N - 65\',\'SUZUKI\'),
                                (35,\'CALI\',\'AUTAMA CRA 66 CARRERA 66B # 9-110 SOBRE LA AUTOPISTA SUR\',\'SUZUKI\'),
                                (36,\'BOGOTA\',\'AUTOMOTORES EUROPA -  CRA 70 # 94A-06\',\'SUZUKI\'),
                                (37,\'BOGOTA\',\'AUTONIZA AUTOPISTA NORTE # 221-91\',\'SUZUKI\'),
                                (38,\'BARRANQUILLA\',\'AUTONORTE BARRANQUILLA AVENIDA CIRCUNVALAR CALLE 110 # 43C – 91\',\'SUZUKI\'),
                                (39,\'CARTAGENA\',\'AUTONORTE CARTAGENA AVENIDA DEL PIE DEL CERRO CALLE 30 # 18A - 152\',\'SUZUKI\'),
                                (40,\'SANTA MARTA\',\'AUTONORTE SANTA MARTA AV FERROCARRIL # 29 - 126\',\'SUZUKI\'),
                                (41,\'VALLEDUPAR\',\'AUTONORTE VALLEDUPAR CRA 7A 21-69\',\'SUZUKI\'),
                                (42,\'MONTERIA\',\'AUTOZEN MONTERIA CALLE 41 NO. 14-151\',\'SUZUKI\'),
                                (43,\'SINCELEJO\',\'AUTOZEN SINCELEJO CALLE 25B NO 27B-16 AVENIDA SINCELEJITO\',\'SUZUKI\'),
                                (44,\'MEDELLIN\',\'AUTOZEN LAS VEGAS CRA 48 NO. 19 SUR 20 AV LAS VEGAS\',\'SUZUKI\'),
                                (45,\'PASTO\',\'CASA BURALGO AV. PANAMERICANA NO.27-27 BARRIO EL BOSQUE\',\'SUZUKI\'),
                                (46,\'PEREIRA\',\'CASAUTOS BELMONTE AVENIDA 30 DE AGOSTO # 105 - 90\',\'SUZUKI\'),
                                (47,\'PEREIRA\',\'CASAUTOS OLAYA CRA 14 CALLE 21\',\'SUZUKI\'),
                                (48,\'BUCARAMANGA\',\'CENTRALMOTOR CRA 27 CARRERA 27 # 56 - 24\',\'SUZUKI\'),
                                (49,\'CALI\',\'COLMOTORS DEL VALLE (COLEGAS) AV. PASOANCHO #77 -99\',\'SUZUKI\'),
                                (50,\'BOGOTA\',\'DERCOCENTER CALLE 13 CALLE 13 # 43 - 55\',\'SUZUKI\'),
                                (51,\'BOGOTA\',\'DERCOCENTER CALLE 26 AVENIDA BOYACÁ # 49-25\',\'SUZUKI\'),
                                (52,\'BOGOTA\',\'DERCOCENTER CALLE 72 CALLE 72 NO. 20C -39\',\'SUZUKI\'),
                                (53,\'BOGOTA\',\'DERCOCENTER CENTRO MAYOR CALLE 38A SUR # 34D-51 CARMULTIPLE LOCAL 1-120\',\'SUZUKI\'),
                                (54,\'IBAGUE\',\'DERCOCENTER IBAGUE AV MIROLINDO # 66 - 64\',\'SUZUKI\'),
                                (55,\'MANIZALES\',\'DG ANDINA AUTOMOTRIZ AV ALBERTO MENDOZA 87 - 62\',\'SUZUKI\'),
                                (56,\'CUCUTA\',\'FERSAUTOS DIAGONAL SANTANDER NO. 11-119 BARRIO CAOBOS\',\'SUZUKI\'),
                                (57,\'BOGOTA\',\'NARITA MOTORS CALLE 145 45-15\',\'SUZUKI\'),
                                (58,\'FLORENCIA\',\'OROCAR FLORENCIA CALLE 6 # 11 - 89 LOCAL 2\',\'SUZUKI\'),
                                (59,\'NEIVA\',\'OROCAR NEIVA AV 26 # 35 - 14\',\'SUZUKI\'),
                                (60,\'BOGOTA\',\'DERCOCENTER CRA 7A CARRERA 7 # 129-29\',\'SUZUKI\'),
                                (61,\'MEDELLIN\',\'VEHICULOS DEL CAMINO CARRERA 43 A # 31-121\',\'SUZUKI\'),
                                (62,\'MEDELLIN\',\'AUTOZEN RIO NEGRO MALL AUTOCENTRY KM 6 VIA SAN DIEGO\',\'SUZUKI\'),
                                (63,\'BOGOTA\',\'COMAGRO Calle 63 A #30-15 Frente al Estadio el Campín\',\'SUZUKI\'),
                                (64,\'POPAYAN\',\'VARDI Calle 18N # 6-36\',\'SUZUKI\'),
                                (65,\'BOGOTA\',\'COMAGRO CHIA VARIANTE CAJICÁ-CHÍA KM 2 COSTADO OCC\',\'CITROEN\'),
                                (66,\'BOGOTA\',\'COMAGRO CHIA Variante Cajicá chía # km 2 costado occidental\',\'SUZUKI\'),
                                (68,\'CHIA\',\'COMAGRO CHIA Variante Cajicá chía # km 2 costado occidental\',\'SUZUKI\')';

        try {
            self::$db->exec($queue);
            self::$db->exec($showcase);

            $data = DbService::getAllRows("showcase");
            if(empty($data)){
                self::$db->exec($fill_showcase);
            }

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
