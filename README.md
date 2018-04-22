# RaspberryPiSecurity
A Simple web interfacce linked with Python and openCV for a cheap solution for home security

Setting up the PI:
	Get raspbian running and get it plugged into ethernet
	Plug in a USB webcam


Get SSH working ASAP
	https://www.raspberrypi.org/documentation/remote-access/ssh/

Install Putty on your computer - to connect to raspberry pi through SSH:
	https://www.putty.org/

ENTER IP - leave port to 22
	use ifconfig in raspberry pi to get it's IP
	Default USER AND PASS:
	pi
	raspberry

	type 'passwd' to change password of pi

sudo apt-get update
sudo apt-get upgrade

Change the timezone and keyboard layout
	http://rohankapoor.com/2012/04/americanizing-the-raspberry-pi/


FTP (Optional, but helps a lot):
	https://www.raspberrypi.org/documentation/remote-access/ftp.md
	Install: https://winscp.net/eng/download.php

setup Apache web server on the pi WITH PHP:
https://www.raspberrypi.org/documentation/remote-access/web-server/apache.md
	To install PHP (if that link did not work):
	sudo apt install php5
	sudo apt install libapache2-mod-php5

	Change the permissions for the www folder so you can change files
		sudo chown -R pi:pi /var/www/

Install MySQL with phpmyadmin
	https://pimylifeup.com/raspberry-pi-mysql-phpmyadmin/

In your PI,


Setting up the Database:
	Go to:
	"IPOFPI/phpmyadmin"  in your browser
	Login with
		username: root
		password: Whatever you set it do while setitng up MySQL with phpmyadmin
	Create a new database called "security"
		Don't add any tables yet
		Select the security database on the left hand side
	Click on Import near the top.
		Choose file -> capture.sql



Setup Python:
	To interact with MySQL with Python:
	sudo apt-get install python-mysqldb
	Install opencv
	sudo apt-get install python-opencv
	Install imutils
	sudo apt-get install python-pip
	pip install --user imutils
	Install Flask
	pip install flask

Download the source.zip
	Let's modify the files to work with your pi!
	open "db.php" - This file stores basic database functions and connects to the database
		On line 6, change the variable "$dbPass" to your pi's phpmyadmin password
			Save the file and close
	open "main.py"
		on line 15, change the "passwd" variable to your pi's phpmyadmin password
			Save the file and close

	open "login.php"
		On line 4, in the if statement, change " $_POST['password']=='raspberry' "
			to be whatever password you want
		Save and close the file

	Upload all of the contects to the PI in /var/www/html/
		Make sure to include the /imgs/ folder - this is where the pictures that are captured are going to be stored
		

Everything should be setup now!
go to your PI's IP address in your browser, and enter the username and password
	(root, and whatever you set it to be when you modified "login.php"

Now, to run the security system, open connect to the pi via SSH, and type in this command:
	python /var/www/html/main.py
