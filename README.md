# LiMON #


A **light-weight** and simple **live** monitoring tool for **real-time monitoring** of performance of **multiple servers** on a **single dashboard**.

------

## ScreenShot: ##

![ScreenShot](https://raw.github.com/saikatd/limon/master/Dashboard ScreenShot.JPG)

-------

## Dependancies: ##

- RPM: ssh-pass -v1.0.5 (supplied with the app for convenience)

-------
## Installation

### 1. Download Linux Dash

Clone the git repo: 
```shell
git clone git@github.com:saikatd/limon.git
```
### 2. Start Linux Dash
See the section for your platform. 
#### PHP
Install PHP
```
sudo apt-get install php5
```
Start sshpass rpm
```
sudo apt-get install -y sshpass rpm
```
#### Apache
Install Apache
```
sudo apt-get install apache2
```



## Make it Run: ##

its really very easy - just 3 step process!

 - Copy
 all the files in /var/www/html/monitoring_tool_name directory of the central monitoring server(the server who is going to host the tool)
 - cd  /var/www/html/monitoring_tool_name/backend and run 
 - run nohup ./ping_test_and_script_generation &

 Finally, restart Apache:
 ```
sudo service apache2 restart
```
than browse http://your_server_ip/monitoring_tool_name

 Thats it!! you have done your job. Now its time for him to take over!

---------

## Things to do: ##

- Asynch (node.js)?
- Automated Tests & Test cases

---------