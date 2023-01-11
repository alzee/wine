#!/bin/bash
#
# vim:ft=sh

############### Variables ###############

############### Functions ###############

############### Main Part ###############

pushd public/img/

for dir in {node,org,product,withdraw}
do
    pushd $dir
    mogrify -format jpg -path thumbnail -thumbnail 100 -quality 60 *.{jpg,png}
    mogrify -format jpg -resize 400 -quality 75 *.{jpg,png}
    rm *.png
    popd
done

popd
