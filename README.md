# apisymfony

This project was developed with symfony 4.2 framework

## Setup
composer install

## Requirements
mysql server

## Run
### Run migrations
In your console run:
`bin/console doctrine:migrations:migrate`

## Run the server
In your console run:
`bin/console server:start`

It will serve on localhost:8000


## DB Diagram
[Diagram](https://github.com/lfpimenta/apisymfony/blob/master/docs/er/Readme.md)


## API

Restfull api endpoints in [here](https://github.com/lfpimenta/apisymfony/blob/master/docs/routes/routes.md)                 

## Domain Diagrams

#### [I can add users](https://github.com/lfpimenta/apisymfony/blob/master/docs/uml/addUser.png)
#### [I delete users](https://github.com/lfpimenta/apisymfony/blob/master/docs/uml/deleteUser.png)
#### [I can add groups](https://github.com/lfpimenta/apisymfony/blob/master/docs/uml/addGroup.png)
#### [I can delete groups](https://github.com/lfpimenta/apisymfony/blob/master/docs/uml/deleteGroup.png)
#### [I can associate users to groups](https://github.com/lfpimenta/apisymfony/blob/master/docs/uml/assignUsersToGroup.png)
#### [I can remove users from groups](https://github.com/lfpimenta/apisymfony/blob/master/docs/uml/removesUserFromGroup.png)
