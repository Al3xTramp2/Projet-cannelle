<?php

namespace Supalta\Cannelle\utils;

use Supalta\Cannelle\utils\validators\User;

class Auth
{

    private $link2 =[
        "secretaire" => 257,

    ]

    private $link[
        "secretaire" => [
            "pompier" => [
                "C" => false,
                "R" => true,            //il est possible de faire de cette façons mais on peut faire avec les bits comme les professionnels
                "U" => false,
                "D" => false,
                "Rd" => true
            ],
        ],
    ];

    


    /**
     * Check if user exist in DB, and login
     * @param string $log
     * @param string $password
     * @return User|null
     */
    public static function login(string $log, string $password): ?User{
        //TODO: check user exist with dao
        // TODO : create sessions and store defined data in session
        //TODO: log action to log file...
    }

    /**
     * @return void
     */
    public static function logout():void{
        //on détruit la clé de auth, pas directement la session sinon on vas avoir des problèmes avec les csrf
    }

    /**
     * Check if the user is logged (based on session informations)
     * @return bool
     */
    public static function is_logged(): bool {

    }

    /**
     * @param string $role
     * @return bool
     */
    public static function has(string $role): bool {
        //si on est loggé elle vérifie qu'on a le role définit dans la session
    }

    public static function getRole(string $role): string{
        //renvoie le role de la personne car la méthode has nous dit juste si c'est une secrétaire ou pas
    }

    /**
     * @param string $table
     * @param string $perm
     * @return bool
     */
    public static function can(string $table, string $perm): bool {
        //vérifie qu'on a les privilèges nécessaires sur une table donnée
    }



}