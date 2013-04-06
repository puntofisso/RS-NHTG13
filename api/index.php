<?
include("api.php");
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
    function get($latlong) {
      $res = getCrime($latlong);
      echo $res;
    }
}

class Life {
    function get($postcode) {
      $res = getLife($postcode);
      echo $res;
    }
}

class Headline {
    function get($postcode,$lat,$lon) {
      $res = getHeadline($postcode,$lat,$lon);
      echo $res;
    }
}


Toro::serve(array(
    "/" => "RootHandler",
    "/getSatisfaction/:alpha" => "Satisfaction",
    "/getCrime/:alpha:alpha" => "Crime",
    "/getLife/:alpha" => "Life",
    "/getHeadline/:alpha/:alpha/:alpha" => "Headline",
));
?>
