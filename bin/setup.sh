#!/bin/bash

####
# Run with --non-interactive flag to disable prompts
####

if ! [[ $* == *--non-interactive* ]]
then
	read -p "Have you setup your site/.env  file? " -n 1 -r
	echo    # (optional) move to a new line
	if [[ ! $REPLY =~ ^[Yy]$ ]]
	then
			echo "Setup your site/.env file first.";
	    [[ "$0" = "$BASH_SOURCE" ]] && exit 1 || return 1 # handle exits from shell or function but don't exit interactive shell
	fi
fi

if hash composer;
then
	echo "Installing composer packages"
	composer --working-dir=site/ install
else
	echo "Install composer"
	[[ "$0" = "$BASH_SOURCE" ]] && exit 1 || return 1 # handle exits from shell or function but don't exit interactive shell
fi

if hash npm;
then
	echo "NPM installed"
	cd site/app/themes/genesis/assets
	npm install
	cd ../../../../..
else
	echo "NPM is not installed. You will need nodejs and npm to use this application and run NPM install on the genesis theme assets folder"
fi
