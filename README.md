# iTech
Twitter API test for ITech


Once cloned run:

- composer install
- mv .env.example .env
- to run out of box, web server will need to point to: [your-path]/master/public

The app won't run if he .env file is not present.

Brief description

- The app loads my screen name by deafult "mmb000"

- you can add any screen name and press "update widget" to load the feed.

- Widget checks for a new tweet on the screen name account every 30 secs.

- If no new tweet is found will alert the user

- If a new tweet is found will refresh the widget.

- No database is used.
