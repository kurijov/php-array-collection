<?php

require("./array.php");

$collection = new ArrayCollection();
$collection->add((object) array("name" => "Vova", "age" => 16));
$collection->add((object) array("name" => "Dima", "age" => 18));
$collection->add((object) array("name" => "Vika", "age" => 23));
$collection->add((object) array("name" => "Vova", "age" => 17));
$collection->add((object) array("name" => "Vova", "age" => 16));



var_dump($collection->data());

# select all items with name "Vova"
# ArrayCollection is returned
$allVovas = $collection->where(array("name" => "Vova")); 

var_dump($allVovas);

# removing from collection all "Vova" items
$collection->remove($allVovas);

var_dump($collection->data());

# get first item
var_dump($collection->first());

# get first item by pattern
var_dump($collection->first(array("age" => 23)));