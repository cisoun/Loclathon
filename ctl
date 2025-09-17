#!/bin/bash

init () {
	# Initialize folders.
	init-fs
	# Create database for orders.
	init-db
	# Configure the project.
	init-cfg
}

init-cfg () {
	if [ ! -f config.php ]; then
		cp config.example.php config.php
	fi
}

init-db () {
	if [ ! -f database.db ]; then
		cat statics/database.sql | sqlite3 database.db
	fi
}

init-fs () {
	mkdir -p cache/orders cache/sessions cache/views
}

permissions () {
	if [ $UID -ne 0 ]; then
		echo "error: you need to be root"
		exit 1
	fi
	chmod -R 770 .
	chmod 660 config.php database.db
}

serve () {
	port=${2:-3000}
	php -S "127.0.0.1:$port" index.php
}

photos_previews () {
	for album in statics/photos/*; do
		if [ -d $album ]; then
			mkdir -p $album/min
			for i in $album/*.jpg; do
				preview=$album/min/$(basename $i)
				if [ ! -e $preview ]; then
					echo "Processing $i..."
					gm convert $i \
						-resize 300x300^ \
						-gravity Center \
						-crop 300x300+0+0 \
						-quality 60 \
						$preview
				fi
			done
		fi
	done
}

shop_previews () {
	cd statics/img/shop
	for i in *.jpg; do
		name=$(basename $i)
		echo "Generating $name..."
		gm convert -size 300x300 $i -resize 400x400 small/$name
	done
	echo "Done."
}

usage () {
	echo "Usage: $(basename $0) <COMMAND>

Commands:
  init             Initialize project (run all init-* commands + permissions).
  init-cfg         Initialize configuration.
  init-db          Initialize database.
  init-fs          Initialize folder structure.
  permissions      Fix the permissions of the folder.

  serve            Serve the project.

  photos-previews  Generate previews of photos.
  shop-previews    Generate previews of articles.
"
}

case ${1:-"usage"} in
	"init")            init ;;
	"init-cfg")        init-cfg ;;
	"init-db")         init-db ;;
	"init-fs")         init-fs ;;
	"permissions")     permissions ;;
	"serve")           serve $@;;
	"photos-previews") photos_previews ;;
	"shop-previews")   show_previews ;;
	*)                 usage ;;
esac