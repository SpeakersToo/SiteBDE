<?php
class Utilisateur {
    public function __construct(private ?int $id, private string $numEtu, private bool $estAdmin, private string $prenom, private string $nom, private string $email, private string $mdp)
    {}

	public function getId(): ?int
	{
		return $this->id;
	}

    public function getNumEtu(): string
    {
        return $this->numEtu;
    }

	public function setNumEtu(string $numEtu): void
    {
        $this->numEtu = $numEtu;
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getMdp(): string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): void
    {
        $this->mdp = $mdp;
    }

    public function __serialize(): array
    {
        return [
			'id' => $this->id,
            'numEtu' => $this->numEtu,
			'estAdmin' => $this->estAdmin,
            'prenom' => $this->prenom,
            'nom' => $this->nom,
            'email' => $this->email
        ];
    }

    public function __unserialize(array $data):void
    {
		$this->id = $data['id'] ?? null;
		$this->numEtu = $data['numEtu'] ?? '';
		$this->estAdmin = $data['estAdmin'] ?? null;
		$this->prenom = $data['prenom'] ?? '';
		$this->nom = $data['nom'] ?? '';
		$this->email = $data['email'] ?? '';
    }
}
?>
