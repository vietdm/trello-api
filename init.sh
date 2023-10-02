#!/bin/bash

dco_path="docker-compose.yml"
nginx_conf_path=".docker/nginx.conf"
config_path="config.txt"

new_line() {
  echo "\n====\n"
}

require_file_exist() {
  if [ ! -f "$1" ]; then
    echo "$1 is not exist!"
    exit 1
  fi
}

check_function_system_exist() {
  if hash $1 2>/dev/null; then
      echo "Function System $1 exist!"
  else
      echo "Please install $1"
      exit 1
  fi
}

convert_file_to_lf() {
  echo "Start convert file to LF ..."
  dos2unix "config.txt"
  dos2unix "docker-compose.yml"
  dos2unix ".docker/nginx.conf"
  sleep .5
  echo "Done!\n"
}

edit_content() {
  perl -pi -e "s/$1/$2/g" $3
}

rm_file() {
  if [ -f "$1" ]; then
    rm "$1"
  fi
}

create_file_with_tmp() {
  rm_file $1
  cp "$1".tmp $1
  sleep .25
}

main() {
  require_file_exist $config_path
  check_function_system_exist "dos2unix"
  check_function_system_exist "perl"

  new_line

  . "$PWD/$config_path"

  echo 'Create docker-compose.yml ...'

  create_file_with_tmp $dco_path
  create_file_with_tmp $nginx_conf_path

  new_line

  convert_file_to_lf

  new_line
  echo 'Replace data ...'
  sleep .75

  # replace docker-compose.yml
  edit_content "SERVICE_NGINX_NAME" "$SERVICE_NGINX_NAME" $dco_path
  edit_content "SERVICE_APP_NAME" $SERVICE_APP_NAME $dco_path
  edit_content "SERVICE_DATABASE_NAME" $SERVICE_DATABASE_NAME $dco_path
  edit_content "SERVICE_PHPMYADMIN_NAME" $SERVICE_PHPMYADMIN_NAME $dco_path
  edit_content "SERVICE_DATABASE_DATA_NAME" $SERVICE_DATABASE_DATA_NAME $dco_path
  edit_content "SERVICE_NGINX_PORT" $SERVICE_NGINX_PORT $dco_path
  edit_content "SERVICE_PHPMYADMIN_PORT" $SERVICE_PHPMYADMIN_PORT $dco_path
  edit_content "NETWORK_NAME" $NETWORK_NAME $dco_path
  edit_content "DATABASE_ROOT_PASSWORD" $DATABASE_ROOT_PASSWORD $dco_path
  edit_content "DATABASE_USERNAME" $DATABASE_USERNAME $dco_path
  edit_content "DATABASE_PASSWORD" $DATABASE_PASSWORD $dco_path
  edit_content "DATABASE_DBNAME" $DATABASE_DBNAME $dco_path

  # replace nginx.conf
  edit_content "NGINX_DOMAIN" $NGINX_DOMAIN $nginx_conf_path
  edit_content "NGINX_MAX_BODY_SIZE" $NGINX_MAX_BODY_SIZE $nginx_conf_path
  edit_content "SERVICE_APP_NAME" $SERVICE_APP_NAME $nginx_conf_path

  echo "\nBuild Docker environment ..."
  docker-compose up --build -d
  docker-compose exec $SERVICE_APP_NAME sh -c "$COMMAND_INIT_LARAVEL"
  mv ./$LARAVEL_TEMP_FOLDER/* .
  mv ./$LARAVEL_TEMP_FOLDER/.* .
  rm -r $LARAVEL_TEMP_FOLDER
  rm -rf .git
  if [ -d .idea ]; then
    rm -rf .idea
  fi
  if [ ! -d vendor ]; then
    docker-compose exec $SERVICE_APP_NAME sh -c "composer install"
  fi
  if [ ! -f .env ]; then
    docker-compose exec $SERVICE_APP_NAME sh -c "cp .env.example .env && php artisan key:generate"
  fi
  docker-compose down

  new_line
  echo "\nDone!\n"
}

main
