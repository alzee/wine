#!/bin/bash
#
# vim:ft=sh

############### Variables ###############

############### Functions ###############

############### Main Part ###############

pushd public/img/

for dir in {node,org,poster,product,withdraw}
do
    pushd $dir
    mogrify -format jpg -path thumbnail -thumbnail 100 -quality 60 *.{jpg,png}
    for i in *.jpg
    do
        convert $i -format jpg -resize 400 -quality 75 $i
        # identify $i
    done
    popd
done

popd
