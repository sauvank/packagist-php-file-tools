# Sort my media V8

## Required 

* PHP >=7.4
* Composer
* FFMPEG
* PHP-curl
* Key Api TMDB

### Install PHP-curl
* `sudo apt-get install php-curl`

### Install composer
* `sudo apt update;`
* `sudo apt install curl php-cli php-mbstring git unzip`
* `cd ~`
* `curl -sS https://getcomposer.org/installer -o composer-setup.php`
* `sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer`
* `composer`

### Install FFMPEG

* `sudo apt update;`
* `sudo apt install ffmpeg;`
* `ffmpeg -version;`

### How to obtain TMDB api Key

* Create a account or login : https://www.themoviedb.org/s
* Go to : https://www.themoviedb.org/settings/api

## How to run this project ?

* step 1

    Run `./run.sh`


## How sort video ?

* run : `php bin/console sort:video [type] [input folder path] [output folder path]`
    
    * type : manga / serie / movie, type of the video to sort.
    * input folder path : folder to scan for get video to sort.
    * output folder path : folder to move video sort.
    
    exemple : `php bin/console sort:video manga tests/fakeVideos/videos/ tests/fakeVideos/videos`

### Tv show Doc

* Attention ! to sort the series, it is recommended to use this folder structure:
  a folder for each tv Show. The folder can contain more subfolder or simply the files
````  
  TvShowFolder/
   |
   --- ExempleTvShowName/
   |   |
   |   --- multiple files episode
   |
   --- ExempleTvShowName2/
       |
       --- season 01
            |
            --- multiple files episode
````    

#### Utils 

* Create fake video file from fixe.txt contain name ( no extension in the name )
  * run : `php bin/console generate:fake-video [path_file]`
  * exemple : `php bin/console generate:fake-video tests/fakeVideos/manga.txt`
#### Todo

- [ ] Ajout de l'option pour passer au fichier suivant.
- [ ] Ajout de l'option pour donner directement un id tmdb.
- [ ] Possibilité de donner un nom, on passé par TMDB.



#### Memo :

interface : 
https://codepen.io/abdokhaled/pen/YWopQJ

not found :
Peepoodo.01x01.TRUFRENCH.WEBRip.1080p.MKV

probleme avec Cardcaptor Sakura - S01E16 [CC53E931].mkv

Sousei no Aquarion - 00x01 - The Wings of Betrayal
Sousei no Aquarion - 00x02 - The Wings of Glory
Sousei no Aquarion - 01x01 - Memories of an Angel
Sousei no Aquarion -         1000x0100000 - Memories of an Angel
Death Note - S01E02 ~ Confrontation
Death Note - S01E03 ~ Pacte
Death Note - S01E04 ~ Poursuite

/(?<type_1>(?<type_1_name>[\w ]+)(.*)(S|s)(?<type_1_season>\d+)(| +)(E|e)(?<type_1_episode>\d+))|(?<type_2>(?<type_2_name>[\w ]+)(.)([ \-\.])(?<type_2_season>\d+)(x|X)(?<type_2_episode>\d+))/
