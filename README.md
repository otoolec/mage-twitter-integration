# Magento Twitter Integration #

A quick and dirty application to demonstrate how Magento Webhooks could be used to provide a service that integrates with twitter.

## Setup ##

### Make sure composer.phar is installed ###

You can install composer.phar using one of the following commands: 
*nix: `curl -s http://getcomposer.org/installer | php`
Windows: Follow the instructions at http://getcomposer.org/download/

### Install dependencies ###
Run the following command to install our dependencies (such as silex)
`composer.phar install`

### Configure Twitter Credentials ###
1. Copy the `twitter_credentials.yml.dist` file to `twitter_credentials.yml`
2. Update the yml file with your credentials.

## Usage ##

Create a webhook in Magento and point it to this endpoint `http://<domain>/<install_root>/web/index.php/endpoint`
