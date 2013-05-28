Guano (αlpha)
=====

Guano - a small set of scripts that helps you build an audience on Twitter, automagically.

Guano runs off of the already established 'team follow back' process that already exists within twitter and thrives off of other peoples vanity.

Guano isn't recommended for personal Twitter accounts, however building up a large number of followers may help with your personal gains if people value a number of followers over quality.

Quick Installation
=====

Lets get Guano running in less than 10mins with these easy steps!

1. Download Guano from Github here.
2. Upload it to your webspace or put it somewhere that can execute php.
3. Head over to Twitter Developers and create an application
    1. Log in using your Twitter account that you're going to run Guano on
    2. Click your icon from the top right and choose 'My Applications'
    3. Create a new application
    4. Give it a unique name, description. You don't need to specify a call back URL
    5. Click settings tab
    6. Change the Application Type to 'Read, Write and Access direct messages'.
    7. Click Updated this Twitter application's settings
    8. Click the details tab
    9. Scroll to the bottom, click 'Create my access token'
4. Copy 'poop.sample.php' to 'poop.php' and open it in your editor of choice
5. Copy the keys from step 3 into the first 4 fields of poop.php
6. Edit the search term if you need to
7. Within your webhost, set up a cron job to execute poop.php every 20 minutes
8. Sit back, relax and watch your twitter followers grow :)


What is heartbeat and autoupdate?
=====
Heartbeat sends details about your instance of Guano to us so we can track usage, and more importantly in future versions we can deliver lists of followers directly to you that 100% follow back.

The auto-updater makes sure you're always running the latest version of Guano direct from Github. Check the version.json file for references.
