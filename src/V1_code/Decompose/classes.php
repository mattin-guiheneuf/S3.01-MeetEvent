<?php

// Contenu de classes.php

// Classes

class Evenement {
    private $id;
    private $tags;

    public function __construct($id, $tags) {
        $this->id = $id;
        $this->tags = $tags;
    }

    public function getId() {
        return $this->id;
    }

    public function getTags() {
        return $this->tags;
    }

    // Ajoutez d'autres méthodes au besoin
}

class Utilisateur {
    private $id;
    private $tags;

    public function __construct($id, $tags) {
        $this->id = $id;
        $this->tags = $tags;
    }

    public function getId() {
        return $this->id;
    }

    public function getTags() {
        return $this->tags;
    }

    // Ajoutez d'autres méthodes au besoin
}

class Tag {
    // ... (Contenu de la classe Tag)
}

class Mot {
    // ... (Contenu de la classe Mot)
}

class Recommandation {
    // ... (Contenu de la classe Recommandation)
}

// Autres classes...

?>
