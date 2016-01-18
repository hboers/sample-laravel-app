KUNDENNAME Application
=======================

 

Installation des Systems
------------------------

### Pakete und Laravel

-   Anmelden als root user

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
cd /usr/src
apt-get install git curl php5-curl php5-cli php5-mcrypt php5-mysql
curl -sS https://getcomposer.org/installer | sudo php
mv composer.phar /usr/bin/composer
cd
composer global require "laravel/installer=~1.1"
composer create-project laravel/laravel app --prefer-dist 4.2
apt-get install libapache2-mod-php5 mongodb-server
a2enmod rewrite
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

In Mysql die Datenbank anlegen

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
CREATE DATABASE `weber` DEFAULT CHARACTER SET utf8;
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

php mongodb Erweiterung installieren

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
apt-get install php5-dev php-pear
pecl install mongo
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

In die Datei /etc/php5/conf.d/20-mongo.ini

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
extension=mongo.so
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

eintragen und apache neu starten

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
service apache2 restart
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

**Für das Entwicklungssystem zusätzlich:**

-   apt-get install php5-xdebug

### Einrichten der Website

Im web root Verzeichnis die index.html Datei ersetzten und eine Datei index.php
anlegen

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
<?php header("location:<KUNDENNAME>");
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Einen Symlink auf der public Verzeichnis anlegen

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
ln -s /home/…/app/public app
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Wenn die Laravel Startseite nicht angezeigt wir bitte die apache log dateien
prüfen. Vermutlich müssen noch Berechtigungen für einzelne Projektverzeichnisse
angepasst werden.

Apache Virtual Host
-------------------

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
<VirtualHost *:80>
        ServerAdmin mail@wolkig.biz
        DocumentRoot /var/www/app
        <Directory />
                Options FollowSymLinks
                AllowOverride None
        </Directory>
        <Directory /var/www/app>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Order allow,deny
                allow from all
        </Directory>
        ErrorLog \${APACHE_LOG_DIR}/error.log
        # Possible values include: debug, info, notice, warn, error, crit,
        # alert, emerg.
        LogLevel warn
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

 

Laravel Erweiterungen
---------------------

Die nachfolgenden Erweiterungen werden im Projekt verwendet. Details zu den
Paketen findet man unter [github.com][1]

[1]: <http://github.com>

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
"zizaco/entrust": "dev-laravel-5",
"toin0u/geotools-laravel": "~1.0",
"caouecs/laravel4-lang": "~2.0",
"khill/fontawesomephp" : "1.0.x",
"rmasters/culpa": "dev-master",
"zofe/rapyd": "2.0.*"
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 

Gemeindedaten Karten und Geocoding
----------------------------------

### Karten

Voraussetzungenf für Verwendung von Google Maps sind die [Google Maps
Lizenzbedingungen][2]. Damit ist ohne Lizenzzahlung keine Verwendung der Google
Maps Daten für eine Unternehmensanwendung möglich

[2]: <https://developers.google.com/maps/licensing>

Voraussetzungen für die Verwendung von Bing Maps muss noch geprüft werden

Voraussetzungen für die Verwendung von OpenStreetMap muss noch geprüft werden

 

### GV100 Daten

Diese Daten des Statistischen Bundesamtes werden als asc Datei in dem Mysql
Datenbank importiert. Die Hierarchy wird über Views abgebildet. Lieder enthalten
die Daten keine Geolocations

[GV100 ASC Daten und Beschreibung][3]

[3]: <https://www.destatis.de/DE/ZahlenFakten/LaenderRegionen/Regionales/Gemeindeverzeichnis/Administrativ/Archiv/GV100ADQ/GV100AD1QAktuell.zip>

### openGeoDB Daten

Geolocations für die Postleitzahlen werden pber die openGeoDB Daten
bereitgestellt. Zum Import in MySQL werden die von der Firma Lichtblau zur
Verfügung gestellten, aufbereiteten SQL Daten verwendet

[openGeoDB SQL][4]

[4]: <http://www.lichtblau-it.de/downloads>

### Kartendarstellung

Die Darstellung der Karten erfolt mit Hilfe des Google Maps API. Aus
obengenannten Lizenzgründen werde allerdings Kartendaten über OpenStreetMap
bereitgestellt.

 
