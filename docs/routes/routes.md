Restfull api endpoints:


|          Name           | Method | Scheme | Host |                 Path                 |
|-------------------------|--------|--------|------|--------------------------------------|
| users_list              | GET    | ANY    | ANY  | /api/users                           |
| users_store             | POST   | ANY    | ANY  | /api/users                           |
| users_display           | GET    | ANY    | ANY  | /api/users/{id}                      |
| users_delete            | DELETE | ANY    | ANY  | /api/users/{id}                      |
| groups_list             | GET    | ANY    | ANY  | /api/groups                          |
| groups_store            | POST   | ANY    | ANY  | /api/groups                          |
| groups_display          | GET    | ANY    | ANY  | /api/groups/{id}                     |
| groups_delete           | DELETE | ANY    | ANY  | /api/groups/{id}                     |
| groups_users_list       | GET    | ANY    | ANY  | /api/groups/{groupId}/users          |
| groups_users_associate  | POST   | ANY    | ANY  | /api/groups/{groupId}/users          |
| groups_users_dessociate | DELETE | ANY    | ANY  | /api/groups/{groupId}/users/{userId} |

