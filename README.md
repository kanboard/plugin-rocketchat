RocketChat plugin for Kanboard
==============================

[![Build Status](https://travis-ci.org/kanboard/plugin-rocketchat.svg?branch=master)](https://travis-ci.org/kanboard/plugin-rocketchat)

Receive Kanboard notifications on [RocketChat](https://rocket.chat/).

![RocketChat](https://cloud.githubusercontent.com/assets/323546/12873674/abde70a0-cd91-11e5-81cb-bba95fc48a73.png)

You can configure RocketChat notifications for a project or for each individual Kanboard user.

Author
------

- Frédéric Guillot
- License MIT

Requirements
------------

- Kanboard >= 1.0.37
- RocketChat

Installation
------------

You have the choice between 3 methods:

1. Install the plugin from the Kanboard plugin manager in one click
2. Download the zip file and decompress everything under the directory `plugins/RocketChat`
3. Clone this repository into the folder `plugins/RocketChat`

Note: Plugin folder is case-sensitive.

Configuration
-------------

### RocketChat configuration

- Generate a new webhook url
- Go to **Administration > Integrations > New Integration > Incoming Webhook**
- You can override the channel later if required

### Kanboard configuration

#### Individual notifications

1. Copy and paste the webhook url into **Integrations > RocketChat** in your
   user profile 
2. Enable RocketChat notifications in your user profile or project settings
3. Enjoy!

#### Project notification

1. Copy and paste the webhook url into **Integrations > RocketChat** in the
   project settings
2. Add the channel name (Optional)
3. Enable RocketChat notification in the project
4. Enjoy!
