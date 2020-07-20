#!/usr/bin/env bash
VERSION=1.0.1
CONTAINER_NAME="composer_movefile"
CONTAINERID=$(docker ps|grep $CONTAINER_NAME|grep -Po "^..."| head -n 1)

echo enter in container : $CONTAINER_NAME;

CMD="docker exec -it -w /app $CONTAINERID bash";

case "$(uname -s)" in
   Linux)
     echo 'Linux'
     $CMD
     ;;

   CYGWIN*|MINGW32*|MSYS*|MINGW*)
     echo 'MS Windows'
     echo $CMD
     winpty $CMD
     ;;
   *)
     echo 'Other OS'
     $CMD
     ;;
esac
