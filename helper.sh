#!/usr/bin/env bash

#VERSION=1.0.2
ARG_CMD=$1;

case $ARG_CMD in

  help)
    echo "Commande :";
    echo "  * install         : Run docker install and composer";
    echo "  * help            : show all command available for this script";
    echo "  * enter_container : enter in the container convertvideo";
    echo "  * run             : run project for dev env";
    echo "  * stop            : stop project for dev env";
    echo "  * rebuild         : Rebuild all project (no cache)";
    ;;

  install)
       docker-compose up --build -d &&
       xdg-open http://localhost:8080
    ;;

  enter)
    ./inc/enterContainer.sh
    ;;

  run)
    docker-compose up -d;
    xdg-open http://localhost:8080/views
    ;;

  stop)
    docker-compose down;
    ;;

  rebuild)
    docker-compose build --no-cache
    ;;
  *)
    echo -n "unknown command"
    ;;

esac
