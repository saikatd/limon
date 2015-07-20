# LiMON #


A **light-weight** and simple **live** monitoring tool for **real-time monitoring** of performance of **multiple servers** on a **single dashboard**.


[**DEMO**](https://live-server-monitor.herokuapp.com/) | [**Installation Instructions**](#installation)

------

## ScreenShot: ##

![ScreenShot](https://raw.github.com/saikatd/limon/master/Dashboard ScreenShot.JPG)

-------

## Installation

### 1. Download LiMON
Download the most recent version of LiMON. Extract the files into directory ``` /var/www/html/ ```. So after this the directory structure will be like this:
```

├── /var/www/html/LiMON
│                 ├── /backend
│                 ├── /css
│                 ├── /font
│                 ├── /jquery
│                 ├── /js
│                 ├── /images
|                 ├── index.php
|                 ├── form_to_ip_list.php
|                 ├── delete_ip_address_from_ip_list.php
│                 └── README.md 

```
### 2. Getting Started  
Below steps have been performed adn tested on Ubuntu 14.04 LTS. Please find the corresponding steps for your own platform/OS:

- RPM: ssh-pass -v1.0.5 (supplied with the app for convenience)

#### PHP
Install PHP
```
sudo apt-get install php5
```
Install sshpass rpm
```
sudo apt-get install -y sshpass rpm
```
#### Apache
Install Apache
```
sudo apt-get install apache2
```
 Finally, restart Apache:
 ```
sudo service apache2 restart
```


## Make it Run: ##

its really very easy - just 2 step process!

 - ``` cd  /var/www/html/LiMON/backend ``` 
 - run ``` nohup ./ping_test_and_script_generation & ```


then browse http://your_server_ip/LiMON

That's it!! you have done your job. Now its time for him to take over!

---------

## Things to do: ##

- Asynch (node.js)?
- Automated Tests & Test cases

---------