import MySQLdb
import cv2
import imutils
import os, os.path
import numpy as np
import time
import datetime

from threading import Thread
from flask import Flask, render_template, Response


db = MySQLdb.connect(host="localhost",    # your host, usually localhost
                     user="root",         # your username
                     passwd="raspberry",  # your password
                     db="security")        # name of the data base
cur = db.cursor()


class Camera():
	def __init__(self):
		self.camera = cv2.VideoCapture(0)
		self.video=self.camera.read()[1]
		self.video = imutils.resize(self.video, width=500)
		gray = cv2.cvtColor(self.video, cv2.COLOR_BGR2GRAY)
		gray = cv2.GaussianBlur(gray, (21, 21), 0)
		self.firstFrame = gray
		self.found=False

	def __del__(self):
		self.camera.release()
	
	def start(self):
		self.video=self.camera.read()[1]
		self.video = imutils.resize(self.video, width=500)
		gray = cv2.cvtColor(self.video, cv2.COLOR_BGR2GRAY)
		gray = cv2.GaussianBlur(gray, (21, 21), 0)
		self.firstFrame = gray
		

	def step(self):
		# Read next image
		self.video=self.camera.read()[1]
		self.video = imutils.resize(self.video, width=500)
		gray = cv2.cvtColor(self.video, cv2.COLOR_BGR2GRAY)
		gray = cv2.GaussianBlur(gray, (21, 21), 0)
		frameDelta = cv2.absdiff(self.firstFrame, gray)
		thresh = cv2.threshold(frameDelta, 25, 255, cv2.THRESH_BINARY)[1]
		thresh = cv2.dilate(thresh, None, iterations=2)
		(cnts,hierarchy) = cv2.findContours(thresh.copy(), cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
		self.found=False
		for c in cnts:
			# if the contour is too small, ignore it
			if cv2.contourArea(c) < 1000:
				continue
			self.found=True
			break
		cv2.putText(self.video, datetime.datetime.now().strftime("%A %d %B %Y %I:%M:%S%p"),
        (10, self.video.shape[0] - 10), cv2.FONT_HERSHEY_SIMPLEX, 0.35, (0, 0, 255), 1)
			
			

		
	def get_frame(self):
		return self.video,self.found

	def get_frame_diff(self):
		return cv2.imencode('.jpg',self.diff)[1].tobytes()


		
class Live():
	def __init__(self):
		self.img=-1;
	def get_frame(self):
		global camera;
		self.img=camera.get_frame()[0]
		self.img = imutils.resize(self.img, width=500)
		ret, jpeg = cv2.imencode('.jpg',self.img)
		return jpeg.tobytes()
	
		
class Timer():
	def __init__(self):
		self.lookUpDelay=30
		self.lookUp=self.lookUpDelay
		self.result=False
	def step(self):
		tday=datetime.datetime.today()
		day=((tday.weekday()+1)%7)+1
		hour=tday.hour
		minute=tday.minute
		t=hour+(minute/60)
		
		self.lookUp+=1
		#Get if it should be looking
		if self.lookUp>self.lookUpDelay:
			self.lookUp=0
			sql="SELECT * FROM time WHERE DayID="+str(day)+" AND start<"+str(t)+" AND end>"+str(t)+";"
			cur.execute(sql)
			if len(cur.fetchall())==0:
				self.result=False
			else:
				self.result=True
		
		return self.result

		


camera=Camera()
timer=Timer()



app = Flask(__name__)

@app.route('/')
def index():
    return render_template('index.html')

def gen(cam):
	while True:
		frame = cam.get_frame()
		yield (b'--frame\r\n'
			b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n\r\n')


@app.route('/video_feed')
def video_feed():
	return Response(gen(Live()),
		mimetype='multipart/x-mixed-replace; boundary=frame')

		
thread = Thread(target = app.run, args = ('0.0.0.0', 5000))
thread.start()




cntsTotal=0
timeTotal=1
timing=1
try:
	while True:
		start_time = time.time()
		
		if (timer.step()==True):
			camera.step()
			img,found=camera.get_frame()
			
			if found==True:
				DIR = 'imgs'
				a=len([name for name in os.listdir(DIR) if os.path.isfile(os.path.join(DIR, name))])
				file="imgs/"+str(a)+".jpg"
				print file
				cv2.imwrite(file,img)
				cur.execute("""INSERT INTO capture VALUES(null,null,%s);""",(file))
				db.commit()
				timing=0
			timing+=1
			timeTotal+=1

			#Reset after 120 frames
			if timing>60:
				camera.start()
				print "Reset base level - low activity"
				timing=0
		
		sleepTime=1-(time.time() - start_time)
		if sleepTime>0:
			time.sleep(sleepTime)
except KeyboardInterrupt:
	thread.join()

db.close()