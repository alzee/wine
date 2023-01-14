#!/bin/bash
#
# vim:ft=sh

############### Variables ###############

############### Functions ###############

############### Main Part ###############

target_width=400
target_height=200
target_quality=75

pushd public/img/

for dir in {node,org,product,withdraw}
do
    pushd $dir

    if [ $dir = 'withdraw' ]; then
        target_width=800
        target_quality=85
    fi

    mogrify -format jpg -resize $target_width -quality $target_quality *.{jpg,png} && rm *.png

    # Crop height if is org/product/node image
    if [ $dir != 'withdraw' ]; then
        for i in *.jpg
        do
            height=$(identify -format '%[fx:h]' $i)
            # Only crop if greater than $target_height
            if [ $height -gt $target_height ]; then
                to_shave=$(php -r "echo ($height-$target_height)/2;")
                mogrify -shave 0x$to_shave $i
            fi
        done
    fi

    mogrify -format jpg -path thumbnail -thumbnail 100 -quality 60 *.jpg
    popd
done

popd
