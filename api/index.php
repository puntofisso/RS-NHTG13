<?
include("api.php");
include("api2.php");
require("Toro.php");

class RootHandler {
    function get() {
      echo "chaMPion API v. 2";
    }
}

class Satisfaction {
    function get($postcode) {
      $res = getSatisfaction($postcode);
      echo $res;
    }
}

class Crime {
    function get($postcode) {
      $res = getCrime($postcode);
      echo $res;
    }
}

Toro::serve(array(
    "/" => "RootHandler",
    "/getSatisfaction/:alpha" => "Satisfaction",
    "/getCrime/:alpha" => "Crime",
));
