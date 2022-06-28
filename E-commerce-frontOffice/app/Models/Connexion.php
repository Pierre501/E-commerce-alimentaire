<?php

namespace App\Models;

use CodeIgniter\Model;

class Connexion extends Model
{
    public function dbConnexion()
    {
        $host = 'localhost';
    	$dbname = 'e_commerce';
   		$username = 'admin';
    	$password = 'admin';
        $dsn = "host=$host port=5432 dbname=$dbname user=$username password=$password";
        $connexion = pg_connect($dsn);
		return $connexion;
    }
}
