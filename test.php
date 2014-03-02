<?php
include_once('LocationsService.php');
include_once('User.php');

 = test1;
 = admin;
 = meh;
 = new AccessToken(whatever);
 = new User(, , , );

 = new LocationsService();
print json_encode(->getLocations(, 1393731020114));
