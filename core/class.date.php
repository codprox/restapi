<?php 
class DateConverter {
    private $date;
    private $language;

    public function __construct($language = 'en',$date=null) {
        $this->date = ($date!=null)? new DateTime($date):new DateTime("NOW");
        $this->language = $language;
    } 
    public function setDate($date) {
        return $this->date = new DateTime($date);
    } 
    public function getDate($stamp=null) {
        if($stamp!=null){ return $this->date->getTimestamp();}
        else{ return $this->date;}
    } 
    public function setLanguage($language) {
        return $this->language = $language;
    }

    public function convertToFormat($format) {
        return $this->date->format($format);
    } 
    public function toFrench() {
        setlocale(LC_TIME, 'fr_FR.utf8');
        return strftime('%A %d %B %Y', $this->date->getTimestamp());
    } 
    public function toEnglish() {
        setlocale(LC_TIME, 'en_US.utf8');
        return strftime('%A %d %B %Y', $this->date->getTimestamp());
    } 
    public function toHumanReadable() {
        $now = new DateTime();
        $diff = $now->diff($this->date);

        if ($this->language == 'fr') {
            if ($diff->y > 0) {
                return 'il y a ' . $diff->y . ' an(s)';
            } elseif ($diff->m > 0) {
                return 'il y a ' . $diff->m . ' mois';
            } elseif ($diff->d > 0) {
                return 'il y a ' . $diff->d . ' jour(s)';
            } elseif ($diff->h > 0) {
                return 'il y a ' . $diff->h . ' heure(s)';
            } elseif ($diff->i > 0) {
                return 'il y a ' . $diff->i . ' minute(s)';
            } else {
                return 'à l\'instant';
            }
        } else {
            if ($diff->y > 0) {
                return $diff->y . ' year(s) ago';
            } elseif ($diff->m > 0) {
                return $diff->m . ' month(s) ago';
            } elseif ($diff->d > 0) {
                return $diff->d . ' day(s) ago';
            } elseif ($diff->h > 0) {
                return $diff->h . ' hour(s) ago';
            } elseif ($diff->i > 0) {
                return $diff->i . ' minute(s) ago';
            } else {
                return 'just now';
            }
        }
    }

    public function isPast() {
        $now = new DateTime();
        return $this->date < $now;
    } 
    public function isFuture() {
        $now = new DateTime();
        return $this->date > $now;
    } 
    public function isToday() {
        $now = new DateTime();
        return $this->date->format('Y-m-d') === $now->format('Y-m-d');
    } 
    public function differenceFromNow() {
        $now = new DateTime();
        $diff = $now->diff($this->date);

        if ($diff->invert) {
            return $this->language == 'fr' ? 'La date est déjà passée.' : 'The date has already passed.';
        } else {
            if ($this->language == 'fr') {
                if ($diff->y > 0) {
                    return $diff->y . ' an(s) restant(s)';
                } elseif ($diff->m > 0) {
                    return $diff->m . ' mois restant(s)';
                } elseif ($diff->d > 0) {
                    return $diff->d . ' jour(s) restant(s)';
                } elseif ($diff->h > 0) {
                    return $diff->h . ' heure(s) restant(s)';
                } elseif ($diff->i > 0) {
                    return $diff->i . ' minute(s) restant(s)';
                } else {
                    return 'La date est maintenant.';
                }
            } else {
                if ($diff->y > 0) {
                    return $diff->y . ' year(s) remaining';
                } elseif ($diff->m > 0) {
                    return $diff->m . ' month(s) remaining';
                } elseif ($diff->d > 0) {
                    return $diff->d . ' day(s) remaining';
                } elseif ($diff->h > 0) {
                    return $diff->h . ' hour(s) remaining';
                } elseif ($diff->i > 0) {
                    return $diff->i . ' minute(s) remaining';
                } else {
                    return 'The date is now.';
                }
            }
        }
    } 
    public function compare($datePassee) {
        $this->setDate($datePassee);
        if ($this->isPast()) {
            return -1;
        } elseif ($this->isFuture()) {
            return 1;
        } else {
            return 0;
        }
    } 

    public function DateUnixDefault(){
        $DateCnvrt = new DateTime("NOW");
        return $DateCnvrt->getTimestamp();
    }
    public function DateDefault(){
        $dates = date('Y-m-d',$this->DateUnixDefault());
        return $dates;
    } 
    public function DateTimeDefault(){
        $dates = date('Y-m-d H:i:s',$this->DateUnixDefault());
        return $dates;
    } 
    public function addDate($duree,$unite='day',$format=null) {
        $date = new DateTime();
        $date->modify("+$duree $unite");
        return $date->format($format ?? 'd F Y');
    }  
    public function subDate($duree,$unite='day',$format=null) {
        $date = new DateTime();
        $date->modify("-$duree $unite");
        return $date->format($format ?? 'd F Y');
    }
}


// $dateConverter = new DateConverter('fr','2024-08-26 20:06:06');
// echo $dateConverter->convertToFormat('Y-m-d H:i:s'); // 2024-08-26 20:06:06
// echo $dateConverter->toFrench(); // lundi 26 août 2024
// echo $dateConverter->toEnglish(); // Monday 26 August 2024
// echo $dateConverter->toHumanReadable(); // à l'instant (ou selon la différence de temps)
// echo $dateConverter->isPast() ? 'La date est passée.' : 'La date n\'est pas passée.';
// echo $dateConverter->isFuture() ? 'La date est dans le futur.' : 'La date n\'est pas dans le futur.';
// echo $dateConverter->isToday() ? 'La date est aujourd\'hui.' : 'La date n\'est pas aujourd\'hui.';
// echo $dateConverter->differenceFromNow(); // selon la différence de temps

