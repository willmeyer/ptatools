# PTATools
	
### What

PTATools is an app that I built to help my son's elementary school manage their sign-in/out sheets electronically, on
iPads.
  
The toolset consists of:

* A web app optimized for use on an iPad interface, via a Home Screen bookmark.  
  The idea is you have an iPad in the front office, and that is what school visitors use.  
  This is the _Visitor_ interface.
* A web app for use by front-desk employees, in their desktop browsers, to see who has signed in and out, search, etc.
  This is the _Front-Desk_ interface.

#### A few screenshots

The visitor interface:

![visitor interface](http://www.ptatools.com/img/screenshot-visitor-1.png "Visitor interface")

The front-desk interface:

![alt text](http://www.ptatools.com/img/screenshot-frontdesk-1.png "Front-desk interface")


### Setup and Requirements

The app is web-based, HTML5/JS in PHP, and should be able to run anywhere you can host PHP and get to a Mongo database.
For Mongo, I use and recommend [MongoHQ]{http://www.mongohq.com).
	
In theory, the app is usable by others, though the branding is specific to my son's school and there's not anything like
the kind of pluggable interface you'd want there.  

If you want to use it as a starting point, though, feel free.  The only thing you really need to do to get something 
basic working, once you have a Mongo DB created, is edit `config.inc.php` for your deployment. 

I'll set up a demo site at some point, probably.


#### Hit Me Up

Do you too struggle with whether or not to get involved in your kids' school IT debacles? [@willmeyer](http://www.twitter.com/willmeyer) is best.

_Thanks to [@forgetfoo](https://github.com/forgetfoo) for some CSS help_

