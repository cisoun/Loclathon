previews:
	cd ./static/img/shop
	for i in *; do
		name=$(basename $i)
		gm convert $i -resize 400x400 small/$name
	done

serve:
	php -S 127.0.0.1:3000 ./index.php