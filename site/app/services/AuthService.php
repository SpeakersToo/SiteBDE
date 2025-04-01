<?php
require_once './app/trait/AuthTrait.php';
require_once './app/repositories/UtilisateurRepository.php';
class AuthService {

    use AuthTrait;

    public function getUtilisateur():?Utilisateur
    {
        if(session_status() == PHP_SESSION_NONE)
            session_start();
        return unserialize($_SESSION['utilisateur']);
    }

    public function setUtilisateur(Utilisateur $utilisateur): void
    {
        if(session_status() == PHP_SESSION_NONE)
            session_start();
        $_SESSION['utilisateur'] = serialize($utilisateur);
    }

    public function logout(): void
    {
        session_destroy();
    }

    public function isLoggedIn(): bool {
        if(session_status() == PHP_SESSION_NONE)
            session_start();
        return isset($_SESSION['utilisateur']);
    }
}
