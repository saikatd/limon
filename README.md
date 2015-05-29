# LiMON #

![Screenshot](https://bitbucket.org/repo/XLKEzR/images/641155708-Dashboard%20ScreenShot.JPG)

A **light-weight** (~3.25MB) and simple **live** monitoring tool for **real-time monitoring** of performance of **multiple servers** on a **single dashboard**.

------

## Dependancies: ##

- RPM: ssh-pass -v1.0.5 (supplied with the app for convenience)

-------

## Make it Run: ##

its really very easy - just 3 step process!

 - Create a directory under /var/www/html/ - say monitoring_tool__file_name
 - Copy all the repositories to /var/www/html/monitoring_tool__file_name directory of the central monitoring server(the server who is going to host the tool)
 - cd  /var/www/html/monitoring_tool__file_name and run nohup ./ping_test_and_script_generation.sh &

Thats it!! you have done your job. Now its time for him to take over!

*WARNING*
dont forget to run chmod 777 * under the /var/www/html/monitoring_tool__file_name directory to give permissions to the script
 
Inorder to stop the script

 - cd /var/www/html/monitoring_tool__file_name
 - ./shut_down_script

 And Voila!! the backend is not running anymore. However, the browser will continue to show the previously generated data

---------

## Things to do: ##

- Asynch (node.js)?
- Automated Tests & Test cases

---------