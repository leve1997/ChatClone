<?php
$db_user = 'student';
$db_pass = 'pass.mysql';
$dbname = 'leveric';
$db_base = 'mysql:host=rp2.studenti.math.hr;dbname=' . $dbname . ';charset=utf8';

class DB
{
    private static $db = null;

    final private function __construct()
    {
    }
    final private function __clone()
    {
    }

    public static function getConnection()
    {
        // Ako još nismo spajali na bazu, uspostavi konekciju.
        if (DB::$db === null) {
            global $db_base, $db_user, $db_pass;
            try {
                DB::$db = new PDO($db_base, $db_user, $db_pass);

                // Ako želimo da funkcije poput prepare, execute bacaju exceptione:
                DB::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                DB::$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $e) {
                exit('Greška prilikom spajanja na bazu:' . $e->getMessage());
            }
        }

        // Vrati novostvorenu ili od ranije postojeću konekciju.
        return DB::$db;
    }
};
