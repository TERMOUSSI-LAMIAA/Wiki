<?php



class Categorie
{
        private $nom_cat;
        private $cat_date;
        public function __construct($nom_cat, $cat_date)
        {
                $this->nom_cat = $nom_cat;
                $this->cat_date = $cat_date;
        }
        /**
         * Get the value of nom_cat
         */ 
        public function getNom_cat()
        {
                return $this->nom_cat;
        }

        /**
         * Get the value of cat_date
         */ 
        public function getCat_date()
        {
                return $this->cat_date;
        }
}
?>