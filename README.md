![flopspot Logo](/public/assets/logo.svg)

# Overview 

This is an **open-source** project mainly written in **Laravel/Vue.js**. flopspot provides the opportunity to rate the WiFi functionality 
in **DB** trains only. The satisfaction of the user will be represented as a statistic using **Chart.js.** 

# Getting started
```
git clone https://github.com/djumla/flopspot.git
```

```
composer install
```

```
npm install
```
Parses the db xml files and stores stations and train numbers into the database
```
php artisan db:parse
```
You may want to generate some fake ratings
```
php artisan db:seed --class=RatingTableSeeder
```

# Links

[Twitter](https://twitter.com/FlopspotDE)
[Facebook](https://www.facebook.com/Flopspot-160124607925841/)
[flopspot API](https://www.flopspot.de/swagger/dist/index.html)
