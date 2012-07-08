## Running tests ##

Run unit & integration tests:

	cd tests
	phpunit ./case/unit

### Selenium tests ###

Download Selenium server (JAR):

	http://selenium.googlecode.com/files/selenium-server-standalone-2.20.0.jar

Run Selenium server:

	java -jar selenium-server-standalone.jar

Run selenium tests:

	cd tests
	phpunit ./case/selenium
