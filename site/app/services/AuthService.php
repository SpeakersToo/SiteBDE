<?php
require_once './app/trait/AuthTrait.php';
require_once './app/repositories/UtilisateurRepository.php';
require_once './app/entities/Utilisateur.php';

class AuthService {

    use AuthTrait;

    public function getUtilisateur():?Utilisateur
    {
        if(session_status() == PHP_SESSION_NONE)
            session_start();

		if (!isset($_SESSION['utilisateur'])) {
			return null;
		}

		$utilisateur = unserialize($_SESSION['utilisateur']);
		
		return ($utilisateur instanceof Utilisateur) ? $utilisateur : null;
    }

    public function setUtilisateur(Utilisateur $utilisateur): void
    {
        if(session_status() == PHP_SESSION_NONE)
            session_start();
        $_SESSION['utilisateur'] = serialize($utilisateur);
    }

    public function logout(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		unset($_SESSION['utilisateur']);
		
		session_destroy();
    }

    public function isLoggedIn(): bool {
        if(session_status() == PHP_SESSION_NONE)
            session_start();
        return isset($_SESSION['utilisateur']);
    }

	public function estAdmin(): bool
	{
		$utilisateur = $this->getUtilisateur();
		return $utilisateur && $utilisateur.estAdmin();
	}
}
