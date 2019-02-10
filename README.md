# apisymfony

This project was developed with symfony 4.2 framework

## DB Diagram
![DB Diagram](https://github.com/lfpimenta/apisymfony/blob/master/docs/er/ER_Model.png)

## API

|  Name                      | Method    |   Scheme  | Host  | Path                                   
|  groups_list_store         | GET|POST  |   ANY     | ANY   | /api/groups                            
|  groups_delete_show        | GET|DELETE|   ANY     | ANY   | /api/groups/{id}                       
|  groups_users_list_store   | GET|POST  |   ANY     | ANY   | /api/groups/{groupId}/users            
|  groups_users_unassociate  | DELETE    |   ANY     | ANY   | /api/groups/{groupId}/users/{userIds}  
|  users_list_store          | GET|POST  |   ANY     | ANY   | /api/users                             
|  users_delete_display      | GET|DELETE|   ANY     | ANY   | /api/users/{id}                    


