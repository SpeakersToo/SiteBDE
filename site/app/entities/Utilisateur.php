<?php
class Utilisateur {
    public function __construct(private ?int $numEtud, private bool $estAdmin, private string $prenom, private string $nom, private string $mail, private ?string $pwd)
    {}

    public function getNumEtud(): ?int
    {
        return $this->numEtud;
    }

	public function getEstAdmin(): bool
    {
        return $this->estAdmin;
    }

	public function setEstAdmin(bool $estAdmin): void
    {
        $this->estAdmin = $estAdmin;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getMail(): string
    {
        return $this->mail;
    }

    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    public function getPwd(): ?string
    {
        return $this->pwd;
    }

    public function setPwd(?string $pwd): void
    {
        $this->pwd = $pwd;
    }

    public function __serialize(): array
    {
        return [
            'numEtud' => $this->numEtud,
			'estAdmin' => $this->estAdmin,
            'prenom' => $this->prenom,
            'nom' => $this->nom,
            'mail' => $this->mail
        ];
    }

    public function __unserialize(array $data):void
    {
        $this->numEtud = $data['numEtud'];
		$this->estAdmin = $data['estAdmin'];
        $this->prenom = $data['prenom'];
        $this->nom = $data['nom'];
        $this->mail = $data['mail'];
        $this->pwd = $data['pwd'];
    }
}
?>
