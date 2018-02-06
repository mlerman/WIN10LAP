<?php


class store {
  public $users = array();
  
  public function getFriendsListForUser($name) {
    foreach ($this->users as &$value) {
      if($value->name==$name) {
        return $value->friends;
      }
    }
  }

  public function getPurchasesForUser($name) {
    foreach ($this->users as &$value) {
      if($value->name==$name) {
        return $value->items;
      }
    }
  }
  
  public function addUser($user) {
    $this->users[]=$user;
  }
  
  public function recommendItemsForUser($name) {
    $itemCounts = array(); // count "ball", "cup", "box";

    // item of $name should be ignored in the suggested items
    $userItems=$this->getPurchasesForUser($name);
    // get first the list of friends
    $friends=$this->getFriendsListForUser($name);
    // find the items purchased by friends and count them
    foreach ($friends as &$frnd) {
      $friendItems=$this->getPurchasesForUser($frnd);
      $friendItemsMinusUserItems = array_diff($friendItems, $userItems);
    // remove from the list the items that were already purchased by $name
      foreach ($friendItemsMinusUserItems as &$value) {
        $itemCounts[$value]++;              // associative 
      }
    }
    // order the $itemCounts so the highest count show first
    arsort($itemCounts);
    return $itemCounts;
  }
}

class user {
  public $name = array();
  public $items = array();	// items that this user purchased
  public $friends = array();

  public function setName($name) {
    $this->name[]=$name;
  }

  public function addItem($item) {
    $this->items[]=$item;
  }

  public function addFriend($friend) {
    $this->friends[]=$friend;
  }

}

$amazon = new store();

// add some data for test
$usr = new user();
$usr->name = "toto";
$usr->addItem("ball");		// toto bought a ball and a box
$usr->addItem("box");
$amazon->addUser($usr);

$usr = new user();
$usr->name = "tata";		// tata bought a box and a cup
$usr->addItem("box");
$usr->addItem("cup");
$amazon->addUser($usr);

$usr = new user();
$usr->name = "titi";		// titi also bought a cup
$usr->addItem("cup");
$usr->addFriend("toto");	// toto and tata are the friends of titi
$usr->addFriend("tata");
$amazon->addUser($usr);

echo "Showing suggestion of puchases for titi based on friend's purchases";
print_r($amazon->recommendItemsForUser("titi"));

/*

1) The function recommendItemsForUser() is showing in lines 27-46
2) Unit tests is showing in lines 70-91
3) Other unit test senario to check: There is no friends or no purchases. In real world check for realistic data. Example the content may be SPAM.
4) The critical portion of the code is lines 35-42. Searching of matching records. 
   Complexity is n-square through the friend list and item list.
   Space: each object contains the related data. store contains a collection of users.
   Each user object contains a list of items and a list of friends. It is equivalent to a 2 dimension data structure.

Note:
I wrote this for Campling, Duncan for amazon Subject: Interest from Amazon.com   
I have tested this code online at http://codepad.org/ZhaTHnpf     
I used an separate editor notepad++ to write the code.
   
*/


?>