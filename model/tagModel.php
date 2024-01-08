<?php



class Tag
{
        private $nom_tag;
        public function __construct($nom_tag)
        {
                $this->nom_tag = $nom_tag;         
        }
        public function getNom_tag()
        {
                return $this->nom_tag;
        }
}
?>