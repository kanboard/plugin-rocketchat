RocketChat plugin for Kanboard
==============================

[![Build Status](https://travis-ci.org/kanboard/plugin-rocketchat.svg?branch=master)](https://travis-ci.org/kanboard/plugin-rocketchat)

Receive Kanboard notifications on [RocketChat](https://rocket.chat/).

You can configure RocketChat notifications for a project or for each individual Kanboard user.

Author
------

- Frédéric Guillot
- License MIT

Installation
------------

- Decompress the archive in the `plugins` folder

or

- Create a folder **plugins/RocketChat**
- Copy all files under this directory

Configuration
-------------

### RocketChat configuration

- Generate a new webhook url
- Go to **Administration > Integrations > New Integration > Incoming Webhook**

### Kanboard configuration

1. Copy and paste the webhook url in **Integrations > RocketChat** (user profile or project settings)
2. Enable RocketChat notifications in your user profile or project settings
3. Enjoy!
