# VibertClientInfo
VibertClientInfo returns all information contained in User Agent in JSON format.

Example of use:

```php
...

$ClientInfo = new VibertClientInfo();
$AssociativeArray = json_decode($ClientInfo->getClientInfo(), true);

var_dump($AssociativeArray);

...
```
