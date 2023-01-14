#!/bin/bash
#
# vim:ft=sh

############### Variables ###############

############### Functions ###############

############### Main Part ###############

target_height=200

pushd public/img/

for dir in {node,org,product,withdraw}
do
    pushd $dir
    mogrify -format jpg -resize 400 -quality 75 *.{jpg,png} && rm *.png

    # Crop height to 200
    for i in *.jpg
    do
        height=$(identify -format '%[fx:h]' $i)
        if [ $height -gt $target_height ]; then
            to_shave=$(php -r "echo ($height-$target_height)/2;")
            mogrify -shave 0x$to_shave $i
        fi
    done

    mogrify -format jpg -path thumbnail -thumbnail 100 -quality 60 *.jpg
    popd
done

popd
