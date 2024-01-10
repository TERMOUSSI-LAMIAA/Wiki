<?php



class Wiki
{
        private $id_w;
        private $titre;
        private $contenu;
        private $wiki_date;
        private $isArchive;
        private $img;
        private $fk_aut_email;
        private $fk_cat;

        private $tags;
        public function __construct($id_w, $titre, $contenu, $wiki_date, $isArchive, $img, $fk_aut_email, $fk_cat)
        {
                $this->id_w = $id_w;
                $this->titre = $titre;
                $this->contenu = $contenu;
                $this->wiki_date = $wiki_date;
                $this->isArchive = $isArchive;
                $this->img = $img;
                $this->fk_aut_email = $fk_aut_email;
                $this->fk_cat = $fk_cat;
        }

        public function setTags($tags)
        {
            $this->tags = $tags;
        }
        /**
         * Get the value of id_w
         */
        public function getId_w()
        {
                return $this->id_w;
        }

        /**
         * Get the value of titre
         */
        public function getTitre()
        {
                return $this->titre;
        }

        /**
         * Get the value of contenu
         */
        public function getContenu()
        {
                return $this->contenu;
        }

        /**
         * Get the value of wiki_date
         */
        public function getWiki_date()
        {
                return $this->wiki_date;
        }

        /**
         * Get the value of isArchive
         */
        public function getIsArchive()
        {
                return $this->isArchive;
        }

        /**
         * Get the value of img
         */
        public function getImg()
        {
                return $this->img;
        }

        /**
         * Get the value of fk_aut_email
         */
        public function getFk_aut_email()
        {
                return $this->fk_aut_email;
        }

        /**
         * Get the value of fk_cat
         */
        public function getFk_cat()
        {
                return $this->fk_cat;
        }

        /**
         * Get the value of tags
         */ 
        public function getTags()
        {
                return $this->tags;
        }
}
?>